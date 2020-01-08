<?php

namespace App\Http\Controllers\ClientAdvisor;

use App\Http\Controllers\Controller;
use App\Payment;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use App\Reminder;
use App\Mail\NewPayment;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{

    /**
     * @return view with all Reminders for Current ClientAdvisor:
     * withCurrent_reminders($current_reminders)
     * withExpired_reminders($expired_reminders)
     * withUpcoming_reminders($upcoming_reminders)
     */
    public function index()
    {
        $current_reminders = Reminder::whereHas('occasion', function ($query) {
            $query->whereHas('client', function ($query1) {
                $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
            })->whereBetween('due_date', [Carbon::now()->subMonth()->toDateString(), Carbon::now()->addWeeks(2)->toDateString()]);
        })->where('status', 'Scheduled')->get();


        $upcoming_reminders = Reminder::whereHas('occasion', function ($query) {
            $query->whereHas('client', function ($query1) {
                $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
            })->where('due_date', '>', Carbon::now()->addWeeks(2)->toDateString());
        })->where('status', 'Scheduled')->get();

        $expired_reminders = Reminder::whereHas('occasion', function ($query) {
            $query->whereHas('client', function ($query1) {
                $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
            })->where('due_date', '<=', Carbon::now()->subMonth()->toDateString());
        })->where('status', 'Scheduled')->get();

        return view('client.reminder.index')
            ->withCurrent_reminders($current_reminders)
            ->withExpired_reminders($expired_reminders)
            ->withUpcoming_reminders($upcoming_reminders);
    }

    /**
     * Show Reminder
     * @param $id - Reminder id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $reminder = Reminder::whereHas('occasion', function ($query) {
            $query->whereHas('client', function ($query1) {
                $query1->where('client_advisor_id', Auth::user()->clientAdvisor->id);
            });
        })->where('status', 'Scheduled')->where('id', $id)->first();

        if($reminder){

            $reminder->seen = true;
            $reminder->save();
            return view('client.reminder.show')->withReminder($reminder);

        }else{

            Session::flash('error', 'You can&#39;t open this Reminder!');
            return back();
        }

    }

    public function payment(Request $request, $reminder_id)
    {
        if($request->status == 'success'){
            $payment = new Payment();
            $payment->user_id = Auth::user()->id;
            $payment->idea_id = $request->idea_id;
            $payment->reminder_id = $reminder_id;
            $payment->uppTransactionId = $request->uppTransactionId;
            $payment->amount = $request->amount;
            $payment->currency = $request->currency;
            $payment->status = 'New';
            $payment->payment_status = 'payed';
            $payment->save();

            Session::flash('success', 'Thank you, your payment has been done successfully.<br />A team member will contact you soon.');

            Mail::to('welcome@loyaltom.com')->send(new NewPayment($payment));
        }
        elseif($request->status == 'cancel'){
            Session::flash('error', 'Operation was canceled.');
        }
        else{
            Session::flash('error', 'Error. Please try again.');
        }


        return redirect()->route('ca.reminders.show', $reminder_id);
    }
}
