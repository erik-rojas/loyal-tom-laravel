<?php

namespace App\Http\Controllers\ClientAdvisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class PaymentController extends Controller
{
    /**
     * Stripe payment integration
     *
     * @return flash message
     */
    public function pay(Request $request) {

        \Stripe\Stripe::setApiKey('sk_test_7jjMYYbaHDawoNetk69xn3zb');
        $charge = \Stripe\Charge::create(array('amount' => $request->amount, 'currency' => $request->currency, 'source' => $request->stripeToken, 'description' => $request->description));
        Session::flash('success', 'Payment was successfully made!');
        return redirect()->back();
    }
}
