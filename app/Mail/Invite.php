<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invite extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $hash;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $hash, $name)
    {
        $this->email = $email;
        $this->hash = $hash;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('welcome@loyaltom.com', 'LoyalTom')->subject('LoyalTom: INVITATION')->view('admin.mail.invite');
    }
}
