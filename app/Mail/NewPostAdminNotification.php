<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $new_post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_new_post)
    {
        $this->new_post = $_new_post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'new_post' => $this->new_post
        ];

        return $this->view('mails.new-post-admin-notification', $data);
    }
}
