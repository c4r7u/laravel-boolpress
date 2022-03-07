<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $new_lead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_new_lead)
    {
        $this->new_lead = $_new_lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'new_lead' => $this->new_lead
        ];

        return $this->view('mails.new-contact-mail', $data);
    }
}
