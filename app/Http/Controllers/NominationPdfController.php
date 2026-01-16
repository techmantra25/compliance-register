<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NominationForm;
use Barryvdh\DomPDF\Facade\Pdf;

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

        return $pdf->stream(
            'Nomination_Form_2B_' . $nomination->candidate_name . '.pdf'
        );
    }
}
