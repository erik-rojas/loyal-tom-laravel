<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notification;
use App\User;
use Carbon\Carbon;
use App\Mail\SendNotifications;
use Illuminate\Support\Facades\Mail;

class emailAdminNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:AdminNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending daily reports for admins';

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
        $notifications = Notification::whereDate('created_at', Carbon::yesterday()->toDateString())->latest()->get();
        $admins = User::where('role_id', 1)->get();

        foreach($admins as $admin){
            Mail::to($admin->email)->send(new SendNotifications($notifications));
        }
    }
}
