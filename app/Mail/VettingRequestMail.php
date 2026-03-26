<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VettingRequestMail extends Mailable
{
    public $admin;
    public $candidate;

    public function __construct($admin, $candidate)
    {
        $this->admin = $admin;
        $this->candidate = $candidate;
    }

    public function build()
    {
        return $this->subject('Vetting Request for Candidate')
            ->view('emails.vetting-request');
    }
}
