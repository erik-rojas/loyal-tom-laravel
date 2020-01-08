<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Session;
use App\Idea;
use App\Tag;
use App\Occasion;
use App\Reminder;
use App\Mail\SendReminder;
use App\Feedback;
use Illuminate\Support\Facades\Mail;



class ReminderController extends Controller
{
    /**
     * @return All Reminders View
     */
    public function index()
    {
        $occasions = Occasion::orderBy('due_date', 'asc')->get();

        return view('admin.reminder.index')->withOccasions($occasions);
    }

    /**
     * @param $id - Occasion id
     * @return Create Reminder View with:
     * withIdeas($ideas)
     * withOccasion($occasion)
     * withReminder($reminder)
     * withTags($tags)
     * withSelected_tags($selected_ids)
     */
    public function create($id)
    {

        session()->forget('status');
        $occasion = Occasion::find($id);
        $reminder = Reminder::where('occasion_id', $id)->where('status', 'Draft')->orderBy('id', 'desc')->first();

        if (!$reminder) {
            $reminder = new Reminder();
            $reminder->occasion_id = $occasion->id;
            $reminder->status = 'Draft';
            $reminder->save();
        }

        if (!$occasion->relative) {
            $enjoys = explode(",", $occasion->client->like);
            $selected_ids = array();

            foreach ($enjoys as $enjoy) {
                $id = Tag::select('id')->where('name', $enjoy)->first();
                if(isset($id) && $id){
                    $selected_ids[] = $id->id;
                }
            }

            $not_enjoys = explode(",", $occasion->client->dislike);
            $dislike_ids = array();
            foreach ($not_enjoys as $enjoy) {
                $id = Tag::select('id')->where('name', $enjoy)->first();
                if(isset($id) && $id){
                    $dislike_ids[] = $id->id;
                }
            }
            //Include Client's opposite gender to not enjoy
            if($occasion->client->gender == 'Female'){
                $id = Tag::select('id')->where('name', 'Male')->first();
                $dislike_ids[] = $id->id;
            }
            elseif($occasion->client->gender == 'Male'){
                $id = Tag::select('id')->where('name', 'Female')->first();
                $dislike_ids[] = $id->id;
            }
            //Include Client's opposite age to not enjoy
            $ages = Tag::where('category', 'age')->where('name', '<>', $occasion->client->age)->get();
            foreach ($ages as $age){
                $dislike_ids[] = $age->id;
            }
            //Include Client's opposite cities to not enjoy
            $regions = Tag::where('category', 'region')->where('name', '<>', $occasion->client->country)->get();
            foreach ($regions as $region){
                $dislike_ids[] = $region->id;
            }


        } else {
            $enjoys = explode(",", $occasion->like);
            $selected_ids = array();

            foreach ($enjoys as $enjoy) {
                $id = Tag::select('id')->where('name', $enjoy)->first();
                if(isset($id) && $id){
                    $selected_ids[] = $id->id;
                }
            }

            $not_enjoys = explode(",", $occasion->dislike);
            $dislike_ids = array();
            foreach ($not_enjoys as $not_enjoy) {
                $id = Tag::select('id')->where('name', $not_enjoy)->first();
                if(isset($id) && $id){
                    $dislike_ids[] = $id->id;
                }
            }

            //Include Client's Relative opposite gender to not enjoy
            if($occasion->gender == 'Female'){
                $id = Tag::select('id')->where('name', 'Male')->first();
                $dislike_ids[] = $id->id;
            }
            elseif($occasion->gender == 'Male'){
                $id = Tag::select('id')->where('name', 'Female')->first();
                $dislike_ids[] = $id->id;
            }
            //Include Client's relative opposite age to not enjoy
            $ages = Tag::where('category', 'age')->where('name', '<>', $occasion->age)->get();
            foreach ($ages as $age){
                $dislike_ids[] = $age->id;
            }
            //Include Client's opposite cities to not enjoy
            $regions = Tag::where('category', 'region')->where('name', '<>', $occasion->client->country)->get();
            foreach ($regions as $region){
                $dislike_ids[] = $region->id;
            }
        }

        //Tags
        $tags = Tag::all();
        $client_id = $occasion->client_id;
        $client_advisor_id = $occasion->client->clientAdvisor->id;

        //Budget of Occasion
        if($occasion->budget == 100){
            $budget = 100;
        }
        else{
            $budget = pow(2,31);
        }

        //Ideas
        $ideas = Idea::whereHas('tags', function ($query) use ($selected_ids) {
            $query->whereIn('tags.id', $selected_ids);
        })
            //, '=', count($GLOBALS['tags']) <- Adding This will find exactly
            ->whereDoesntHave('tags', function ($query) use ($dislike_ids){
                $query->whereIn('tags.id', $dislike_ids);
            })
            ->whereDoesntHave('reminders', function($query) use ($client_id){
                $query->whereHas('occasion', function($query) use ($client_id){
                    $query->where('client_id', $client_id);
                });
            })
            ->whereDoesntHave('feedbacks', function($query) use ($client_advisor_id){
                $query->where('status', 'Don\'t show me this idea any more')->whereHas('client', function($query) use ($client_advisor_id){
                    $query->where('client_advisor_id', $client_advisor_id);
                });
            })
            ->where(function ($query) use ($reminder) {
                $query->whereDoesntHave('dates')
                    ->orWhereHas('dates', function ($query) use ($reminder){
                        $query->where('date', '>=', $reminder->occasion->due_date);
                    });
            })
            ->leftJoin('currencies', 'ideas.currency_id', 'currencies.id')
            ->select('ideas.*', 'currencies.rate')
            ->where('price', '<=', DB::raw($budget.'/currencies.rate'))
            ->paginate(120);

        return view('admin.reminder.create')
            ->withIdeas($ideas)
            ->withOccasion($occasion)
            ->withReminder($reminder)
            ->withTags($tags)
            ->withSelected_tags($selected_ids)
            ->withStatus('');
    }

