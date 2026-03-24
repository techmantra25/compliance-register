<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class AssignmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

   public function build()
    {
        return $this->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->subject('Vetting Assignment – ' . ($this->data['ac'] ?? 'Assembly'))
            ->view('emails.assignment-notification')
            ->with([
                'data' => $this->data
            ]);
    }
}