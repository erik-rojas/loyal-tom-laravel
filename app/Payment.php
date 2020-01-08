<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function idea()
    {
        return $this->belongsTo('App\Idea');
    }

    public function reminder()
    {
        return $this->belongsTo('App\Reminder');
    }
}