    /**
     * @param $id - Occasion ID
     * @param Request $request - Tags ids
     * @return View with filtered Tags
     */
    public function filter($id, Request $request)
    {
        $occasion = Occasion::find($id);
        $reminder = Reminder::where('occasion_id', $id)->where('status', 'Draft')->orderBy('id', 'desc')->first();
        $tags = Tag::all();

        if (!$occasion->relative) {

            $not_enjoys = explode(",", $occasion->client->dislike);
            $dislike_ids = array();
            foreach ($not_enjoys as $enjoy) {
                $id = Tag::select('id')->where('name', $enjoy)->first();
                if(isset($id) && $id){
                    $dislike_ids[] = $id->id;
                }
            }
            //Include Client's opposite gender to not enjoy
            if($occasion->client->gender == 'Female'){
                $id = Tag::select('id')->where('name', 'Male')->first();
                $dislike_ids[] = $id->id;
            }
            elseif($occasion->client->gender == 'Male'){
                $id = Tag::select('id')->where('name', 'Female')->first();
                $dislike_ids[] = $id->id;
            }
            //Include Client's opposite age to not enjoy
            $ages = Tag::where('category', 'age')->where('name', '<>', $occasion->client->age)->get();
            foreach ($ages as $age){
                $dislike_ids[] = $age->id;
            }
            //Include Client's opposite cities to not enjoy
            $regions = Tag::where('category', 'region')->where('name', '<>', $occasion->client->country)->get();
            foreach ($regions as $region){
                $dislike_ids[] = $region->id;
            }
        } else {

            $not_enjoys = explode(",", $occasion->dislike);
            $dislike_ids = array();
            foreach ($not_enjoys as $enjoy) {
                $id = Tag::select('id')->where('name', $enjoy)->first();
                $dislike_ids[] = $id->id;
            }
            //Include Client's Relative opposite gender to not enjoy
            if($occasion->gender == 'Female'){
                $id = Tag::select('id')->where('name', 'Male')->first();
                $dislike_ids[] = $id->id;
            }
            elseif($occasion->gender == 'Male'){
                $id = Tag::select('id')->where('name', 'Female')->first();
                $dislike_ids[] = $id->id;
            }
            //Include Client's relative opposite age to not enjoy
            $ages = Tag::where('category', 'age')->where('name', '<>', $occasion->age)->get();
            foreach ($ages as $age){
                $dislike_ids[] = $age->id;
            }
            //Include Client's opposite cities to not enjoy
            $regions = Tag::where('category', 'region')->where('name', '<>', $occasion->client->country)->get();
            foreach ($regions as $region){
                $dislike_ids[] = $region->id;
            }
        }

        //Budget of Occasion
        if($occasion->budget == 100){
            $budget = 100;
        }
        else{
            $budget = pow(2,31);
        }

        //Selected Tags
        if(!$request->tags){
            if(session('selected_tags')){
                $selected_tags = session('selected_tags');
            }
            else{
                $selected_tags = Tag::pluck('id')->all();
                session(['selected_tags' => [] ]);
            }
        }
        else{
            $selected_tags = $request->tags;
            session(['selected_tags' => $selected_tags]);
        }

        if($request->status){
            $status = $request->status;
        }
        elseif(session('status')){
            $status = session('status');
        }
        else{
            $status = 'I LIKE THIS IDEA';
        }
        session(['status' => $status]);


        $client_id = $occasion->client_id;
        $client_advisor_id = $occasion->client->clientAdvisor->id;

        $ideas = Idea::whereHas('tags', function ($query) use ($selected_tags){
            $query->whereIn('tags.id', $selected_tags );
        })
            //, '=', count($GLOBALS['tags']) <- Adding This will find exactly
            ->whereDoesntHave('tags', function ($query) use($dislike_ids) {
                $query->whereIn('tags.id', $dislike_ids);
            })
            ->whereDoesntHave('reminders', function($query) use ($client_id){
                $query->whereHas('occasion', function($query) use ($client_id){
                    $query->where('client_id', $client_id);
                });
            })
            ->whereDoesntHave('feedbacks', function($query) use ($client_advisor_id){
                $query->where('status', 'Don\'t show me this idea any more')->whereHas('client', function($query) use ($client_advisor_id){
                    $query->where('client_advisor_id', $client_advisor_id);
                });
            })
            ->where(function ($query) use ($reminder) {
                $query->whereDoesntHave('dates')
                    ->orWhereHas('dates', function ($query) use ($reminder){
                        $query->where('date', '>=', $reminder->occasion->due_date);
                    });
            })
            ->leftJoin('currencies', 'ideas.currency_id', 'currencies.id')
            ->select('ideas.*', 'currencies.rate')
            ->where('price', '<=', DB::raw($budget.'/currencies.rate'))
            ->withCount(['feedbacks'=> function ($query) use ($status){
                $query->where('status', $status);
            }])
            ->orderBy('feedbacks_count', 'desc')
            ->paginate(50);

        return view('admin.reminder.create')
            ->withIdeas($ideas)
            ->withOccasion($occasion)
            ->withTags($tags)
            ->withSelected_tags($selected_tags)
            ->withReminder($reminder)
            ->withStatus($status);
    }

