<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Idea extends Model
{

    use Searchable;

    public function ideaImages()
    {
        return $this->hasMany('App\IdeaImage');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function dates()
    {
        return $this->hasMany('App\IdeaDate')->orderBy('date', 'asc');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function reminders()
    {
        return $this->belongsToMany('App\Reminder');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }
}
