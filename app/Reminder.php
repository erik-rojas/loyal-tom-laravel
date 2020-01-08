<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    public function occasion()
    {
        return $this->belongsTo('App\Occasion');
    }

    public function ideas()
    {
        return $this->belongsToMany('App\Idea');
    }

    public function clicks()
    {
        return $this->hasMany('App\Click');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
