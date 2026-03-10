<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetOtpMail extends Mailable
{
    use SerializesModels;

    public $otp;
    public $email;

    public function __construct($otp,$email)
    {
        $this->otp = $otp;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Password Reset OTP')
                    ->view('emails.reset-otp');
    }
}