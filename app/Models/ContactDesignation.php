<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDesignation extends Model
{
   protected $table = "contact_designations";

   protected $fillable = [
        'name','status'
   ];
}
