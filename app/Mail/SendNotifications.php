<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class SendNotifications extends Mailable
{
    use Queueable, SerializesModels;

    public $notifications;

    public function __construct($notifications)
    {
        $this->notifications = $notifications;
    }

    public function build()
    {
        return $this->from('welcome@loyaltom.com', 'LoyalTom')->subject('Daily Notifications - LoyalTom '.date('d.m.Y', strtotime(Carbon::yesterday())))->view('admin.mail.notifications');
    }
}
