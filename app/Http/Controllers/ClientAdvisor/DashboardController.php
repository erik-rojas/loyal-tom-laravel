<?php

namespace App\Http\Controllers\ClientAdvisor;

use App\ClientAdvisor;
use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use App\RegistrationStatus;
use Auth;
use App\Client;
use App\ClientName;
use App\Occasion;
use JavaScript;
use App\Notification;
use App\Tag;
use App\Setting;
use Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function addClientPublic()
    {
        $id = Auth::user()->clientAdvisor->id;
        $occasions_count = Occasion::whereHas('client', function($query) use ($id){
            $query->whereHas('clientAdvisor', function($query) use ($id){
                $query->where('id', $id);
            });
        })->count();
        if($occasions_count >= Auth::user()->clientAdvisor->occasion_limit){

            Session::flash('error', 'You reached Occasions limit. Please, contact Admin to increase your limit.');
            return back();
        }

        $createdBy = RegistrationStatus::where('email', Auth::user()->email)->select('created_by')->first();

        $clientNames = ClientName::inRandomOrder()->get();
        foreach ($clientNames as $clientName){
            $exist = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->where('name', $clientName->name)->count();
            if(!$exist){
                $name = $clientName->name;
                break;
            }
        }

        $ca_clients = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->pluck('id');
        $occasionAll = Occasion::whereIn('client_id', $ca_clients)->count();
        $setting = Setting::where('name', 'Occasions limit')->first();
        $character = Tag::where('category','character')->pluck('name')->toArray();
        $region = Tag::where('category', 'region')->pluck('name')->toArray();
        $ageOptions = ["18-25", "26-36", "36-45", "46-55", "56-65", "65+"];

        return view('client.dashboard.addClientPublic')
            ->with(['createdBy' => $createdBy])
            ->with(['occasionAll' => $occasionAll])
            ->with(['character' => $character])
            ->with(['ageOptions' => $ageOptions])
            ->with(['region' => $region])
            ->withSetting($setting)
            ->with(['name' => $name]);
    }

    public function addClientPrivate()
    {
        $id = Auth::user()->clientAdvisor->id;
        $occasions_count = Occasion::whereHas('client', function($query) use ($id){
            $query->whereHas('clientAdvisor', function($query) use ($id){
                $query->where('id', $id);
            });
        })->count();
        if($occasions_count >= Auth::user()->clientAdvisor->occasion_limit){

            Session::flash('error', 'You reached Occasions limit. Please, contact Admin to increase your limit.');
            return back();
        }

        $createdBy = RegistrationStatus::where('email', Auth::user()->email)->select('created_by')->first();

        $clientNames = ClientName::inRandomOrder()->get();
        foreach ($clientNames as $clientName){
            $exist = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->where('name', $clientName->name)->count();
            if(!$exist){
                $name = $clientName->name;
                break;
            }
        }

        $ca_clients = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->pluck('id');
        $occasionAll = Occasion::whereIn('client_id', $ca_clients)->count();
        $setting = Setting::where('name', 'Occasions limit')->first();
        $character = Tag::where('category','character')->pluck('name')->toArray();
        $region = Tag::where('category', 'region')->pluck('name')->toArray();
        $ageOptions = ["18-25", "26-36", "36-45", "46-55", "56-65", "65+"];

        return view('client.dashboard.addclient')
            ->with(['createdBy' => $createdBy])
            ->with(['occasionAll' => $occasionAll])
            ->with(['character' => $character])
            ->with(['ageOptions' => $ageOptions])
            ->with(['region' => $region])
            ->withSetting($setting)
            ->with(['name' => $name]);
    }

    /**
     * Get all client and occasions for CA.
     *
     * @return view
     */
    public function addOccasion()
    {
        $createdBy = RegistrationStatus::where('email', Auth::user()->email)->select('created_by')->first();
        $clientNames = ClientName::inRandomOrder()->get();
        foreach ($clientNames as $clientName){
            $exist = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->where('name', $clientName->name)->count();
            if(!$exist){
                $name = $clientName->name;
                break;
            }
        }
        $clients = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->get();
        $setting = Setting::where('name', 'Occasions limit')->first();
        return view('client.dashboard.addoccasion')
            ->with(['createdBy' => $createdBy])
            ->with(['name' => $name])
            ->withSetting($setting)
            ->with(['clients' => $clients]);
    }

    /**
     * Single page for client of client advisor with occasions.
     *
     * @return view
     */
    public function clientOccasion($id)
    {

        $client = Client::where('id', $id)->first();
        $locations = Tag::where('category', 'region')->get();
        $ages = Tag::where('category', 'age')->get();
        /** @var TYPE_NAME $characters */
        $characters = Tag::where('category', 'character')->get();
        $character = Tag::where('category','character')->pluck('name')->toArray();
        $createdBy = RegistrationStatus::where('email', Auth::user()->email)->select('created_by')->first();
        $setting = Setting::where('name', 'Occasions limit')->first();
        JavaScript::put([
            'id' => compact('id')
        ]);
        $client_id = $id;
        $ageOptions = ["18-25", "26-36", "36-45", "46-55", "56-65", "65+"];
        $ca_clients = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->pluck('id');
        $occasionAll = Occasion::whereIn('client_id', $ca_clients)->count();
        return view('client.dashboard.addoccasionitem',compact('id'))
            ->withSetting($setting)
            ->with(['occasionAll' => $occasionAll])
            ->with(['ageOptions' => $ageOptions])
            ->with(['character' => $character])
            ->with(['client_id' => $client_id])
            ->withLocations($locations)
            ->withAges($ages)
            ->withCharacters($characters)
            ->withClient($client);
    }


    /**
     * Generation the json with data for react components.
     *
     * @return json
     */
    public  function json()
    {
        $character = Tag::where('category','character')->pluck('name')->toArray();
        $region = Tag::where('category', 'region')->pluck('name')->toArray();
        $response = array(
            "ownerName" => 's',
            "petSelections" => $character,
            "hateSelection" => $character,
            'occasionEnjoySelection' => $character,
            "occasionHateSelection" => $character,
            "selectedPets" => [],
            "selectedPets1" => [],
            "locale"  => $region,
            "sex"     => ["Female", "Male"],
            "ageOptions" => ["18-25", "26-36", "36-45", "46-55", "56-65", "65+"],
            "childAgeOptions" => ["0-5", "6-12", "13-17", "18-25", "26-35", "36-45", "46-55", "56-65", "65+"],
            "ownerAgeRangeSelection" => [],
            "localeSelect" => "",
            "sexSelect"  => []
        );
        return \Response::json($response);
    }

    /**
     * Saving client and his/her preferance
     *
     * @return modal
     */

    public function interests(Request $request)
    {

        $this->validate($request, [
            'gender' => 'required',
            'ageRange' => 'required',
            'enjoys' => 'required',
            'location'  => 'required',
        ]);


        $createdBy = RegistrationStatus::where('email', Auth::user()->email)->select('created_by')->first();
        $clientNames = ClientName::inRandomOrder()->get();
        foreach ($clientNames as $clientName){
            $exist = Client::where('client_advisor_id', Auth::user()->clientAdvisor->id)->where('name', $clientName->name)->count();
            if(!$exist){
                $name = $clientName->name;
                break;
            }
        }

        $client  = new Client();
        $client->client_advisor_id = Auth::user()->clientAdvisor->id;
        $client->admin_id = $createdBy->created_by;

        $client->name =  $name;
        $client->gender = $request->gender;
        $client->age = $request->ageRange;
        $client->like = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->enjoys)));
        $client->dislike = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->hates)));
        $client->country = $request->location;
        $client->save();

        //New Notification
        $notification = new Notification();
        $notification->user_id = Auth::user()->id;
        $notification->type = 'client';
        $notification->type_id = $client->id;
        $notification->save();

        $occasion = new Occasion();
        $occasion->client_id = $client->id;
        //$week = preg_replace("/[^0-9]/","",$request->dataWeek);
        $week = $request->dataWeek;
        $occasion->date = $week;



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


    /**
     * Adding new occasion to existing client
     *
     * @return \Illuminate\Http\Response
     */
    public function newOccasion(Request $request)
    {
        $this->validate($request, [
            'dataWeek' => 'required',
            'type' => 'required',
           
        ]);
        $occasion = new Occasion();
        $occasion->client_id = $request->id;
        //$week = preg_replace("/[^0-9]/","",$request->data);
        $week = $request->dataWeek;
        $occasion->date = $request->dataWeek;


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
        $occasion->gender = $request->genderRelative;
        $occasion->like = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->enjoysRelative)));
        $occasion->dislike = htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->hatesRelative)));
        $occasion->relative = $request->relative;
        $occasion->age = $request->ageRangeRelative;
        $occasion->save();

        //New Notification
        $notification = new Notification();
        $notification->user_id = Auth::user()->id;
        $notification->type = 'occasion';
        $notification->type_id = $occasion->id;
        $notification->save();
        Session::flash('success', 'New occasion has been successfully created.');
        return back();
    }
    /**
     *
     */
    public function clientUpdate(Request $request)
    {
        $client = Client::where('id', $request->id )->first();
        $client->country = $request->location;
        $client->gender = $request->gender;
        $client->age = $request->age;
        $client->save();
        Session::flash('success', 'Your client details have been updated');
        return back();
    }

    public function clientLikesUpdate(Request $request)
    {
        $occasion = Occasion::where('id',$request->id)->first();
        $occasion->like =  htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->like)));
        $occasion->save();
        Session::flash('success', 'Updated');
        return back();
    }
    public function clientDislikesUpdate(Request $request)
    {
        $occasion = Occasion::where('id',$request->id)->first();
        $occasion->dislike =  htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->dislike)));
        $occasion->save();
        Session::flash('success', 'Updated');
        return back();
    }

    public function clientAdvisorDislikesUpdate(Request $request)
    {
        $client = Client::where('id', $request->id)->first();
        $client->dislike =  htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->dislike)));
        $client->save();
        Session::flash('success', 'Updated');
        return back();
    }
    public function clientAdvisorLikesUpdate(Request $request)
    {
        $client = Client::where('id', $request->id)->first();
        $client->like =  htmlentities(str_replace(array('"', "'", '[', ']'),'',json_encode($request->like)));
        $client->save();
        Session::flash('success', 'Updated');
        return back();
    }

    public function deleteOccasion($id)
    {
        $occasion = Occasion::whereHas('reminders', function ($query){
            $query->where('email_sent', true);
        })->where('id', $id);
        if (!$occasion->count())
        {
            $occasion = Occasion::where('id', $id)->first();
            //Delete Notification
            $notification = Notification::where('type', 'occasion')->where('type_id', $occasion->id)->first();
            $notification->delete();
            $occasion->delete();
            Session::flash('success', 'Deleted');
            return redirect()->back();
        }
        Session::flash('error', 'The reminders had been sent');
        return redirect()->back();
    }

}

