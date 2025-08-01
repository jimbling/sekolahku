<?php

namespace Modules\Formulir\Controllers;

use Illuminate\Http\Request;
use Modules\Formulir\Models\FormUpload;
use Modules\Formulir\Models\Form;
use Illuminate\Routing\Controller;
use Modules\Formulir\Models\FormResponse;
use Modules\Formulir\Services\GoogleDriveService;

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

        //  Validasi pertanyaan & file
        foreach ($form->questions as $question) {
            $key = "question.{$question->id}";
            if ($question->type === 'file') {
                $fileFields[$question->id] = $question;
                $rules[$key] = ($question->is_required ? 'required' : 'nullable') . '|file|max:10240';
            } elseif ($question->is_required) {
                $rules[$key] = in_array($question->type, ['checkbox'])
                    ? 'required|array|min:1'
                    : 'required';
            }
        }

        $validated = $request->validate($rules, [
            'required' => 'Pertanyaan ini wajib diisi.',
            'array'    => 'Pilih minimal satu jawaban.',
            'file'     => 'File tidak valid.',
            'max'      => 'Ukuran file terlalu besar. Maksimum 10MB.',
        ]);

        $formOwner = $form->user;

        //  Buat response baru
        $response = $form->responses()->create(['submitted_at' => now()]);
        $answers = [];

        //  Simpan jawaban non-file
        foreach ($request->input('question', []) as $question_id => $value) {
            $question = $form->questions()->find($question_id);
            if (!$question || $question->type === 'file') continue;

            $answers[] = [
                'question_id' => $question_id,
                'answer' => is_array($value) ? json_encode($value) : $value,
            ];
        }

        /**
         * =====================================
         *   GOOGLE DRIVE (dengan fallback)
         * =====================================
         */
        if (count($fileFields)) {

            //  Inisialisasi Google Drive Service
            $google = new GoogleDriveService($formOwner);

            // 🚨 Kalau token invalid → langsung fallback
            if (!$google->hasValidToken()) {
                \Log::warning('⚠️ Token Google Drive tidak valid. File akan disimpan di server lokal.');
                $this->saveFilesToLocal($request, $fileFields, $response, $answers);
                session()->flash('warning', '⚠️ File disimpan di server lokal karena akun Google Drive pemilik form bermasalah. Hubungkan ulang Google Drive untuk sinkronisasi.');
            } else {
                try {
                    $driveService = $google->drive();

                    // 🔹 cek / buat folder di Drive
                    $folderName = $form->title;
                    $existingFolders = $driveService->files->listFiles([
                        'q' => "mimeType='application/vnd.google-apps.folder' and name='{$folderName}' and trashed=false",
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

                    // 🔹 upload semua file ke Drive
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

                            // 🔹 share agar file bisa diakses
                            $driveService->permissions->create($uploadedFile->id, new \Google_Service_Drive_Permission([
                                'type' => 'anyone',
                                'role' => 'reader',
                            ]));

                            $driveLink = "https://drive.google.com/file/d/{$uploadedFile->id}/view";

                            $answers[] = [
                                'question_id' => $qid,
                                'answer' => $driveLink,
                            ];

                            // simpan metadata file
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
                } catch (\Exception $e) {
                    \Log::error("❌ Gagal upload ke Google Drive: {$e->getMessage()}");
                    $this->saveFilesToLocal($request, $fileFields, $response, $answers);
                    session()->flash('warning', '⚠️ File disimpan di server lokal karena terjadi error saat upload ke Google Drive.');
                }
            }
        }

        //  Simpan semua jawaban
        foreach ($answers as $ans) {
            $response->answers()->create($ans);
        }

        /**
         * =====================================
         *   GOOGLE SHEET (tidak blokir submit)
         * =====================================
         */
        if ($form->google_sheet_id ?? false) {
            try {
                $sheetService = $google->sheets();

                $headers = $form->questions()->pluck('question_text', 'id')->toArray();
                $answersData = $response->answers()->pluck('answer', 'question_id')->toArray();

                $row = [now()->format('Y-m-d H:i:s')];

                foreach ($headers as $qid => $qtext) {
                    $answer = $answersData[$qid] ?? '';
                    $row[] = is_array(json_decode($answer)) ? implode(', ', json_decode($answer)) : $answer;
                }

                $body = new \Google_Service_Sheets_ValueRange(['values' => [$row]]);
                $sheetService->spreadsheets_values->append(
                    $form->google_sheet_id,
                    'Sheet1',
                    $body,
                    ['valueInputOption' => 'RAW']
                );
            } catch (\Exception $e) {
                \Log::error('❌ Gagal update Google Sheet: ' . $e->getMessage());
            }
        }

        return redirect()->route('form.success', [
            'form' => $form->slug,
            'response' => $response->id,
        ]);
    }

    /**
     * 🚨 Helper untuk simpan file lokal (fallback)
     */
    private function saveFilesToLocal($request, $fileFields, $response, &$answers)
    {
        foreach ($fileFields as $qid => $q) {
            if ($request->hasFile("question.$qid")) {
                $file = $request->file("question.$qid");
                $path = $file->store('uploads/formulir');

                $answers[] = [
                    'question_id' => $qid,
                    'answer' => url('storage/' . $path),
                ];

                FormUpload::create([
                    'response_id' => $response->id,
                    'question_id' => $qid,
                    'file_name' => $file->getClientOriginalName(),
                    'file_mime' => $file->getClientMimeType(),
                    'drive_file_id' => 'LOCAL',  //  Ganti dari NULL ke string agar tidak SQL error
                    'drive_file_url' => url('storage/' . $path),
                    'file_size' => $file->getSize(),
                ]);
            }
        }
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
