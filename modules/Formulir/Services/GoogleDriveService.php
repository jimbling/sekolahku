<?php

namespace Modules\Formulir\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected $client;
    protected $owner;
    protected $tokenValid = true;

    public function __construct($formOwner)
    {
        $this->owner = $formOwner;
        $this->client = new Google_Client();
        $this->client->setApplicationName('SinauCMS Formulir Integration');
        $this->client->setAccessType('offline');
        $this->client->setClientId(config('services.google.client_id'));    //  pakai config()
        $this->client->setClientSecret(config('services.google.client_secret')); //  pakai config()
        $this->client->setScopes([
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/spreadsheets'
        ]);
        $this->setToken();
    }

    private function setToken()
    {
        $this->client->setAccessToken([
            'access_token'  => $this->owner->google_token,
            'refresh_token' => $this->owner->google_refresh_token,
            'token_type'    => 'Bearer',
            'expires_in'    => 3600,
            'created'       => time() - 4000 // supaya dianggap expired → refresh
        ]);

        Log::info('📡 Refreshing token dengan:', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $this->owner->google_refresh_token
        ]);

        //  Kalau token expired → refresh
        if ($this->client->isAccessTokenExpired()) {
            Log::info('🔄 Google access token expired, mencoba refresh token...');

            $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->owner->google_refresh_token);

            if (isset($newToken['error'])) {
                Log::error('❌ Gagal refresh token Google: ' . $newToken['error']);
                $this->tokenValid = false;
                $this->client->setAccessToken(null);
                return;
            }

            //  Simpan token baru ke database
            $this->owner->update([
                'google_token' => $newToken['access_token'],
                'google_refresh_token' => $newToken['refresh_token'] ?? $this->owner->google_refresh_token,
            ]);

            $this->client->setAccessToken($newToken);

            Log::info(' Token Google berhasil di-refresh.');
        }
    }

    public function drive()
    {
        return new Google_Service_Drive($this->client);
    }

    public function sheets()
    {
        return new Google_Service_Sheets($this->client);
    }

    public function hasValidToken()
    {
        return $this->tokenValid && $this->client->getAccessToken();
    }
}
