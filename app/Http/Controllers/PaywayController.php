<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaywayController extends Controller
{
    /**
     * Display a simple checkout form.
     */
    public function showCheckoutForm()
    {
        return view('checkout');
    }

    /**
     * Initiate a payment transaction by redirecting to PayWay.
     */
    public function initiatePayment(Request $request)
    {
        // 1. Prepare payment data (replace with your actual order data)
        $merchantId = env('PAYWAY_MERCHANT_ID');
        $apiKey = env('PAYWAY_API_KEY');

        // Use config() instead of env() if you cache your configuration for production
        // $apiUrl = config('services.payway.api_url');
        $apiUrl = env('PAYWAY_API_URL');

        // Exit early if the API URL is not defined
        if (is_null($apiUrl)) {
            Log::error('PayWay API URL is not defined in .env');
            return redirect()->back()->with('error', 'Payment service is unavailable.');
        }

        $amount = 1.00; // Example amount in USD, must be a float
        $tranId = 'WEB_TRAN_' . Str::random(10); // Unique transaction ID
        $currency = 'USD';

        // Item details must be a Base64-encoded JSON string
        $items = base64_encode(json_encode([
            ['name' => 'Web Hosting Service', 'quantity' => 1, 'price' => 1.00]
        ]));

        // The URL the customer returns to after payment
        $returnUrl = base64_encode(route('payway.return') . '?tran_id=' . $tranId);

        // 2. Generate the security hash (HMAC-SHA512)
        $dataToHash = $merchantId . $tranId . number_format($amount, 2) . $items . $currency . $returnUrl;
        $hash = base64_encode(hash_hmac('sha512', $dataToHash, $apiKey, true));

        // 3. Send a POST request to the PayWay API
        try {
            $response = Http::asForm()->post($apiUrl, [
                'req_time' => now()->format('YmdHis'),
                'merchant_id' => $merchantId,
                'tran_id' => $tranId,
                'amount' => number_format($amount, 2),
                'currency' => $currency,
                'items' => $items,
                'return_url' => $returnUrl,
                'hash' => $hash,
                'firstname' => 'John', // Optional fields
                'lastname' => 'Doe',
            ]);

            if ($response->successful() && $response->body()) {
                return redirect()->away($response->body());
            }

            return redirect()->back()->with('error', 'PayWay connection failed.');
        } catch (\Exception $e) {
            Log::error('PayWay API call failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment processing error.');
        }
    }

    // ... (handleReturn and handlePushback methods remain the same)
    public function handleReturn(Request $request)
    {
        $paymentStatus = $request->get('status', '99');
        $tranId = $request->get('tran_id', 'N/A');

        if ($paymentStatus === '00') {
            return view('payway.success', compact('tranId'));
        } else {
            return view('payway.failure', compact('tranId'));
        }
    }

    public function handlePushback(Request $request)
    {
        $tranId = $request->input('tran_id');
        $status = $request->input('status');

        Log::info('PayWay pushback received', ['tran_id' => $tranId, 'status' => $status]);

        if ($status === '00') {
            // Update your order status here
        }

        return response()->json(['status' => 'success']);
    }
}