    /**
     * @param $id - Occasion id
     * @param Request $request - search request
     * @return view with search Ideas
     */
    public function search($id, Request $request)
    {
        //Occasion
        $occasion = Occasion::find($id);

        //Reminder
        $reminder = Reminder::where('occasion_id', $id)->where('status', 'Draft')->orderBy('id', 'desc')->first();

        //Tags
        $tags = Tag::all();

        $selected_tags = array();

        if($request->status){
            $status = $request->status;
        }
        elseif(session('status')){
            $status = session('status');
        }
        else{
            $status = 'I LIKE THIS IDEA';
        }
        session(['status' => $status]);

        // Удостоверимся, что поисковая строка есть
        if ($request->has('q')) {

            // Используем синтаксис Laravel Scout для поиска по таблице products.
            $ideas = Idea::search($request->get('q'))->paginate(50);

            // Если есть результат есть, вернем его, если нет  - вернем сообщение об ошибке.
            if ($ideas->count()) {
                //return view('admin.idea.search')->withIdeas($ideas)->withSearch($request->get('q'));
                return view('admin.reminder.create')
                    ->withIdeas($ideas)
                    ->withOccasion($occasion)
                    ->withReminder($reminder)
                    ->withTags($tags)
                    ->withSelected_tags($selected_tags)
                    ->withStatus($status)
                    ->withSearch($request->get('q'));
            } else {
                Session::flash('warning', 'Nothing Found!');
                //return view('admin.idea.search')->withSearch($request->get('q'));
                return view('admin.reminder.create')
                    ->withOccasion($occasion)->withTags($tags)
                    ->withReminder($reminder)
                    ->withSelected_tags($selected_tags)
                    ->withStatus($status)
                    ->withSearch($request->get('q'));
            }
        }

        $ideas = array();
        Session::flash('warning', 'Nothing Found!');

        return view('admin.reminder.create')
            ->withIdeas($ideas)
            ->withOccasion($occasion)
            ->withTags($tags)
            ->withSelected_tags($selected_tags)
            ->withReminder($reminder);
    }

