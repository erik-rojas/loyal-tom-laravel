<?php

namespace App\Http\Controllers\ClientAdvisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;
use App\Notification;
use Auth;
use Response;
use Session;


class FeedbackController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exist = Feedback::where('client_id', $request->clientId)->where('idea_id', $request->ideaId)->count();
            if ($exist == 0){
                $feedback = new Feedback();
                $feedback->client_id = $request->clientId;
                $feedback->idea_id = $request->ideaId;
                $feedback->status = $request->status;
                $feedback->save();

                //New Notification
                $notification = new Notification();
                $notification->user_id = Auth::user()->id;
                $notification->type = 'feedback';
                $notification->type_id = $feedback->id;
                $notification->save();
                if ($request->status == 'I LIKE THIS IDEA') {
                    return Response::json([
                        'success'=>'Thank you! Your feedback has been recorded. If you purchase it yourself, please let us know as well']);
                }
                return Response::json([
                    'success'=>'Thank you! Your feedback has been recorded!']);
            } else {
                return Response::json([
                    'error'=>'You have already gave the feedback to this idea']);
            }
        }
}
