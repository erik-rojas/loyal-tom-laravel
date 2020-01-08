<?php

namespace App\Helpers;
use App\Notification;
use App\Reminder;
use Auth;

class Notifications
{
    public static function getLatest()
    {
        $notifications = Notification::latest()->limit(5)->get();
        return ($notifications);
    }

    public static function getReminders()
    {
        $reminders = Reminder::whereHas('occasion', function ($query) {
        $query->whereHas('client', function ($query1) {
            $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
        });
        })->where('status', 'Scheduled')->where('seen', false)->latest()->get();

        return ($reminders);
    }
}