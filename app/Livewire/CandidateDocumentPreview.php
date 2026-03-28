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
use App\Models\Admin;
use App\Models\CandidateSkippedDocument;
use Illuminate\Support\Facades\DB;

class CandidateDocumentPreview extends Component
{
    public $candidateData;
    public $candidateId;
    public $versions;
    public $candidateName;
    public $employeeCode;
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
    public $observation_others_description;
    public $selectedObservations = [];
    public $is_active_observation_whatsapp = 0;
    public $whatsapp_receiver = [];
    public $all_whatsapp_receiver = [];

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
                ->firstOrFail();
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
                $this->observation_others_description = null;
        }else{
            if ($versionData) {
                $this->version_index = $versionData->version;
                $this->versionData = $versionData;
                $this->observation_description = $versionData->observations;
                $this->observation_others_description = $versionData->others;
            } else {
                $this->version_index = 1;
                $this->versionData = null;
                $this->observation_description = $candidate->observation_description;
                $this->observation_others_description = $candidate->observation_others_description;
            }
        }
        $this->selectedObservations = is_array($this->observation_description)
            ? $this->observation_description
            : json_decode($this->observation_description, true) ?? [];
            // dd($this->selectedObservations);

        $allowedStatuses = ['verified_pending_submission', 'approved'];

        // if (!in_array($candidate->document_collection_status, $allowedStatuses)) {
        //     abort(403, 'Documents are not uploaded');
        // }

        $admin = Auth::guard('admin')->user();
        $userRole = strtolower(trim($admin->role));

        $this->employeeCode = $admin->code ?? null;

        /*
        |--------------------------------------------------------------------------
        | Employee Access Check
        |--------------------------------------------------------------------------
        */
        // if ($userRole === 'employee') {

        //     $employeeAssemblies = $admin->assemblies
        //         ? array_map('intval', explode(',', $admin->assemblies))
        //         : [];

        //     if (!in_array($candidate->assembly_id, $employeeAssemblies)) {
        //         abort(403, 'You are not authorized to access this candidate.');
        //     }
        // }

        /*
        |--------------------------------------------------------------------------
        | Legal Associate Access Check
        |--------------------------------------------------------------------------
        */
        if ($userRole === 'legal_associate' && isset($candidate->legal_associate_id)) {
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

    public function closeWhatsappModal()
    {
        $this->is_active_observation_whatsapp = 0;
    }
    public function openWhatsappModal()
    {
        $admins = $this->getActiveAdminsWithMobile();
        $this->all_whatsapp_receiver = $admins->map(function ($admin) {
            return [
                'name'   => ucwords($admin->name),
                'mobile' => $admin->mobile,
                'role' => ucwords(str_replace('_', ' ', $admin->role)),
            ];
        })->values()->toArray(); // ensures proper indexing
        $this->whatsapp_receiver = $this->all_whatsapp_receiver;
        $this->is_active_observation_whatsapp = 1;
    }

    public function toggleReceiver($index)
    {
        $user = $this->all_whatsapp_receiver[$index];

        $exists = collect($this->whatsapp_receiver)
            ->contains(fn($item) => $item['mobile'] === $user['mobile']);

        if ($exists) {
            // Remove
            $this->whatsapp_receiver = array_values(array_filter(
                $this->whatsapp_receiver,
                fn($item) => $item['mobile'] !== $user['mobile']
            ));
        } else {
            // Add
            $this->whatsapp_receiver[] = $user;
        }
    }

    public function sendObservationWhatsapp()
    {
        if (count($this->whatsapp_receiver) > 0) {

            $apiDomainUrl  = config('whatsapp.api_domain_url');
            $apiVersion    = config('whatsapp.api_version');
            $channelNumber = config('whatsapp.channel_number');
            $apiKey        = config('whatsapp.api_key');
            $apiEndPoint   = config('whatsapp.api_end_point');

            $apiUrl = "{$apiDomainUrl}/{$apiVersion}/{$channelNumber}/{$apiEndPoint}";

            // Generate PDF once
            $url = $this->generateObservationMemoPdf();
            $filename = basename($url);

            $success = false;

            foreach ($this->whatsapp_receiver as $item) {

                // =========================
                // VARIABLES
                // =========================
                $var1 = $item['name']; // Receiver name
                $var2 = auth('admin')->user()->name; // Sender name
                $var3 = $this->candidateName;
                $var4 = $this->assemblyName;

                // =========================
                // MOBILE FORMAT
                // =========================
                $mobile = preg_replace('/\D/', '', $item['mobile']);
                $recipientPhone = '91' . substr($mobile, -10);

                // =========================
                // PAYLOAD
                // =========================
                $payload = [
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => $recipientPhone,
                    "type" => "template",
                    "template" => [
                        "name" => "observation_memo",
                        "language" => [
                            "code" => "en"
                        ],
                        "components" => [
                            [
                                "type" => "header",
                                "parameters" => [
                                    [
                                        "type" => "document",
                                        "document" => [
                                            "link" => $url,
                                            "filename" => $filename
                                        ]
                                    ]
                                ]
                            ],
                            [
                                "type" => "body",
                                "parameters" => [
                                    ["type" => "text", "text" => $var1],
                                    ["type" => "text", "text" => $var2],
                                    ["type" => "text", "text" => $var3],
                                    ["type" => "text", "text" => $var4],
                                ]
                            ]
                        ]
                    ],
                    "biz_opaque_callback_data" => "observation_memo_{$this->candidateId}"
                ];

                // =========================
                // CURL REQUEST
                // =========================
                $ch = curl_init();

                curl_setopt_array($ch, [
                    CURLOPT_URL => $apiUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Bearer {$apiKey}",
                        "Content-Type: application/json",
                    ],
                    CURLOPT_POSTFIELDS => json_encode($payload),
                ]);

                $response = curl_exec($ch);
                $error    = curl_error($ch);

                curl_close($ch);

                // =========================
                // ERROR HANDLE
                // =========================
                if ($error) {
                    \Log::error("WhatsApp CURL Error: " . $error);
                    continue;
                }

                $responseData = json_decode($response, true);

                // =========================
                // SUCCESS CHECK
                // =========================
                if (isset($responseData['messages'])) {
                    $success = true;
                }

                // =========================
                // LOG RESPONSE
                // =========================
                \Log::info('WhatsApp Response', [
                    'phone' => $recipientPhone,
                    'response' => $responseData
                ]);
            }

            // =========================
            // FINAL RESPONSE
            // =========================
            if ($success) {
                // =========================
                // LOG ENTRY
                // =========================
                logChange([
                    'module_name' => 'Observation Memo',
                    'module_id' => $this->candidateId,
                    'action' => 'Send WhatsApp',
                    'description' => "Observation memo sent successfully via WhatsApp.",
                    'old_data' => json_encode([]),
                    'new_data' => json_encode([
                        'version'   => $this->version_index,
                        'sender'    => auth('admin')->user()->name,
                        'receivers' => json_encode(
                            collect($this->whatsapp_receiver)->map(function ($item) {
                                return [
                                    'name'   => $item['name'],
                                    'mobile' => $item['mobile'],
                                    'role'   => $item['role'] ?? null,
                                ];
                            })->values()->toArray()
                        ),
                    ]),
                    'document_name' => 'Observation Memo',
                ]);
                $this->dispatch(
                    'toastr:success',
                    message: 'Acknowledgement generated successfully!'
                );

                return redirect()->route(
                    'admin.candidates.documents.preview',
                    [
                        'candidate' => $this->candidateId,
                        'version'   => $this->version_index
                    ]
                );
            } else {
                $this->dispatch(
                    'toastr:error',
                    message: 'Failed to send WhatsApp messages. Please try again.'
                );
            }

        } else {
            $this->dispatch(
                'toastr:error',
                message: 'Please select at least one recipient to send WhatsApp.'
            );
            return true;
        }
    }

    public function generateObservationMemoPdf()
    {
        $candidate = Candidate::findOrFail($this->candidateId);

        // Calculate adjusted nomination date (excluding Sundays)
        $hoursToSubtract = 48;
        $nominationDate = \Carbon\Carbon::parse($this->nomination_date);

        while ($hoursToSubtract > 0) {
            $nominationDate->subHour();

            if (!$nominationDate->isSunday()) {
                $hoursToSubtract--;
            }
        }

        $nominationDate->setTime(15, 0, 0);

        $data = [
            'candidateName'   => $this->candidateName,
            'employeeCode'    => $this->employeeCode,
            'assemblyName'    => $this->assemblyName,
            'examinationDate' => $this->versionData->created_at,
            'nomination_date' => $nominationDate,
            'observations'    => $this->observation_description,
            'others'          => $this->observation_others_description,
            'authorizedBy'    => auth('admin')->user()->name,
        ];

        $pdf = Pdf::loadView('pdf.observation_memo', $data)
            ->setPaper('A4', 'portrait');

        // filename
        $filename = str_replace(' ', '-', $this->assemblyName) . '-observation-memo.pdf';

        // storage path
        $path = "candidate_docs/{$this->candidateId}/" . $filename;
        // save file
        \Storage::disk('public')->put($path, $pdf->output());

        // return public URL (for WhatsApp or anywhere)
        return asset('storage/' . $path);
    }
    public function saveObservations($observations)
    {
        Candidate::where('id', $this->candidateId)->update([
            'observation_description' => json_encode($observations)
        ]);

        $this->observation_description = json_encode($observations);
    }

    public function saveOthersDescription($value)
    {
        Candidate::where('id', $this->candidateId)->update([
            'observation_others_description' => $value
        ]);

        $this->observation_others_description = $value;
    }

    public function hydrateObservations()
    {
        $obs = $this->observation_description;

        $this->selectedObservations = is_array($obs)
            ? $obs
            : json_decode($obs, true) ?? [];
    }
    public function updatedSelectedObservations()
    {
        Candidate::where('id', $this->candidateId)->update([
            'observation_description' => json_encode($this->selectedObservations)
        ]);

        $this->observation_description = json_encode($this->selectedObservations);
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
            $this->SendWhatsapp($candidate->id);
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
            $observationOthersText = $candidate->observation_others_description;
            // Save observation step
             CandidateObservationStep::updateOrCreate(
                [
                    'candidate_id' => $this->candidateId,
                    'version' => $latestVersion,
                ],
                [
                    'observations' => $candidate->observation_description,
                    'others' => $candidate->observation_others_description,
                    'generated_by' => Auth::guard('admin')->id(),
                ]
            );

            $candidate->observation_description = null;
            $candidate->observation_others_description = null;

            $candidate->save();

             logChange([
                'module_name' => 'Acknowledgement',
                'module_id' => $this->candidateId,
                'action' => 'Generate',
                'description' => "The acknowledgement has been generated successfully.",
                'old_data' => json_encode($oldStatus),
                'new_data' => json_encode([
                    'version' => $latestVersion,
                    'observations' => $observationText,
                    'others' => $observationOthersText,
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

    private function getActiveAdminsWithMobile()
    {
        return Admin::where('suspended_status', 1)
            ->whereIn('role', ['admin', 'legal_associate'])
            ->whereNotNull('mobile')
            ->where('mobile', '!=', '')
            ->get();
    }
    private function SendWhatsapp($candidate_id){

        $candidate = Candidate::findOrFail($candidate_id);
       
        // WhatsApp config
        $apiDomainUrl  = config('whatsapp.api_domain_url');
        $apiVersion    = config('whatsapp.api_version');
        $channelNumber = config('whatsapp.channel_number');
        $apiKey        = config('whatsapp.api_key');
        $apiEndPoint   = config('whatsapp.api_end_point');

        $apiUrl = "{$apiDomainUrl}/{$apiVersion}/{$channelNumber}/{$apiEndPoint}";

        // get all Admin & legal associate
        $admins = $this->getActiveAdminsWithMobile();

        $url = $this->generateAcknowledgementPdf();
        foreach ($admins as $key => $item) {

            // =========================
            // VARIABLES
            // =========================
            $var1 = $item->name; // Admin name
            $var2 = Auth::guard('admin')->user()->name; // Sender name
            $var3 = $candidate->name; // Candidate name

            $var4 = optional($candidate->assembly)->assembly_number 
                ? optional($candidate->assembly)->assembly_number . '-' . optional($candidate->assembly)->assembly_name_en
                : '';

            // =========================
            // MOBILE FORMAT (91XXXXXXXXXX)
            // =========================
            $mobile = preg_replace('/\D/', '', $item->mobile);
            $recipientPhone = '91' . substr($mobile, -10);

            // =========================
            // DOCUMENT URL (PUBLIC URL MUST)
            // =========================
            $document = $url; //  use generated PDF URL
            $filename = basename($document);

            // =========================
            // PAYLOAD
            // =========================
            $payload = [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $recipientPhone,
                "type" => "template",
                "template" => [
                    "name" => "acknowledgement_copy",
                    "language" => [
                        "code" => "en"
                    ],
                    "components" => [
                        [
                            "type" => "header",
                            "parameters" => [
                                [
                                    "type" => "document",
                                    "document" => [
                                        "link" => $document,
                                        "filename" => $filename
                                    ]
                                ]
                            ]
                        ],
                        [
                            "type" => "body",
                            "parameters" => [
                                ["type" => "text", "text" => $var1],
                                ["type" => "text", "text" => $var2],
                                ["type" => "text", "text" => $var3],
                                ["type" => "text", "text" => $var4],
                            ]
                        ]
                    ]
                ],
            ];

            // =========================
            // CURL REQUEST
            // =========================
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$apiKey}",
                    "Content-Type: application/json",
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
            ]);

            $response = curl_exec($ch);
            $error    = curl_error($ch);

            curl_close($ch);

            // =========================
            // ERROR HANDLE
            // =========================
            if ($error) {
                \Log::error("WhatsApp CURL Error: " . $error);
                continue;
            }

            $responseData = json_decode($response, true);
            // =========================
            // OPTIONAL DEBUG LOG
            // =========================
            \Log::info('WhatsApp Response', [
                'phone' => $recipientPhone,
                'response' => $responseData
            ]);
        }
        
    }


    public function generateAcknowledgementPdf()
    {
        $data = [
            'candidateName'   => $this->candidateName,
            'employeeCode'   => $this->employeeCode,
            'assemblyName'   => $this->assemblyName,
            'Examination' => now()->timezone('Asia/Kolkata')->format('d-m-Y h:i A'),
            'nomination_date'=> $this->nomination_date,
            'authorizedBy'   => Auth::guard('admin')->user()->name,
        ];

        $pdf = Pdf::loadView('pdf.acknowledgement', $data)
            ->setPaper('A4', 'portrait');

        // filename
        $filename = str_replace(' ', '-', $this->assemblyName) . '-acknowledgement-form.pdf';

        // storage path
        $path = "candidate_docs/{$this->candidateId}/" . $filename;

        // save file in storage/app/public
        \Storage::disk('public')->put($path, $pdf->output());

        // return public URL for WhatsApp
        return asset('storage/' . $path);
    }
    public function downloadAcknowledgement()
    {
        $data = [
            'candidateName'   => $this->candidateName,
            'employeeCode'   => $this->employeeCode,
            'assemblyName'    => $this->assemblyName,
            'Examination'     => $this->versionData->created_at,
            'nomination_date' => $this->nomination_date,
            'authorizedBy' => Auth::guard('admin')->user()->name,
        ];

        $pdf = Pdf::loadView('pdf.acknowledgement', $data)
            ->setPaper('A4', 'portrait');

        $filename = str_replace(' ', '-', $this->assemblyName) .
            '-acknowledgement-form.pdf';
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
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
            $latestVersion = CandidateDocument::where('candidate_id', $this->candidateId)->max('version');

            foreach ($docs as $item) {

                if ($item->status == "Uploaded") {

                    $item->status = "Rejected";
                    $item->save();

                } elseif ($item->status == "Skipped") {
                     // Clone data to skipped table
                    CandidateSkippedDocument::create([
                        'candidate_id'        => $item->candidate_id,
                        'version'             => $item->version,
                        'type'                => $item->type,
                        'path'                => $item->path,
                        'remarks'             => $item->remarks,
                        'uploaded_by'         => $item->uploaded_by,
                        'vetted_by'           => $item->vetted_by,
                        'vetted_on'           => $item->vetted_on,
                        'status'              => $item->status,
                        'attached_with'       => $item->attached_with,
                        'attached_with_slug'  => $item->attached_with_slug,
                    ]);
                    // Delete from original table
                    $item->version = $item->version + 1;
                    $item->save();
                } else {
                    $item->status = "Rejected";
                    $item->save();
                }
            }

            $update = Candidate::findOrFail($this->candidateId);
            $update->status = "without_criminal_rejected_observation_only";
            $update->document_collection_status = "incomplete_additional_required";

            CandidateObservationStep::updateOrCreate(
                [
                    'candidate_id' => $this->candidateId,
                    'version' => $latestVersion,
                ],
                [
                    'observations' => $update->observation_description,
                    'others' => $update->observation_others_description,
                    'generated_by' => Auth::guard('admin')->id(),
                ]
            );

            $update->observation_description = null;
            $update->observation_others_description = null;
            $update->save();

            logChange([
                'module_name' => 'Observation Memo generated',
                'module_id' => $this->candidateId,
                'action' => 'Generate',
                'description' => "The observation memo has been generated successfully.",
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
            'employeeCode'   => $this->employeeCode,
            'assemblyName'    => $this->assemblyName,
            'examinationDate' => $this->versionData->created_at,
            'nomination_date' => $nominationDate,
            'observations'    => $this->observation_description,
            'others'    => $this->observation_others_description,
            'authorizedBy' => Auth::guard('admin')->user()->name,
        ];

        $pdf = Pdf::loadView('pdf.observation_memo', $data)
            ->setPaper('A4', 'portrait');

        $filename = str_replace(' ', '-', $this->assemblyName) .
            '-observation-memo.pdf';

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename,
        );
    }

    public function render()
    {
        $this->versions = CandidateObservationStep::where('candidate_id', $this->candidateId)->orderBy('version', 'ASC')->get();
        return view('livewire.candidate-document-preview')
            ->layout('layouts.admin');
    }
}