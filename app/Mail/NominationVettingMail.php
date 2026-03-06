<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class NominationVettingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $ac;
    public $nominationDate;
    public $electionDate;
    public $link;

    public function __construct($candidate,$ac,$nominationDate,$electionDate,$link)
    {
        $this->candidate = $candidate;
        $this->ac = $ac;
        $this->nominationDate = $nominationDate;
        $this->electionDate = $electionDate;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Nomination Documents Ready for Vetting – '.$this->ac)
                    ->view('emails.nomination-vetting');
    }
}