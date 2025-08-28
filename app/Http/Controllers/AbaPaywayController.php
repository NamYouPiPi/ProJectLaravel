<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbaPaywayController extends Controller
{
    public function redirect(Request $request)
    {
        $amount = $request->input('amount');
        $order_id = $request->input('order_id');
        $description = $request->input('description');
        $return_url = route('bookingseats.success');
        $cancel_url = url('/');

        // Generate ABA PayWay QR payload (replace with real logic as per ABA docs)
        $qrCodeData = "ABA_PAYWAY_PAYLOAD_FOR_AMOUNT_{$amount}_ORDER_{$order_id}";

        // Pass QR code data to a view
        return view('Frontend.Booking.aba_qr', [
            'amount' => $amount,
            'order_id' => $order_id,
            'description' => $description,
            'qrCodeData' => $qrCodeData,
            'return_url' => $return_url,
        ]);
    }
}

