<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function reminders()
    {
        return $this->hasMany('App\Reminder');
    }

    public function lastReminder()
    {
        return $this->hasOne('App\Reminder')->orderBy('id', 'desc');
    }

    public function receivedReminders()
    {
        return $this->hasMany('App\Reminder')->where('email_sent', true);
    }

    public function seenReminders()
    {
        return $this->hasMany('App\Reminder')->where('seen', true);
    }
}
