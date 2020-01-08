<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
   public function idea()
   {
       return $this->belongsTo('App\Idea');
   }

   public function client()
   {
       return $this->belongsTo('App\Client');
   }
}
