<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('id', 'desc')->get();
        return view('admin.payment.index')->withPayments($payments);
    }

    public function changeStatus(Request $request)
    {
        $payment = Payment::find($request->payment_id);
        $payment->status = $request->status;
        $payment->save();

        return('success');

    }
}
