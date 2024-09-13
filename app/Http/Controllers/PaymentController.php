<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Payment view
    public function paymentView(){
        $payments = Payment::get();
        return view('admin.payment.payment', compact('payments'));
    }

    // Payment create
    public function create(Request $request){
        $this->checkValidation($request);
        $payment = [
            'type' => $request->paymentType,
            'account_name' => $request->paymentName,
            'account_number' => $request->paymentNumber
        ];

        Payment::create($payment);
        return back();
    }

    // Payment create check valdidation
    private function checkValidation($request){
        $request->validate([
            'paymentType' => 'required',
            'paymentName' => 'required',
            'paymentNumber' => 'required'
        ]);
    }
}
