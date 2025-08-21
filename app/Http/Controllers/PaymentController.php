<?php

namespace App\Http\Controllers;

use App\Services\AbAPayWayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
public function pay(AbAPayWayService $aba)
    {
        $orderId = uniqid('order_');
        $amount = 1000; // Amount in KHR
        $returnUrl = route('payment.callback');

        $response = $aba->createPayment($orderId, $amount, $returnUrl);

        if (isset($response['payment_url'])) {
            return redirect($response['payment_url']);
        }

        return back()->with('error', 'Payment initiation failed.');
    }

    public function callback(Request $request)
    {
        // Handle ABA callback/redirect here
        // Validate hash, update order status, etc.
        return view('Backend.payment.Callback ', ['data' => $request->all()]);
    }
}
