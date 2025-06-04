<?php

namespace App\Http\Controllers;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\HtmlString;

class MailPreviewController extends Controller
{
    public function preview()
    {
        $email = 'sdnkedungrejo.201@gmail.com';
        $token = 'dummy-token';
        $url = route('password.reset', ['token' => $token, 'email' => $email]);

        $notification = new CustomResetPasswordNotification($url);

        // $mailMessage ini instance Illuminate\Notifications\Messages\MailMessage
        $mailMessage = $notification->toMail($email);

        // Render view email menjadi HTML string
        $html = $mailMessage->render();

        // Kembalikan HTML ke browser supaya bisa dilihat
        return new HtmlString($html);
    }
}
