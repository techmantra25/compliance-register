<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MccSupportingDocument extends Model
{
    protected $table = 'mcc_supporting_documents';
    protected $fillable = [
        'mcc_id',
        'file_path'
    ];

    public function mcc()
    {
        return $this->belongsTo(Mcc::class);
    }
}
