<?php

namespace App\Http\Controllers;

use App\Payment;

class PaymentLogController extends Controller
{

    public function index()
    {
        $payments = Payment::all();

        return view('payment.paymentLog', [
            'title' => 'Payment Log',
            'payments' => $payments
        ]);
    }

}