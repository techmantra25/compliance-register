<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name'];

    public function assemblies()
    {
        return $this->belongsToMany(
            Assembly::class,
            'grade_wise_assembly',
            'grade_id',
            'assembly_id'
        );
    }
}
