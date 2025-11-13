<?php

use App\Models\CandidateDocumentType;

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

