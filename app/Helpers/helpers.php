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
