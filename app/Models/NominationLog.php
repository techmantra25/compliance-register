<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominationLog extends Model
{
    protected $fillable = [
        'nomination_id',
        'form_data',
        'form_json',
        'pdf_file',
        'generated_by',
        'ip_address'
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function nomination()
    {
        return $this->belongsTo(NominationForm::class, 'nomination_id');
    }
}
