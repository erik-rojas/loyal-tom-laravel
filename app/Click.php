<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    public function reminder()
    {
        return $this->belongsTo('App\Reminder');
    }
}
