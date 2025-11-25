<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignWisePermission extends Model
{
    protected $table = "campaign_wise_permissions";

    protected $fillable = [
       'campaign_id', 'event_required_permission_id', 'doc_type', 'file', 'status', 'rejected_reason', 'remarks', 'uploaded_by', 'uploaded_at', 'approved_by', 'approved_at'
    ];

    public function campaign(){
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function requiredPermission(){
        return $this->belongsTo(EventRequiredPermission::class, 'event_required_permission_id', 'id');
    }

    public function uploadedBy(){
        return $this->belongsTo(Admin::class, 'uploaded_by', 'id');
    }

    public function approvedBy(){
        return $this->belongsTo(Admin::class, 'approved_by', 'id');
    }
}
