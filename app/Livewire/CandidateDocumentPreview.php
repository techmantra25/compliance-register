<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\CandidateDocumentType;
use App\Models\CandidateDocument;
use App\Models\CandidateObservationStep;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CandidateDocumentPreview extends Component
{
    public $candidateData;
    public $candidateId;
    public $versions;
    public $candidateName;
    public $nomination_date;
    public $phase;
    public $availableDocuments = [];
    public $active_tab;
    public $assemblyName;
    public $date_of_election;
    public $active_file;
    public $versionData;
    public $version_index = 1;
    public $observation_description;
     public function mount(Request $request)
    {
        $candidateId = $request->query('candidate');
        $version_id = $request->query('version');

        $candidate = Candidate::with('assembly.assemblyPhase.phase')->find($candidateId);

        if (!$candidate) {
            abort(404, 'Candidate not found.');
        }

        $versionData = null;

        // Try to get requested version
        if ($version_id) {
            $versionData = CandidateObservationStep::where('candidate_id', $candidate->id)
                ->where('version', $version_id)
                ->first();
        }

        
        // If requested version not found, get latest
        if (!$versionData) {
            $versionData = CandidateObservationStep::where('candidate_id', $candidate->id)
                // ->where('version', '>', $version_id)
                ->orderByDesc('version')
                ->first();
        }
        if($candidate->document_collection_status =="ready_for_vetting" && !$version_id){
            $latestVersion = CandidateDocument::where('candidate_id', $candidate->id)
                ->max('version');
                $this->version_index = $latestVersion;
                $this->versionData = null;
                $this->observation_description = null;
        }else{
            if ($versionData) {
                $this->version_index = $versionData->version;
                $this->versionData = $versionData;
                $this->observation_description = $versionData->observations;
            } else {
                $this->version_index = 1;
                $this->versionData = null;
                $this->observation_description = $candidate->observation_description;
            }
        }
        
       

        $allowedStatuses = ['verified_pending_submission', 'approved'];

        // if (!in_array($candidate->document_collection_status, $allowedStatuses)) {
        //     abort(403, 'Documents are not uploaded');
        // }

        $admin = Auth::guard('admin')->user();
        $userRole = strtolower(trim($admin->role));

        /*
        |--------------------------------------------------------------------------
        | Employee Access Check
        |--------------------------------------------------------------------------
        */
        if ($userRole === 'employee') {

            $employeeAssemblies = $admin->assemblies
                ? array_map('intval', explode(',', $admin->assemblies))
                : [];

            if (!in_array($candidate->assembly_id, $employeeAssemblies)) {
                abort(403, 'You are not authorized to access this candidate.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Legal Associate Access Check
        |--------------------------------------------------------------------------
        */
        if ($userRole === 'legal_associate') {

            if ($candidate->legal_associate_id != $admin->id) {
                abort(403, 'You are not authorized to access this candidate.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Candidate Data
        |--------------------------------------------------------------------------
        */

        $this->assemblyName = optional($candidate->assembly)->assembly_number 
        ? optional($candidate->assembly)->assembly_number . '-' . optional($candidate->assembly)->assembly_name_en
        : '';
        $this->nomination_date = $candidate?->assembly?->assemblyPhase?->phase?->last_date_of_nomination;
        $this->date_of_election = $candidate?->assembly?->assemblyPhase?->phase?->date_of_election;
        $this->phase = $candidate?->assembly?->assemblyPhase?->phase?->name;

        $this->candidateData = $candidate;
        $this->candidateId = $candidate->id;
        $this->candidateName = $candidate->name;

        $this->availableDocuments = $this->getDocumentTypes();

        $firstKey = array_key_first($this->availableDocuments);

        $this->ChangeDocument($firstKey, $this->version_index);
    }
    public function updatedObservationDescription($value)
    {
        Candidate::where('id', $this->candidateId)
            ->update([
                'observation_description' => $value
            ]);
    }

    public function ChangeDocument($key, $version)
    {
        $this->active_tab = $key;

        $this->active_file = CandidateDocument::where('candidate_id', $this->candidateId)
            ->where('type', $key)
            ->where('version', $version)
            ->orderByDesc('id')
            ->value('path');
    }
    protected function getDocumentTypes()
    {
        $version = $this->versionData 
            ? $this->versionData->version 
            : CandidateDocument::where('candidate_id', $this->candidateId)->max('version');

        $vetedFiles = CandidateDocument::where('candidate_id', $this->candidateId)
            ->whereIn('status', ['Uploaded','Rejected'])
            ->where('version', $version)
            ->pluck('type')
            ->toArray();
        return CandidateDocumentType::orderBy('position','ASC')->whereIn('key', $vetedFiles)->pluck('name', 'key')->toArray();
    }

    public function GenerateAcknowledgementForm()
    {
        $admin = Auth::guard('admin')->user();

        $candidate = Candidate::findOrFail($this->candidateId);

        // Check if legal associate assigned
        if ($candidate->legal_associate_id && $candidate->legal_associate_id != $admin->id) {

            $this->dispatch(
                'toastr:error',
                message: 'You are not authorized to generate this acknowledgement. Only the assigned Legal Associate can proceed.'
            );

            return;
        }

        DB::beginTransaction();

        try {

            $oldStatus = [
                'status' => $candidate->status,
                'document_collection_status' => $candidate->document_collection_status,
            ];


            // Update candidate status
            $candidate->status = "without_criminal_full_generation";
            $candidate->document_collection_status = "verified_pending_submission";

            // Get latest document version
            $latestVersion = CandidateDocument::where('candidate_id', $this->candidateId)
                ->max('version');

            $observationText = $candidate->observation_description;
            // Save observation step
             CandidateObservationStep::updateOrCreate(
                [
                    'candidate_id' => $this->candidateId,
                    'version' => $latestVersion,
                ],
                [
                    'observations' => $candidate->observation_description,
                    'generated_by' => Auth::guard('admin')->id(),
                ]
            );

            $candidate->observation_description = null;

            $candidate->save();

             logChange([
                'module_name' => 'Acknowledgement',
                'module_id' => $this->candidateId,
                'action' => 'Insert',
                'description' => "Acknowledgement generated.",
                'old_data' => json_encode($oldStatus),
                'new_data' => json_encode([
                    'version' => $latestVersion,
                    'observations' => $observationText,
                    'status' => $candidate->status,
                    'document_collection_status' => $candidate->document_collection_status,
                ]),
                'document_name' => 'Acknowledgement Form',
            ]);

            DB::commit();

            $this->candidateData = $candidate;

            $this->dispatch(
                'toastr:success',
                message: 'Acknowledgement generated successfully!'
            );
            return redirect()->route('admin.candidates.documents.preview', ['candidate'=>$this->candidateId, 'version'=>$latestVersion]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatch(
                'toastr:error',
                message: 'Error generating acknowledgement: ' . $e->getMessage()
            );
        }
    }
    public function downloadAcknowledgement()
    {
        $data = [
            'candidateName'   => $this->candidateName,
            'assemblyName'    => $this->assemblyName,
            'Examination'     => $this->versionData->created_at,
            'nomination_date' => $this->nomination_date,
            'authorizedBy' => Auth::guard('admin')->user()->name,
        ];

        $pdf = Pdf::loadView('pdf.acknowledgement', $data)
            ->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "acknowledgement_form.pdf"
        );
    }

    public function GenerateObservationMemo(){
        DB::beginTransaction();

        try {

            $latestDocs = CandidateDocument::where('candidate_id', $this->candidateId)
                ->selectRaw('MAX(id) as id')
                ->groupBy('type')
                ->pluck('id');

            $docs = CandidateDocument::whereIn('id', $latestDocs)->get();

            foreach ($docs as $item) {

                if ($item->status == "Uploaded") {

                    $item->status = "Rejected";
                    $item->save();

                } elseif ($item->status == "Skipped") {

                    $item->delete();

                } else {

                    $item->status = "Rejected";
                    $item->save();
                }
            }

            $update = Candidate::findOrFail($this->candidateId);
            $update->status = "without_criminal_rejected_observation_only";
            $update->document_collection_status = "incomplete_additional_required";

            $latestVersion = CandidateDocument::where('candidate_id', $this->candidateId)->max('version');

            CandidateObservationStep::updateOrCreate(
                [
                    'candidate_id' => $this->candidateId,
                    'version' => $latestVersion,
                ],
                [
                    'observations' => $update->observation_description,
                    'generated_by' => Auth::guard('admin')->id(),
                ]
            );

            $update->observation_description = null;
            $update->save();

            logChange([
                'module_name' => 'Observation Memo',
                'module_id' => $this->candidateId,
                'action' => 'Insert',
                'description' => "Observation memo generated.",
                'old_data' => null,
                'new_data' => json_encode([
                    'status' => $update->status,
                    'document_collection_status' => $update->document_collection_status,
                    'version' => $latestVersion,
                ]),
            ]);

            DB::commit();

            $this->candidateData = $update;

            return redirect()->route('admin.candidates.documents.preview', ['candidate'=>$this->candidateId, 'version'=>$latestVersion]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatch('toastr:error', message: 'Error generating observation memo: '.$e->getMessage());
        }
    }

   public function downloadObservationMemo()
    {
        $update = Candidate::findOrFail($this->candidateId);
        $hoursToSubtract = 48;
        $nominationDate = Carbon::parse($this->nomination_date);
        while ($hoursToSubtract > 0) {
            $nominationDate->subHour();

            if (!$nominationDate->isSunday()) {
                $hoursToSubtract--;
            }
        }
        $nominationDate->setTime(15, 0, 0);

        $data = [
            'candidateName'   => $this->candidateName,
            'assemblyName'    => $this->assemblyName,
            'examinationDate' => $this->versionData->created_at,
            'nomination_date' => $nominationDate,
            'observations'    => $this->observation_description,
            'authorizedBy' => Auth::guard('admin')->user()->name,
        ];

        $pdf = Pdf::loadView('pdf.observation_memo', $data)
            ->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "observation_memo.pdf"
        );
    }

    public function render()
    {
        $this->versions = CandidateObservationStep::where('candidate_id', $this->candidateId)->orderBy('version', 'ASC')->get();
        return view('livewire.candidate-document-preview')
            ->layout('layouts.admin');
    }
}