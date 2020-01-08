<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function feedback()
    {
        return $this->belongsTo('App\Feedback', 'type_id');
    }

    public function occasion()
    {
        return $this->belongsTo('App\Occasion', 'type_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'type_id');
    }

}
