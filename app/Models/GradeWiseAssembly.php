<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeWiseAssembly extends Model
{
    protected $table = 'grade_wise_assembly';
    protected $fillable = ['grade_id', 'assembly_id'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}
