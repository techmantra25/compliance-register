<?php

if (!function_exists('getCandidateDocument')) {
    /**
     * Get all document types, or a specific one by key.
     *
     * @param  string|null  $key
     * @return array|string|null
     */
    function getCandidateDocument($key = null)
    {
        $types = [
            'nomination_paper'           => 'Nomination Paper (Form-2B)',
            'affidavit'                  => 'Affidavit (Form-26)',
            'security_deposit'           => 'Security Deposit Receipt',
            'electoral_roll'             => 'Certified Copy of Electoral Roll Entry',
            'party_authorization'        => 'Party Authorization Letter (Form-A & Form-B)',
            'caste_certificate'          => 'Caste Certificate',
            'oath_form'                  => 'Oath or Affirmation Form',
            'photo'                      => 'Passport-Size Photographs',
            'photo_declaration'          => 'Photograph Declaration',
            'criminal_record_declaration'=> 'Criminal Record Declaration',
            'education_proof'            => 'Proof of Educational Qualifications',
            'occupation_proof'           => 'Proof of Occupation',
        ];

        // Return all if no key provided
        if (is_null($key)) {
            return $types;
        }

        // Return specific type name if exists
        return $types[$key] ?? null;
    }
}
