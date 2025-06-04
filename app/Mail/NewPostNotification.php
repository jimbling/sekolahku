<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $postTitle;
    public $postLink;
    public $excerpt;
    public $publishedAt;
    public $postImage;

    /**
     * Create a new message instance.
     *
     * @param string $postTitle
     * @param string $postLink
     * @param string $excerpt
     * @param string $publishedAt
     * @param string|null $postImage
     */
    public function __construct($postTitle,  $postLink, $excerpt, $publishedAt, $postImage = null)
    {
        $this->postTitle = $postTitle;
        $this->postLink = $postLink;
        $this->excerpt = $excerpt;
        $this->publishedAt = $publishedAt;
        $this->postImage = $postImage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_post_notification')
            ->subject('Berita terbaru: ' . $this->postTitle)
            ->from('admin@sdnkedungrejo.sch.id', 'CMS SINAU'); // Mengganti alamat email dan nama pengirim
    }
}
