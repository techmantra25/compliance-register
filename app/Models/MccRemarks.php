<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MccRemarks extends Model
{
    protected $fillable = [
        'mcc_id', 'legal_associate_id', 'remarks', 'attachment', 'is_read', 'is_cancelled'
    ];

    public function mcc()
    {
        return $this->belongsTo(Mcc::class, 'mcc_id');
    }

    public function legalAssociate()
    {
        return $this->belongsTo(Admin::class, 'legal_associate_id');
    }
}
