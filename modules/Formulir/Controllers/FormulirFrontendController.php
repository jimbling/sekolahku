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

        $form->load(['questions.options', 'themeSetting']); // tambahkan relasi ini
        return view('formulir::frontend.show', compact('form'));
    }



    public function submitForm(Request $request, Form $form)
    {
        $rules = [];
        $fileFields = [];

        foreach ($form->questions as $question) {
            $key = "question.{$question->id}";
            if ($question->type === 'file') {
                $fileFields[$question->id] = $question; // Simpan info pertanyaan file
                if ($question->is_required) {
                    $rules["question.{$question->id}"] = 'required|file|max:10240'; // 10MB
                } else {
                    $rules["question.{$question->id}"] = 'nullable|file|max:10240';
                }
            } elseif ($question->is_required) {
                if (in_array($question->type, ['checkbox'])) {
                    $rules[$key] = 'required|array|min:1';
                } else {
                    $rules[$key] = 'required';
                }
            }
        }

        $messages = [
            'required' => 'Pertanyaan ini wajib diisi.',
            'array' => 'Pilih minimal satu jawaban.',
            'file' => 'File tidak valid.',
            'max' => 'Ukuran file terlalu besar. Maksimum 10MB.',
        ];

        $validated = $request->validate($rules, $messages);

        // ✅ Cek: Jika ada pertanyaan file tapi belum login / belum punya token → tolak
        if (count($fileFields) && (!auth()->check() || !auth()->user()->google_token)) {
            return redirect()->back()->withErrors([
                'file_upload' => 'Anda perlu login dan menghubungkan akun Google untuk mengunggah file.',
            ]);
        }

        $response = $form->responses()->create([
            'submitted_at' => now(),
        ]);

        $answers = [];

        // Jawaban non-file
        foreach ($request->input('question', []) as $question_id => $value) {
            $question = $form->questions()->find($question_id);
            if (!$question || $question->type === 'file') continue;

            $answers[] = [
                'question_id' => $question_id,
                'answer' => is_array($value) ? json_encode($value) : $value,
            ];
        }

        // Jawaban file
        if (count($fileFields)) {
            $user = auth()->user();

            $client = new \Google_Client();
            $client->setApplicationName('SinauCMS Formulir Upload File');
            $client->setAccessType('offline');
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
            $client->setAccessToken([
                'access_token' => $user->google_token,
                'refresh_token' => $user->google_refresh_token,
            ]);

            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                $newToken = $client->getAccessToken();
                $user->google_token = $newToken['access_token'] ?? $user->google_token;
                $user->save();
            }

            $driveService = new \Google_Service_Drive($client);

            // Siapkan drive service & nama folder
            $driveService = new \Google_Service_Drive($client);
            $folderName = $form->title;

            // Cek apakah folder dengan nama form sudah ada di Drive
            $existingFolders = $driveService->files->listFiles([
                'q' => sprintf("mimeType='application/vnd.google-apps.folder' and name='%s' and trashed=false", addslashes($folderName)),
                'spaces' => 'drive',
                'fields' => 'files(id, name)',
            ]);

            if (count($existingFolders->getFiles()) > 0) {
                $folderId = $existingFolders->getFiles()[0]->getId();
            } else {
                // Buat folder baru
                $folderMetadata = new \Google_Service_Drive_DriveFile([
                    'name' => $folderName,
                    'mimeType' => 'application/vnd.google-apps.folder',
                ]);
                $createdFolder = $driveService->files->create($folderMetadata, [
                    'fields' => 'id',
                ]);
                $folderId = $createdFolder->id;
            }

            // Lanjut unggah file-file ke dalam folder ini
            foreach ($fileFields as $qid => $q) {
                if ($request->hasFile("question.$qid")) {
                    $file = $request->file("question.$qid");

                    // Metadata file dengan folder target
                    $fileMetadata = new \Google_Service_Drive_DriveFile([
                        'name' => $file->getClientOriginalName(),
                        'parents' => [$folderId], // 👈 disimpan ke dalam folder
                    ]);

                    $content = file_get_contents($file->getRealPath());
                    $uploadedFile = $driveService->files->create($fileMetadata, [
                        'data' => $content,
                        'mimeType' => $file->getClientMimeType(),
                        'uploadType' => 'multipart',
                        'fields' => 'id'
                    ]);

                    // Buat file bisa diakses publik
                    $driveService->permissions->create($uploadedFile->id, new \Google_Service_Drive_Permission([
                        'type' => 'anyone',
                        'role' => 'reader',
                    ]));

                    $driveLink = "https://drive.google.com/file/d/{$uploadedFile->id}/view";

                    $answers[] = [
                        'question_id' => $qid,
                        'answer' => $driveLink,
                    ];

                    // Simpan metadata ke database
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

        // Simpan semua jawaban
        foreach ($answers as $ans) {
            $response->answers()->create($ans);
        }

        // Kirim ke Google Sheet jika terhubung
        if ($form->google_sheet_id && auth()->check()) {
            try {
                $user = auth()->user();

                $client = new \Google_Client();
                $client->setApplicationName('SinauCMS Formulir Integration');
                $client->setAccessType('offline');
                $client->setClientId(env('GOOGLE_CLIENT_ID'));
                $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
                $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);
                $client->setAccessToken([
                    'access_token' => $user->google_token,
                    'refresh_token' => $user->google_refresh_token,
                ]);

                if ($client->isAccessTokenExpired()) {
                    $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                    $newToken = $client->getAccessToken();
                    $user->google_token = $newToken['access_token'] ?? $user->google_token;
                    $user->save();
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
