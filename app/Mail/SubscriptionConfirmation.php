<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $senderName;
    public $unsubscribeLink;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param string $senderName
     * @param string $unsubscribeLink
     * @return void
     */
    public function __construct($email, $senderName = 'CMS SINAU', $unsubscribeLink)
    {
        $this->email = $email;
        $this->senderName = $senderName;
        $this->unsubscribeLink = $unsubscribeLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscription')
            ->subject('Konfirmasi Langganan')
            ->from('admin@sdnkedungrejo.sch.id', $this->senderName)
            ->with([
                'unsubscribeLink' => $this->unsubscribeLink,
            ]);
    }
}
