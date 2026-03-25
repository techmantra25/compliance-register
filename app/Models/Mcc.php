<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcc extends Model

{
    protected $table = 'mcc';

    protected $fillable = [
           'assembly_id', 'category', 'mcc_code', 'block', 'gp', 'complainer_name', 'complainer_phone', 'complainer_description', 'attachment', 'keywords', 'remarks', 'action_taken', 'solved_by', 'solved_at', 'status'
    ];

    public function districts(){
        return $this->belongsTo(District::class, 'district_id');
    }

    public function assembly(){
        return $this->belongsTo(Assembly::class, 'assembly_id');
    }

    public function legalAssociate(){
        return $this->belongsTo(Admin::class, 'action_taken');
    }

    public function latestRemark()
    {
        return $this->hasOne(MccRemarks::class, 'mcc_id')->latestOfMany();
    }
    public function RemarksData()
    {
        return $this->hasMany(MccRemarks::class, 'mcc_id');
    }
}
