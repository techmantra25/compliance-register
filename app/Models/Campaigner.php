<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigner extends Model
{
    protected $table = "campaigners";

    protected $fillable = [
        'name', 'mobile', 'extra_details'
    ];
}
