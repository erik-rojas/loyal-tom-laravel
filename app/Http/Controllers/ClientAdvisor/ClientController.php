<?php

namespace App\Http\Controllers\ClientAdvisor;

use App\Client;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\RegistrationStatus;
use App\Notification;
use App\Occasion;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name'          => 'required',
            'address'       => 'required',
            'date_of_birth' => 'required',
            'gender'        => 'required',
            'ageRange'      => 'required',
            'occasion_date' => 'required',
        ));

        $client  = new Client();
        $client->client_advisor_id = Auth::user()->clientAdvisor->id;
        $client->admin_id = RegistrationStatus::where('email', Auth::user()->email)->select('created_by')->first()->created_by;

        $client->name =  $request->name;
        $client->gender = $request->gender;
        $client->date_of_birth = $request->agedate_of_birthRange;
        $client->age = $request->ageRange;
        $client->like = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->enjoys)));
        $client->dislike = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->hates)));
        $client->address = $request->address;
        $client->save();

        //New Notification
        $notification = new Notification();
        $notification->user_id = Auth::user()->id;
        $notification->type = 'client';
        $notification->type_id = $client->id;
        $notification->save();

        $occasion = new Occasion();
        $occasion->client_id = $client->id;
        $week = Carbon::parse($request->occasion_date)->format('W');
        $occasion->date = Carbon::parse($request->occasion_date)->format('W');
        $occasion->date_new = Carbon::parse($request->occasion_date)->toDateString();



        if(date('W') < $week){
            $year = date('Y');
        }else{
            $year = date('Y')+1;
        }
        //Email Date (Monday of 2 previous week)
        $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( ($week - 2) * 7 * 24 * 60 * 60 );
        $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
        $occasion->due_date = date( 'Y-m-d', $timestamp_for_monday );

        //SMS Date (Tuesday of previous week)
        $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( ($week - 3) * 7 * 24 * 60 * 60 );
        $occasion->sms_date = Carbon::createFromTimestamp($timestamp)->addDays(5)->format('Y-m-d');


        $occasion->type = $request->type;
        $occasion->budget = $request->budget;
        $occasion->like = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->enjoysRelative)));
        $occasion->dislike = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->hatesRelative)));
        $occasion->gender =  $request->genderRelative;
        $occasion->relative = $request->relative;
        $occasion->age = $request->ageRangeRelative;
        $occasion->save();

        //New Notification
        $notification = new Notification();
        $notification->user_id = Auth::user()->id;
        $notification->type = 'occasion';
        $notification->type_id = $occasion->id;
        $notification->save();
        return redirect()->route('ca.occasion');
    }
}
