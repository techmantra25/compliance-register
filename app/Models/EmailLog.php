<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'sender',
        'candidate_id',
        'recipients',
        'subject',
        'message'
    ];
}
