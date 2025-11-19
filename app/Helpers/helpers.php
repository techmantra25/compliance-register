<?php

use App\Models\CandidateDocumentType;
use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getCandidateDocument')) {
    /**
     * Get all document types, or a specific one by key.
     *
     * @param  string|null  $key
     * @return array|string|null
     */
    function getCandidateDocument($key = null)
    {
        // If no key provided, return all document types as [key => name]
        if (is_null($key)) {
            return CandidateDocumentType::pluck('name', 'key')->toArray();
        }

        // Return specific type name if key exists
        return CandidateDocumentType::where('key', $key)->value('name');
    }
}
if (!function_exists('getFinalDocStatus')) {
    /**
     * Get Final Status list or a single status label/icon
     *
     * @param string|null $key
     * @param string|null $type  ('label' or 'icon')
     * @return mixed
     */
    function getFinalDocStatus($key = null, $type = null)
    {
        $statuses = [
            'verified_pending_submission' => [
                'label' => 'Verified Correct but yet to be submitted',
                'icon'  => '✅',
            ],
            'ready_for_vetting' => [
                'label' => 'Ready for Vetting',
                'icon'  => '✅',
            ],
            'vetting_in_progress' => [
                'label' => 'Vetting in Progress',
                'icon'  => '🔍',
            ],
            'incomplete_additional_required' => [
                'label' => 'Incomplete / Additional Documents Required',
                'icon'  => '⚠️',
            ],
            'verified_submitted_with_copy' => [
                'label' => 'Verified and Submitted with Received Copy',
                'icon'  => '📄',
            ],
            'not_received_form' => [
                'label' => 'Have Not Received Form',
                'icon'  => '⛔',
            ],
        ];

        // Return all if no key
        if (is_null($key)) {
            return $statuses;
        }

        // Return specific key
        if (isset($statuses[$key])) {
            return match ($type) {
                'label' => $statuses[$key]['label'],
                'icon'  => $statuses[$key]['icon'],
                default => $statuses[$key],
            };
        }

        // Default fallback
        return [
            'label' => 'Unknown',
            'icon'  => '❓',
        ];
    }
}

if (!function_exists('logChange')) {

    function logChange(array $data)
    {
        try {
            ChangeLog::create([
                'module_name'   => $data['module_name']   ?? null,
                'module_id'     => $data['module_id']     ?? null,
                'action'        => $data['action']        ?? null,
                'description'   => $data['description']   ?? null,
                'old_data'      => $data['old_data']      ?? null,
                'new_data'      => $data['new_data']      ?? null,
                'document_name' => $data['document_name'] ?? null,
                'link'          => $data['link'] ?? null,
                'changed_by'    => Auth::guard('admin')->id() ?? null,
                'ip_address'    => request()->ip(),
                'user_agent'    => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            \Log::error('ChangeLog Error: ' . $e->getMessage());
        }
    }
}
