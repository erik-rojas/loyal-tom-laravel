<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Setting;

class CurrencyController extends Controller
{
    /**
     * @return Settings View with
     * withCurrencies($currencies)
     * withExpiration($expiration)
     * withLimits($limits);
     */
    public function edit()
    {
        $currencies = Currency::where('editable', true)->get();
        $limits = Setting::where('name', 'Ocassion Limit')->first();
        $expiration = Setting::where('name', 'Expiration Date')->first();
        return view('admin.currency.edit')
            ->withCurrencies($currencies)
            ->withExpiration($expiration)
            ->withLimits($limits);
    }

    /**
     * @param Request $request - Currency Settings
     * @return back()
     */
    public function update(Request $request)
    {
        $currencies = Currency::where('editable', true)->get();
        foreach ($currencies as $currency){
            $currency->rate = $request[$currency->name];
            $currency->save();
        }

        return back();
    }
}
