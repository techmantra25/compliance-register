<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MccRemarks extends Model
{
    protected $fillable = [
        'mcc_id', 'admin_id', 'remarks', 'is_read', 'is_cancelled', 'tag_with'
    ];

    public function mcc()
    {
        return $this->belongsTo(Mcc::class, 'mcc_id');
    }

    public function legalAssociate()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function supportingDocuments()
    {
        return $this->hasMany(MccSupportingDocument::class, 'mcc_remarks_id');
    }
}
