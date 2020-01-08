<?php

namespace App\Http\Controllers\Admin;

use App\Notification;
use App\Occasion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\RegistrationStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invite;
use App\ClientAdvisor;
use App\Client;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Setting;

class DashboardController extends Controller
{

    /**
     * Generate invite client view
     *
     */
    public function invite()
    {
        $registrationStatuses = RegistrationStatus::all();
        $clientAdvisors = ClientAdvisor::all();
        return view('admin.dashboard.invite')
            ->with(['registrationStatuses' => $registrationStatuses])
            ->with(['clientAdvisors' => $clientAdvisors]);
    }

    public function updateClientAdvisor()
    {

    }


    /**
     * Deleting CA from db
     *
     */
    public function deleteClientAdvisor($id)
    {
        $user = User::find($id);
        $registrationStatuses = RegistrationStatus::where('email', $user->email);
        $clientAdvisor = ClientAdvisor::where('user_id',$id)->first();
        $clients = Client::where('client_advisor_id', $clientAdvisor->id)->get();
        foreach ($clients as $client){
            foreach ($client->occasions as $occasion){
                foreach ($occasion->reminders as $reminder){
                    //Delete Client's Reminders
                    $reminder->delete();
                }
                //Delete Occasion
                $occasion->delete();
            }
            foreach ($client->feedbacks as $feedback){
                //Delete Feedback
                $feedback->delete();
            }
            //Delete Notifications
            $notifications = Notification::where('type', 'client')->where('type_id', $client->id)->delete();
            //Delete Client
            $client->delete();
        }

        $registrationStatuses->delete();

        $clientAdvisor->delete();
        $user->delete();

        Session::flash('message', 'Client Advisor deleted');
        return redirect()->route('admin.invite');

    }

    public function editViewClientAdvisor($id)
    {
        $clientAdvisor = ClientAdvisor::where('id', $id)->first();
        $occasions_total_limit = Setting::where('name', 'Occasions limit')->first();
        $occasions_count = Occasion::whereHas('client', function($query) use ($id){
            $query->whereHas('clientAdvisor', function($query) use ($id){
                $query->where('id', $id);
            });
        })->count();

        $occasions_available = $occasions_total_limit->value - Occasion::count();

        return view('admin.dashboard.edit')
            ->with(['occasions_available' => $occasions_available])
            ->with(['occasions_count' => $occasions_count])
            ->with(['clientAdvisor' => $clientAdvisor]);
    }

    public function editClientAdvisor($id, Request $request)
    {
        $client_advisor = ClientAdvisor::where('id', $id)->first();
        if ($request->email == $client_advisor->user->email) {
            $client_advisor->name = $request->name;
            $client_advisor->user->name = $request->name;
            $client_advisor->user->save();
            $client_advisor->surname = $request->surname;
            $client_advisor->mobile_phone = $request->number;
            $client_advisor->street = $request->street;
            $client_advisor->city = $request->city;
            $client_advisor->plz = $request->plz;
            $client_advisor->country = $request->country;
            $client_advisor->birthday = $request->birthday;
            $client_advisor->occasion_limit = $request->occasion_limit;
            $client_advisor->save();
            Session::flash('success', 'Your account details have been updated');
            return back();
        } else {

            $input['email'] = Input::get('email');
            $rules = array('email' => 'unique:users,email');
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                Session::flash('error', 'That email address is already registered');
                return back();
            } else {
                $client_advisor->user->email = $request->email;
                $client_advisor->user->save();
                Session::flash('success', 'Your account details have been updated');
                return back();
            }
        }
    }

    /**
     * Create new email for invitation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to inviting page
     */
    public function store(Request $request)
    {
        $email = $request->email[0];
        $email_array = preg_split('/;|,/', $email);

        foreach ($email_array as $item)
        {
            $nameEmailData = preg_split('/ /', $item);

            $invite = new RegistrationStatus();
            $invite->email = $nameEmailData[1];
            $invite->name =  $nameEmailData[0];
            $invite->created_by =  Auth::user()->id;
            $invite->code = substr(md5(uniqid(rand(1,6))), 0, 7);
            $invite->save();

        }

        return redirect('/admin/invite');
    }


    public function deleteInvite($email)
    {
        $registrationStatuses = RegistrationStatus::where('email', $email);
        $registrationStatuses->delete();

        $user = User::where('email', $email)
            ->whereDoesntHave('clientAdvisor')
            ->first();

        if(isset($user) && $user) {
            $user->delete();
        }


        Session::flash('success', 'Invitation successfully deleted!');
        Session::flash('message', 'Deleted');
        return redirect()->route('admin.invite');
    }

    /**
     * Sending invite message
     *
     * @return redirect to inviting page
     */
    public function send_mail($email, $hash, $name)
    {
        $registrationStatuses = RegistrationStatus::where('email', $email)->first();
        $registrationStatuses->email_status = '1';
        $registrationStatuses->save();
        Mail::to($email)->send(new Invite($email, $hash, $name));
        Session::flash('success', 'The invitation has been sent.');
        return redirect('/admin/invite');
    }

    public function sendAll(Request $request)
    {
        $array  = $request->array;
        foreach ($array as $email)
        {
            $hash = RegistrationStatus::where('email', $email)->pluck('code')->first();
            $name = RegistrationStatus::where('email', $email)->pluck('name')->first();
            $registrationStatuses = RegistrationStatus::where('email', $email)->first();
            $registrationStatuses->email_status = '1';
            $registrationStatuses->save();
            Mail::to($email)->send(new Invite($email, $hash, $name));
        }

        return "The invitations has been sent";
    }


}
