<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reminder;
use Carbon\Carbon;
use App\Mail\SendReminder;
use Illuminate\Support\Facades\Mail;

class emailClientAdvisor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:ClientAdvisor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Reminders To ClientAdvisors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $reminders = Reminder::whereHas('occasion', function($query){
           $query->where('due_date', Carbon::now()->toDateString());
       })->where('status', 'Scheduled')->where('email_sent', false)->get();

       foreach ($reminders as $reminder){
           Mail::to($reminder->occasion->client->clientAdvisor->user->email)->send(new SendReminder($reminder));
           $reminder->email_sent = true;
           $reminder->save();
       }
    }
}
