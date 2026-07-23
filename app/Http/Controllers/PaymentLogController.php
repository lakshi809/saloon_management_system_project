<?php

namespace App\Http\Controllers;

use App\Payment;

class PaymentLogController extends Controller
{
    // Display all payment records
    public function index()
    {
        // Retrieve all payments from the database
        $payments = Payment::all();

        // Return payment log view with payment data
        return view('payment.paymentLog', [
            'title' => 'Payment Log',
            'payments' => $payments
        ]);
    }
}