<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
   protected $table = "event_categories";

   protected $fillable = [
        'name', 'status'
   ];

   public function permissions()
   {
      return $this->hasMany(EventRequiredPermission::class, 'category_id', 'id');
   }

}
