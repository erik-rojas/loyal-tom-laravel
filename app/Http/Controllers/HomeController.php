<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientAdvisor;
use Illuminate\Http\Request;
use Auth;
use App\Occasion;
use App\Reminder;
use Carbon\Carbon;
use App\ClientName;
use App\Setting;



class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //ADMIN
        if(Auth::user()->role->name == 'Admin'){
            $occasions = Occasion::all();
            $upcoming_occasions = Occasion::whereDate('due_date', '>=', Carbon::now()->toDateString())
                //Don't show reminders which have drafts
                //->whereDoesntHave('reminders')
                ->orderBy('due_date' , 'asc')
                ->limit(15)
                ->get();

            //This Week
            $this_week['total'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]);
            })->count();

            $this_week['scheduled'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]);
            })->where('status', 'Scheduled')->count();

            $this_week['email'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]);
            })->where('status', 'Scheduled')->where('email_sent')->count();

            $this_week['sms'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]);
            })->where('status', 'Scheduled')->where('sms_sent')->count();

            //Next Week
            $next_week['total'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->addWeeks(1)->startOfWeek()->toDateString(), Carbon::now()->addWeeks(1)->endOfWeek()->toDateString()]);
            })->count();

            $next_week['scheduled'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->addWeeks(1)->startOfWeek()->toDateString(), Carbon::now()->addWeeks(1)->endOfWeek()->toDateString()]);
            })->where('status', 'Scheduled')->count();

            $next_week['email'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->addWeeks(1)->startOfWeek()->toDateString(), Carbon::now()->addWeeks(1)->endOfWeek()->toDateString()]);
            })->where('status', 'Scheduled')->where('email_sent')->count();

            $next_week['sms'] = Reminder::whereHas('occasion', function($query){
                $query->whereBetween('due_date', [Carbon::now()->addWeeks(1)->startOfWeek()->toDateString(), Carbon::now()->addWeeks(1)->endOfWeek()->toDateString()]);
            })->where('status', 'Scheduled')->where('sms_sent')->count();

            return view('admin.dashboard.index')
                ->withOccasions($occasions)
                ->withThis_week($this_week)
                ->withNext_week($next_week)
                ->withUpcoming_occasions($upcoming_occasions);
        }

        //ClientAdvisor
        if(Auth::user()->role->name == 'ClientAdvisor'){

            $current_reminder = Reminder::whereHas('occasion', function ($query) {
                $query->whereHas('client', function ($query1) {
                    $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
                });
            })->where('status', 'Scheduled')->where('email_sent', true)->where('seen', false)->first();

            if($current_reminder){
                $current_reminder->seen = true;
                $current_reminder->save();
                return redirect()->route('ca.reminders.show', $current_reminder->id);
            }else
            $current_reminders = Reminder::whereHas('occasion', function ($query) {
                $query->whereHas('client', function ($query1) {
                    $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
                })->whereBetween('due_date', [Carbon::now()->subMonth()->toDateString(), Carbon::now()->addWeeks(2)->toDateString()]);
            })->where('status', 'Scheduled')->get();





                $ca_clients = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->pluck('id');
                $occasionAll = Occasion::whereIn('client_id', $ca_clients)->count();
                $occasions = Occasion::whereIn('client_id', $ca_clients)->get();

                $expiration = Setting::where('name', 'Contract expiration date')->first();
                return view('client.dashboard.index')
                    ->with(['occasionAll' => $occasionAll])
                    ->withCurrent_reminders($current_reminders)
                    ->withExpiration($expiration)
                    ->withOccasions($occasions);
            }

    }
}
