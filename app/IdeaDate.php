<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaDate extends Model
{
    public function idea()
    {
        return $this->belongsTo('App\Idea');
    }
}
