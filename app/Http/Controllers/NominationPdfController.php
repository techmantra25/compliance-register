<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NominationForm2B;
use Barryvdh\DomPDF\Facade\Pdf;

class NominationPdfController extends Controller
{
    public function form2B($id)
    {
        $nominationForm = NominationForm2B::findOrFail($id);
        $pdf = Pdf::loadView('livewire.nomination.form-pdf', ['data' => $nominationForm]);
        return $pdf->stream('Nomination_Form_2B_'.$nominationForm->candidate_name.'.pdf');
    }
}
