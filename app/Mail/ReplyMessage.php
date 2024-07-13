<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $messageData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reply, $messageData)
    {
        $this->reply = $reply;
        $this->messageData = $messageData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.blog.pesan.reply')
            ->subject('New Reply to Your Message')
            ->with([
                'reply' => $this->reply,
                'messageData' => $this->messageData,
            ]);
    }
}
