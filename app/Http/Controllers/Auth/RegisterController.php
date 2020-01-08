<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ClientAdvisor;
use App\Role;
use App\RegistrationStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Auth\Input;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;
use Session;
use Carbon\Carbon;
use Exception;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $code = RegistrationStatus::where('email', $data['email'])->where('code', $data['code'])->first();
        $role_advisor = Role::where('name', 'ClientAdvisor')->first();
        $user = new User;
        $user->name = $data['name'];

        $user->email = $data['email'];
        $user->role_id = $role_advisor->id;
        $user->password = bcrypt($data['password']);
        $user->save();

        $client_advisor = new ClientAdvisor();
        $client_advisor->user_id = $user->id;
        $client_advisor->name = $data['name'];
        $client_advisor->surname = $data['surname'];
        $client_advisor->organization = $data['organization'];
        $client_advisor->role = $data['role'];
        $client_advisor->mobile_phone = $data['phone'];
        $client_advisor->street = $data['street'];
        $client_advisor->city = $data['city'];
        $client_advisor->plz = $data['plz'];
        $client_advisor->country = $data['country'];

        try{
            $birthday = Carbon::parse($data['birthday'])->format('Y-m-d');
        }
        catch (Exception $e) {
            $birthday = null;
        }

        $client_advisor->birthday = $birthday;
        $client_advisor->save();

        //

        //Change Status of registration
        $code->status = '1';
        $code->save();

        return $user;

    }
    public function register(Request $request)
    {

        $rules=[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'code' => 'required',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|min:6|same:password',
        ];
        $error_messages=[
            'code' => 'provide activation code',
            'password_confirmation.same'=>'password are not the same password must match same value',
            'password.min'=>'password length must be greater than 6 characters',
            'password_confirmation.min'=>'confirm-password length must be greater than 6 characters',


        ];
        $errors=  validator($request->all(), $rules, $error_messages);
        if ($errors->fails()) {
            return redirect('/register')
                ->withErrors($errors)
                ->withInput();
        }
        $code = RegistrationStatus::where('email', $request['email'])->where('code', $request['code'])->count() > 0;
        if ($code) {
            event(new Registered($user = $this->create($request->all())));
            $this->guard()->login($user);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        } else {
            $errors = 'Activation code not match with generated for your email';
            return redirect('/register')
                ->withErrors($errors)
                ->withInput();
        }
    }

}
