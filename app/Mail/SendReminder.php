<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reminder;

    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    public function build()
    {
        return $this->from('welcome@loyaltom.com', 'LoyalTom')->subject('LoyalTom: In 2 weeks it’s '.$this->reminder->occasion->client->name.'’s '.$this->reminder->occasion->type)->view('admin.mail.sendReminder');
    }
}
