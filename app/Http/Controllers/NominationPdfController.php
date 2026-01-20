<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NominationForm;
use App\Models\NominationLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class NominationPdfController extends Controller
{
    public function download($id)
    {
        $nomination = NominationForm::with('candidate','assembly')->findOrFail($id);

        $pdf = Pdf::loadView(
            'livewire.nomination.form-pdf',
            [
                'nomination' => $nomination
            ]
        );

        $timestamp = now()->format('Ymd_His');
        NominationLog::create([
            'nomination_id' => $nomination->id,

            'form_data' => $nomination->toArray(),

            'pdf_file' => $pdf->output(),

            'generated_by' => Auth::id(),
            'ip_address'   => request()->ip(),
        ]);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'inline; filename="Nomination_Form_2B_'.$nomination->candidate_name.$timestamp.'.pdf"'
        );

        // return $pdf->stream(
        //     'Nomination_Form_2B_' . $nomination->candidate_name . '.pdf'
        // );
    }

    public function downloadFromLog($logId)
    {
        $log = NominationLog::findOrFail($logId);

        return response($log->pdf_file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'attachment; filename="Form_2B_' .
                $log->created_at->format('Ymd_His') . '.pdf"'
            );
    }

}