    /**
     * Add idea to the Reminder
     * @param Request $request - Idea id
     * @return Idea
     */
    public function addIdea(Request $request)
    {
        $reminder = Reminder::where('occasion_id', $request->occasion_id)->orderBy('id', 'desc')->first();
        $idea = Idea::find($request->idea_id);
        if ($reminder && $reminder->status != 'sent') {
            //if(isset($reminder->ideas)){
            if ($reminder->ideas->count() < 3) {
                $reminder->ideas()->sync($request->idea_id, false);
                return ($idea);
            } else {
                return ('You already have 3 ideas!');
            }
            //}
        } else {
            $reminder = new Reminder();
            $reminder->occasion_id = $request->occasion_id;
            $reminder->status = 'Draft';
            $reminder->save();
            $reminder->ideas()->sync($request->idea_id, false);

            return ($idea);
        }
    }

    /**
     * Remove Idea from the Reminder
     * @param Request $request - Reminder id, Idea id
     * @return string
     */
    public function removeIdea(Request $request)
    {
        $reminder = Reminder::find($request->reminder_id);
        $reminder->ideas()->detach($request->idea_id);
        return ('Success!');

    }

    /**
     * @param $occasion_id
     * @param $idea_id
     * @return view with Idea
     */
    public function showIdea($occasion_id, $idea_id)
    {
        $idea = Idea::find($idea_id);
        $likes = Feedback::where('idea_id', $idea_id)->where('status', 'I LIKE THIS IDEA')->get();
        $dislikes = Feedback::where('idea_id', $idea_id)->where('status', "I don’t like this idea")->get();
        $purchases = Feedback::where('idea_id', $idea_id)->where('status', 'I purchased this idea')->get();
        $mismatch = Feedback::where('idea_id', $idea_id)->where('status', 'Don’t show this idea for this client')->get();
        $occasion = Occasion::find($occasion_id);
        $reminder = Reminder::where('occasion_id', $occasion_id)->where('status', 'Draft')->orderBy('id', 'desc')->first();

        return view('admin.reminder.idea')
            ->withIdea($idea)
            ->withOccasion($occasion)
            ->withLikes($likes)
            ->withDislikes($dislikes)
            ->withPurchases($purchases)
            ->withMismatch($mismatch)
            ->withReminder($reminder);
    }

