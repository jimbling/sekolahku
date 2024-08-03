<?php

// app/Http/Controllers/MailPreviewController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\CustomResetPasswordNotification;

class MailPreviewController extends Controller
{
    public function preview()
    {
        $email = 'user@example.com'; // Ganti dengan email yang sesuai
        $token = 'dummy-token'; // Ganti dengan token dummy jika diperlukan
        $url = route('password.reset', ['token' => $token, 'email' => $email]);

        return new CustomResetPasswordNotification($url); // Ganti dengan mail class Anda
    }
}
