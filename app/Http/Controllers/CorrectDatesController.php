<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Occasion;
use Carbon\Carbon;
use App\User;
use App\ClientAdvisor;

class CorrectDatesController extends Controller
{
    public function index()
    {
        $occasions = Occasion::all();
        foreach ($occasions as $occasion){

            $week = $occasion->date;

            $now_week = Carbon::createFromFormat('Y-m-d H:i:s', $occasion->created_at)->weekOfYear;

            echo($now_week);
            echo('<br>');

            echo($week);
            echo('<br>');

            if($now_week < $week){
                $year = date('Y');
            }else{
                $year = date('Y')+1;
            }
            //Email Date (Monday of 2 previous week)
            $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( ($week - 2) * 7 * 24 * 60 * 60 );
            $timestamp_for_monday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 1 );
            $occasion->due_date = date( 'Y-m-d', $timestamp_for_monday );

            echo(date( 'Y-m-d', $timestamp_for_monday ));
            echo('<br>');

            //SMS Date (Tuesday of previous week)
            $timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ( ($week - 1) * 7 * 24 * 60 * 60 );
            $timestamp_for_tuesday = $timestamp - 86400 * ( date( 'N', $timestamp ) - 2 );
            $occasion->sms_date = date( 'Y-m-d', $timestamp_for_tuesday );

            echo(date( 'Y-m-d', $timestamp_for_tuesday ));
            echo('<br>');
            echo('___________________________________');
            echo('<br>');

            $occasion->save();
        }


    }

    public function emptyUsers()
    {
        $users = User::doesntHave('clientAdvisor')->get();
        dd($users);
    }

    public function deleteCaGian()
    {
        $clientAdvisor = ClientAdvisor::whereHas('user', function ($query){
            $query->where('email', 'gian.floriddia@gmail.com');
        })->first();

        foreach($clientAdvisor->clients as $client){
            foreach($client->occasions as $occasion){
                foreach ($occasion->reminders as $reminder){
                    $reminder->clicks()->delete();
                    $reminder->delete();
                }
                $occasion->delete();
            }
            $client->delete();
        }
    }

}



