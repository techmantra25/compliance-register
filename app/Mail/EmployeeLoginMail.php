<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class EmployeeLoginMail extends Mailable
{
    public $admin;
    public $password;

    public function __construct($admin, $password)
    {
        $this->admin = $admin;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Employee Login Credentials')
                    ->view('emails.employee-login');
    }
}