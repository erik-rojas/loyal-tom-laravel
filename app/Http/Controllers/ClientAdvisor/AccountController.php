<?php

namespace App\Http\Controllers\ClientAdvisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Hash;


use App\ClientAdvisor;

class AccountController extends Controller
{
    /**
     * Return view for account page.
     *
     * @return view
     */
    public function index()
    {
        return view('client.account.index');
    }

    /**
     * Update account information
     *
     * @return modal, flash message
     */
    public function update(Request $request)
    {
        $client_advisor = ClientAdvisor::where('id', Auth::user()->clientAdvisor->id)->first();
        if ($request->email == $client_advisor->user->email)
        {
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

    public function updatePassword(Request $request)
    {
        $this->validate($request, array(
            'old_password'      => 'required',
            'new_password'      => 'required|min:6',
            'confirm_password'  => 'required|min:6|same:new_password',
        ));


        if(Hash::check($request->old_password, Auth::user()->password)){
            Auth::user()->password = bcrypt($request->new_password);
            Auth::user()->save();

            Session::flash('success', 'Password updated successfully!');
            return back();
        }
        else{
            Session::flash('error', 'Wrong current password!');
            return back();
        }
    }

}
