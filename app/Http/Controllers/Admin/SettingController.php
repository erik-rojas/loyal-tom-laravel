<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Session;
use App\Currency;
use App\Occasion;

class SettingController extends Controller
{
    /**
     * Stripe payment integration
     *
     * @return flash message
     */
    public function settings()
    {
        $currencies = Currency::where('editable', true)->get();
        $limits = Setting::where('name', 'Occasions limit')->first();
        $expiration = Setting::where('name', 'Contract expiration date')->first();
        $occasions_count = Occasion::count();
        return view('admin.currency.edit')
            ->withCurrencies($currencies)
            ->withExpiration($expiration)
            ->withLimits($limits)
            ->withOccasions_count($occasions_count);
    }

    /**
     * Update currency value
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function currencyUpdate(Request $request)
    {
        $currencies = Currency::where('editable', true)->get();
        foreach ($currencies as $currency){
            $currency->rate = $request[$currency->name];
            $currency->save();
        }
        Session::flash('success', 'The exchange rate has been updated');
        return back();
    }


    /**
     * Update currency value
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function limitUpdate(Request $request)
    {
        $settings = Setting::where('name', 'Occasions limit')->first();
        $settings->name = 'Occasions limit';
        $settings->value = $request->setting;
        $settings->save();
        Session::flash('success', 'The occasions limit has been updated');
        return back();
    }

    /**
     * Update expiration date value
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function expirationUpdate(Request $request)
    {
        $settings = Setting::where('name', 'Contract expiration date')->first();
        $settings->name = 'Contract expiration date';
        $settings->value = $request->setting;
        $settings->save();
        Session::flash('success', 'The contract expiration date has been updated');
        return back();
    }
}
