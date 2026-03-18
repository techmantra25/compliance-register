<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class DailyNominationReport extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $filePath;

    public function __construct($data, $filePath)
    {
        $this->data = $data;
        $this->filePath = $filePath;
    }

    public function build()
    {
        $date = \Carbon\Carbon::parse($this->data['today'])->format('d M Y');
        $fileDate = \Carbon\Carbon::parse($this->data['today'])->format('Y_m_d');

        return $this->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->subject("Daily Nomination Report - {$date}") // ✅ Subject with date
            ->view('emails.daily-nomination-report')
            ->with(['data' => $this->data])
            ->attach($this->filePath, [
                'as' => "daily-nomination-status-{$fileDate}.csv", // ✅ CSV filename with date
                'mime' => 'text/csv',
            ]);
    }
}