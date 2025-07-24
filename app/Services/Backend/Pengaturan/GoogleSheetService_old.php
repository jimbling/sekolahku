<?php

namespace App\Services\Backend\Pengaturan;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use Modules\Formulir\Models\Form;
use Illuminate\Support\Facades\Auth;
use Google_Service_Sheets_ClearValuesRequest;

class GoogleSheetService
{
    public static function syncGoogleSheet(Form $form)
    {
        $user = Auth::user();
        $client = new Google_Client();
        $client->setAccessType('offline');
        $client->setApplicationName('SinauCMS Formulir Integration');
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

        $service = new Google_Service_Sheets($client);

        // Ambil header dari Sheet
        $headerResponse = $service->spreadsheets_values->get($form->google_sheet_id, 'Sheet1!A1:Z1');
        $existingHeaders = $headerResponse->getValues()[0] ?? [];

        // Header dari database (judul pertanyaan)
        $form->load(['questions' => fn($q) => $q->orderBy('sort_order')]);
        $expectedHeaders = array_merge(['Tanggal Submit'], $form->questions->pluck('question_text')->toArray());

        // Jika header tidak sama, update
        if ($existingHeaders !== $expectedHeaders) {
            $headerRange = new Google_Service_Sheets_ValueRange([
                'values' => [$expectedHeaders]
            ]);

            $service->spreadsheets_values->update(
                $form->google_sheet_id,
                'Sheet1!A1',
                $headerRange,
                ['valueInputOption' => 'RAW']
            );
        }

        // Ambil semua jawaban
        $form->load(['responses.answers']);

        $rows = [];

        foreach ($form->responses as $response) {
            $row = [];

            $row[] = $response->created_at->format('Y-m-d H:i:s');

            foreach ($form->questions as $question) {
                $answer = $response->answers
                    ->where('question_id', $question->id)
                    ->pluck('answer')
                    ->map(function ($a) {
                        $decoded = json_decode($a, true);
                        return is_array($decoded) ? implode(', ', $decoded) : $a;
                    })
                    ->implode(', ');

                $row[] = $answer;
            }

            $rows[] = $row;
        }

        // Clear semua isi lama dulu (kecuali header)
        $clearRange = new \Google_Service_Sheets_ClearValuesRequest();
        $service->spreadsheets_values->clear($form->google_sheet_id, 'Sheet1!A2:Z', $clearRange);

        // Append ulang dari baris 2
        $dataBody = new Google_Service_Sheets_ValueRange([
            'values' => $rows
        ]);
        $service->spreadsheets_values->update(
            $form->google_sheet_id,
            'Sheet1!A2',
            $dataBody,
            ['valueInputOption' => 'RAW']
        );
    }
}
