<?php

namespace Modules\Formulir\Controllers;

use Illuminate\Http\Request;
use Modules\Formulir\Models\FormUpload;
use Modules\Formulir\Models\Form;
use Illuminate\Routing\Controller;
use Modules\Formulir\Models\FormResponse;

class FormulirFrontendController extends Controller
{
    public function index()
    {
        $judul = 'Formulir';
        return view('formulir::frontend.index', compact('judul'));
    }

    public function showForm(Form $form)
    {
        if (! $form->is_active) {
            abort(404); // atau bisa redirect dengan pesan error jika mau
        }

        $form->load([
            'questions' => function ($query) {
                $query->orderBy('sort_order');
            },
            'questions.options',
            'themeSetting'
        ]);
        return view('formulir::frontend.show', compact('form'));
    }



    public function submitForm(Request $request, Form $form)
    {
        $rules = [];
        $fileFields = [];

        // ✅ Buat rules validasi
        foreach ($form->questions as $question) {
            $key = "question.{$question->id}";
            if ($question->type === 'file') {
                $fileFields[$question->id] = $question;
                $rules[$key] = ($question->is_required ? 'required' : 'nullable') . '|file|max:10240'; // 10MB
            } elseif ($question->is_required) {
                $rules[$key] = in_array($question->type, ['checkbox'])
                    ? 'required|array|min:1'
                    : 'required';
            }
        }

        $messages = [
            'required' => 'Pertanyaan ini wajib diisi.',
            'array' => 'Pilih minimal satu jawaban.',
            'file' => 'File tidak valid.',
            'max' => 'Ukuran file terlalu besar. Maksimum 10MB.',
        ];

        $validated = $request->validate($rules, $messages);

        // ✅ Ambil pemilik form
        $formOwner = $form->user; // pastikan relasi Form -> User sudah ada

        // ✅ Cek apakah pemilik form sudah hubungkan Google Drive
        if (count($fileFields) && (!$formOwner->google_token || !$formOwner->google_refresh_token)) {
            return redirect()->back()->withErrors([
                'file_upload' => 'Pemilik form belum menghubungkan Google Drive, sehingga file tidak dapat diunggah.',
            ]);
        }

        // ✅ Simpan response baru
        $response = $form->responses()->create([
            'submitted_at' => now(),
        ]);

        $answers = [];

        // ✅ Jawaban non-file
        foreach ($request->input('question', []) as $question_id => $value) {
            $question = $form->questions()->find($question_id);
            if (!$question || $question->type === 'file') continue;

            $answers[] = [
                'question_id' => $question_id,
                'answer' => is_array($value) ? json_encode($value) : $value,
            ];
        }

        // ✅ Upload file ke Google Drive pemilik form
        if (count($fileFields)) {
            // 🔹 Setup Google Client pakai token PEMILIK FORM
            $client = new \Google_Client();
            $client->setApplicationName('SinauCMS Formulir Upload File');
            $client->setAccessType('offline');
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
            $client->setAccessToken([
                'access_token' => $formOwner->google_token,
                'refresh_token' => $formOwner->google_refresh_token,
            ]);

            // 🔹 Refresh token jika sudah expired
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($formOwner->google_refresh_token);
                $newToken = $client->getAccessToken();
                $formOwner->google_token = $newToken['access_token'] ?? $formOwner->google_token;
                $formOwner->save();
            }

            $driveService = new \Google_Service_Drive($client);

            // 🔹 Cek atau buat folder berdasarkan judul form
            $folderName = $form->title;
            $existingFolders = $driveService->files->listFiles([
                'q' => sprintf("mimeType='application/vnd.google-apps.folder' and name='%s' and trashed=false", addslashes($folderName)),
                'spaces' => 'drive',
                'fields' => 'files(id, name)',
            ]);

            if (count($existingFolders->getFiles()) > 0) {
                $folderId = $existingFolders->getFiles()[0]->getId();
            } else {
                $folderMetadata = new \Google_Service_Drive_DriveFile([
                    'name' => $folderName,
                    'mimeType' => 'application/vnd.google-apps.folder',
                ]);
                $createdFolder = $driveService->files->create($folderMetadata, ['fields' => 'id']);
                $folderId = $createdFolder->id;
            }

            // 🔹 Unggah file-file jawaban
            foreach ($fileFields as $qid => $q) {
                if ($request->hasFile("question.$qid")) {
                    $file = $request->file("question.$qid");

                    $fileMetadata = new \Google_Service_Drive_DriveFile([
                        'name' => $file->getClientOriginalName(),
                        'parents' => [$folderId],
                    ]);

                    $content = file_get_contents($file->getRealPath());
                    $uploadedFile = $driveService->files->create($fileMetadata, [
                        'data' => $content,
                        'mimeType' => $file->getClientMimeType(),
                        'uploadType' => 'multipart',
                        'fields' => 'id'
                    ]);

                    // 🔹 Set agar file bisa dibaca siapa saja (link sharing)
                    $driveService->permissions->create($uploadedFile->id, new \Google_Service_Drive_Permission([
                        'type' => 'anyone',
                        'role' => 'reader',
                    ]));

                    $driveLink = "https://drive.google.com/file/d/{$uploadedFile->id}/view";

                    $answers[] = [
                        'question_id' => $qid,
                        'answer' => $driveLink,
                    ];

                    // 🔹 Simpan metadata file ke database
                    FormUpload::create([
                        'response_id' => $response->id,
                        'question_id' => $qid,
                        'file_name' => $file->getClientOriginalName(),
                        'file_mime' => $file->getClientMimeType(),
                        'drive_file_id' => $uploadedFile->id,
                        'drive_file_url' => $driveLink,
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        }

        // ✅ Simpan semua jawaban
        foreach ($answers as $ans) {
            $response->answers()->create($ans);
        }

        // ✅ Kirim ke Google Sheet (optional, tetap pakai token formOwner)
        if ($form->google_sheet_id) {
            try {
                $client = new \Google_Client();
                $client->setApplicationName('SinauCMS Formulir Integration');
                $client->setAccessType('offline');
                $client->setClientId(env('GOOGLE_CLIENT_ID'));
                $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
                $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);
                $client->setAccessToken([
                    'access_token' => $formOwner->google_token,
                    'refresh_token' => $formOwner->google_refresh_token,
                ]);

                if ($client->isAccessTokenExpired()) {
                    $client->fetchAccessTokenWithRefreshToken($formOwner->google_refresh_token);
                    $newToken = $client->getAccessToken();
                    $formOwner->google_token = $newToken['access_token'] ?? $formOwner->google_token;
                    $formOwner->save();
                }

                $service = new \Google_Service_Sheets($client);

                $headers = $form->questions()->pluck('question_text', 'id')->toArray();
                $answersData = $response->answers()->pluck('answer', 'question_id')->toArray();

                $row = [now()->format('Y-m-d H:i:s')];

                foreach ($headers as $qid => $qtext) {
                    $answer = $answersData[$qid] ?? '';
                    $row[] = is_array(json_decode($answer)) ? implode(', ', json_decode($answer)) : $answer;
                }

                $body = new \Google_Service_Sheets_ValueRange([
                    'values' => [$row],
                ]);

                $service->spreadsheets_values->append(
                    $form->google_sheet_id,
                    'Sheet1',
                    $body,
                    ['valueInputOption' => 'RAW']
                );
            } catch (\Exception $e) {
                \Log::error('Gagal mengupdate Google Sheet: ' . $e->getMessage());
            }
        }

        return redirect()->route('form.success', [
            'form' => $form->slug,
            'response' => $response->id,
        ]);
    }




    public function successPage(Form $form, $response)
    {
        $response = $form->responses()->findOrFail($response);

        return view('formulir::frontend.success', [
            'form' => $form,
            'response' => $response,
        ]);
    }
}
