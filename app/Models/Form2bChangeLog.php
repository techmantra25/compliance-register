<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form2bChangeLog extends Model
{
    protected $table = "form2b_change_logs";
    protected $fillable = [
        'form2b_id',
        'assembly_id',
        'old_data',
        'new_data',
        'changed_by',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];
}
