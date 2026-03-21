<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignPermissionDocument extends Model
{
    protected $table = 'campaign_permission_documents';
    protected $fillable = [
        'campaign_id',
        'file_path'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
