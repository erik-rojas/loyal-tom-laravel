<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function clientAdvisor()
    {
        return $this->belongsTo('App\ClientAdvisor');
    }

    public function occasions()
    {
        return $this->hasMany('App\Occasion');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }
}