    /**
     * Preview Reminder
     * @param $reminder_id
     * @return view with Reminder
     */
    public function preview($reminder_id)
    {
        $reminder = Reminder::find($reminder_id);
        $occasion = Occasion::find($reminder->occasion_id);
        return view('admin.reminder.preview')->withReminder($reminder)->withOccasion($occasion);
    }

    /**
     * Change status of the Reminder to scheduled
     * @param $reminder_id
     * @return back()
     */
    public function schedule($reminder_id)
    {
        $reminder = Reminder::find($reminder_id);
        $reminder->status = 'Scheduled';
        $reminder->save();

        Session::flash('success', 'Reminder was scheduled successfully!');
        return back();
    }

    /**
     * Cancel Scheduled Reminder if it is not sent yet
     * @param Request $request - Reminder id
     * @return back()
     */
    public function scheduleCancel(Request $request)
    {
        $reminder = Reminder::find($request->reminder_id);
        $reminder->status = 'Draft';
        $reminder->save();

        Session::flash('success', 'Reminder was unscheduled successfully!');
        return back();
    }

    /**
     * Send reminder manually, status will changed to scheduled
     * @param Request $request - Reminder id
     * @return back()
     */
    public function sendEmail(Request $request)
    {
        $reminder = Reminder::find($request->reminder_id);

        Mail::to($reminder->occasion->client->clientAdvisor->user->email)->send(new SendReminder($reminder));

        $reminder->status = 'Scheduled';
        $reminder->email_sent = true;
        $reminder->save();

        Session::flash('success', 'Email Reminder was sent successfully!');

        return back();

    }

    /**
     * Send SMS manualy, status will changed to scheduled
     * @param Request $request - Reminder id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendSms(Request $request)
    {
        $reminder = Reminder::find($request->reminder_id);
        $phones = $reminder->occasion->client->clientAdvisor->mobile_phone;
        $message = 'Hi '.$reminder->occasion->client->clientAdvisor->name.'! '.$reminder->occasion->client->name.'%27s '.$reminder->occasion->type.' is coming up in a week starting '.Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y').'. Here are our surprise suggestions: '.route('ca.reminders.show', $reminder->id).' If you have any questions, feel free to email us at welcome@loyaltom.com. Yours, LoyalTom';

        //Sending SMS using TextMagic
//
//        $myCurl = curl_init();
//        curl_setopt_array($myCurl, array(
//            CURLOPT_URL => 'https://rest.textmagic.com/api/v2/messages',
//            CURLOPT_POST => true,
//            CURLOPT_POSTFIELDS => http_build_query(array("phones" => $phones, "text" => $message))
//        ));
//        curl_setopt($myCurl, CURLOPT_HTTPHEADER, array(
//            'X-TM-Username: surpriseclub',
//            'X-TM-Key: yGZLSLT7eyYvOZCMsUCU52fFb3v7sS'
//        ));
//        $response = curl_exec($myCurl);
//        curl_close($myCurl);

        //SENDING SMS USING eCALL
        $url = "http://www1.ecall.ch/ecallurl/ECALLURL.ASP?WCI=Interface&Function=SendPage&Address=".$phones."&Message=".$message."&AccountName=gian@floriddia.com&AccountPassword=com.floriddia@gian";
        $url = str_replace(' ', '%20', $url);
        $url = str_replace("'", '%27', $url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_ENCODING,'gzip,deflate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);


        $reminder->status = 'Scheduled';
        $reminder->sms_sent = true;
        $reminder->save();

        Session::flash('success', 'SMS was sent successfully!');

        return back();
    }

    public function deleteReminder($id)
    {
        $reminder = Reminder::find($id);
        if($reminder->ideas->count())
        {
            Session::flash('error', 'You can\'t delete Reminder. This Reminder already has Ideas.');
            return redirect()->route('reminders.create', $reminder->occasion_id);
        }
        else{
            $reminder->delete();
            Session::flash('success', 'Reminder was deleted successfully!');
            return redirect()->route('reminders.index');
        }
    }
}
