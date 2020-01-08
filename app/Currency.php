<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function ideas()
    {
        return $this->hasMany('App\Idea');
    }
}
