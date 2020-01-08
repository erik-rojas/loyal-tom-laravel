<?php

namespace App\Http\Controllers\ClientAdvisor;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Click;
use Auth;

class ClickController extends Controller
{

    /**
     * Count Clicks for buy buttons, store in DB, used for Analytics
     * @param Request $request - Idea id, Reminder id, type of button
     * @return string
     */
    public function create(Request $request)
    {
        $click = new Click();
        $click->idea_id = $request->idea_id;
        $click->reminder_id = $request->reminder_id;
        $click->client_advisor_id = Auth::user()->clientAdvisor->id;
        $click->type = $request->type;
        $click->save();

        return('success');
    }
}
