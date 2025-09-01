<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view_payments')->only(['index', 'show']);
        $this->middleware('permission:create_payments')->only(['create', 'store']);
        $this->middleware('permission:edit_payments')->only(['edit', 'update']);
        $this->middleware('permission:delete_payments')->only(['destroy']);
        $this->middleware('permission:refund_payments')->only(['refund']);
    }


    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = Payment::latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment (manual create).
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Store a newly created payment in storage (manual add).
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'payment_reference' => 'required|unique:payments',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        Payment::create([
            'booking_id'        => $request->booking_id,
            'payment_reference' => $request->payment_reference,
            'payment_method'    => $request->payment_method,
            'payment_time'      => now(),
            'amount_paid'       => $request->amount_paid,
            'transaction_id'    => $request->transaction_id,
            'gateway_response'  => $request->gateway_response,
            'status'            => $request->status ?? 'pending',
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,success,failed,refunded',
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    /**
     * Refund payment (custom action).
     */
    public function refund(Request $request, Payment $payment)
    {
        if ($payment->status !== 'success') {
            return back()->with('error', 'Only successful payments can be refunded.');
        }

        $merchantId = env('ABA_MERCHANT_ID');
        $apiKey     = env('ABA_API_KEY');
        $hashSecret = env('ABA_HASH_SECRET');
        $apiUrl     = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/refund";

        $refundAmount = $request->refund_amount ?? $payment->amount_paid;

        $payload = [
            "merchant_id"   => $merchantId,
            "tran_id"       => $payment->transaction_id,
            "amount"        => $refundAmount,
            "currency"      => "USD",
            "refund_ref"    => uniqid("REFUND_"),
            "refund_reason" => $request->refund_reason ?? "Customer request",
            "req_time"      => now()->format('YmdHis'),
        ];

        // Generate hash
        $dataString = implode("", $payload);
        $hash = hash_hmac('sha512', $dataString, $hashSecret);
        $payload['hash'] = $hash;

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($merchantId . ":" . $apiKey),
            'Content-Type'  => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->successful()) {
            $result = $response->json();

            $payment->update([
                'status'        => 'refunded',
                'refund_amount' => $refundAmount,
                'refund_reason' => $payload['refund_reason'],
                'gateway_response' => json_encode($result),
            ]);

            return back()->with('success', 'Refund processed successfully.');
        }

        return back()->with('error', 'Refund failed: ' . $response->body());
    }

    /**
     * Initialize ABA Payway payment
     */
    public function initiateAbaPayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:qr,card',
        ]);

        $merchantId = env('ABA_MERCHANT_ID');
        $apiKey = env('ABA_API_KEY');
        $hashSecret = env('ABA_HASH_SECRET');
        $apiUrl = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase";

        $transactionId = 'TRANS_' . time() . rand(100, 999);

        $payload = [
            "merchant_id" => $merchantId,
            "amount" => $request->amount,
            "currency" => "USD",
            "tran_id" => $transactionId,
            "continue_success_url" => route('payments.callback.success'),
            "return_url" => route('payments.callback'),
            "cancel_url" => route('payments.callback.cancel'),
            "payment_option" => $request->payment_method === 'qr' ? 'abaqr' : 'cards',
            "return_params" => json_encode([
                'booking_id' => $request->booking_id,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount
            ]),
            "req_time" => now()->format('YmdHis'),
        ];

        // Generate hash
        $dataString = implode("", $payload);
        $hash = hash_hmac('sha512', $dataString, $hashSecret);
        $payload['hash'] = $hash;

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($merchantId . ":" . $apiKey),
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->successful()) {
            $result = $response->json();

            // Create pending payment
            Payment::create([
                'booking_id' => $request->booking_id,
                'payment_reference' => $transactionId,
                'payment_method' => $request->payment_method === 'qr' ? 'ABA QR' : 'ABA Card',
                'payment_time' => now(),
                'amount_paid' => $request->amount,
                'transaction_id' => $transactionId,
                'gateway_response' => json_encode($result),
                'status' => 'pending',
            ]);

            if ($request->payment_method === 'qr' && isset($result['qr_string'])) {
                // Return QR code for scanning
                return view('payments.qr-code', [
                    'qrCode' => $result['qr_string'],
                    'amount' => $request->amount,
                    'transactionId' => $transactionId
                ]);
            } elseif (isset($result['checkout_url'])) {
                // Redirect to ABA card payment page
                return redirect($result['checkout_url']);
            }
        }

        return back()->with('error', 'Payment initialization failed: ' . $response->body());
    }

    /**
     * Process successful payment callback
     */
    public function handlePaymentCallback(Request $request)
    {
        $transactionId = $request->tran_id;
        $status = $request->status ?? '';

        if (!$transactionId) {
            return redirect()->route('bookings.index')->with('error', 'Invalid payment response');
        }

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return redirect()->route('bookings.index')->with('error', 'Payment not found');
        }

        if ($status === 'success') {
            $payment->update([
                'status' => 'success',
                'gateway_response' => json_encode($request->all()),
            ]);

            return redirect()->route('bookings.show', $payment->booking_id)
                ->with('success', 'Payment processed successfully!');
        } else {
            $payment->update([
                'status' => 'failed',
                'gateway_response' => json_encode($request->all()),
            ]);

            return redirect()->route('bookings.show', $payment->booking_id)
                ->with('error', 'Payment failed: ' . ($request->message ?? 'Unknown error'));
        }
    }

    /**
     * Handle successful payment completion
     */
    public function handlePaymentSuccess(Request $request)
    {
        return view('payments.success');
    }

    /**
     * Handle canceled payment
     */
    public function handlePaymentCancel(Request $request)
    {
        $transactionId = $request->tran_id;

        if ($transactionId) {
            $payment = Payment::where('transaction_id', $transactionId)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => json_encode($request->all()),
                ]);
            }
        }

        return redirect()->route('bookings.index')->with('error', 'Payment was canceled.');
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Request $request, $transactionId)
    {
        $merchantId = env('ABA_MERCHANT_ID');
        $apiKey = env('ABA_API_KEY');
        $hashSecret = env('ABA_HASH_SECRET');
        $apiUrl = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/check-transaction";

        $payload = [
            "merchant_id" => $merchantId,
            "tran_id" => $transactionId,
            "req_time" => now()->format('YmdHis'),
        ];

        // Generate hash
        $dataString = implode("", $payload);
        $hash = hash_hmac('sha512', $dataString, $hashSecret);
        $payload['hash'] = $hash;

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($merchantId . ":" . $apiKey),
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->successful()) {
            $result = $response->json();
            $payment = Payment::where('transaction_id', $transactionId)->first();

            if ($payment && isset($result['status']) && $result['status'] === 'success') {
                $payment->update([
                    'status' => 'success',
                    'gateway_response' => json_encode($result),
                ]);

                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => $result['status'] ?? 'pending']);
        }

        return response()->json(['status' => 'error', 'message' => $response->body()]);
    }

    /**
     * Show payment testing page
     */
    public function showTestPage()
    {
        return view('payments.test.index');
    }

    /**
     * Show QR payment testing page
     */
    public function showQrTestPage()
    {
        return view('payments.test.qr');
    }

    /**
     * Show card payment testing page
     */
    public function showCardTestPage()
    {
        return view('payments.test.card');
    }

    /**
     * Create a test transaction for payment gateway testing
     */
    public function createTestTransaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:qr,card',
        ]);

        $transactionId = 'TEST_' . time() . rand(100, 999);

        // Create a test payment record - Use 0 instead of null for booking_id
        $payment = Payment::create([
            'booking_id' => 0, // Use a default value instead of null
            'payment_reference' => $transactionId,
            'payment_method' => $request->payment_method === 'qr' ? 'ABA QR Test' : 'ABA Card Test',
            'payment_time' => now(),
            'amount_paid' => $request->amount,
            'transaction_id' => $transactionId,
            'gateway_response' => json_encode(['test' => true, 'method' => $request->payment_method]),
            'status' => 'pending',
        ]);

        if ($request->payment_method === 'qr') {
            return redirect()->route('payment.test.qr.create', ['transaction_id' => $transactionId]);
        } else {
            return redirect()->route('payment.test.card.create', ['transaction_id' => $transactionId]);
        }
    }

    /**
     * Test QR payment with ABA PayWay
     */
    public function testQrPayment(Request $request)
    {
        $transactionId = $request->transaction_id ?? 'TEST_' . time() . rand(100, 999);
        $amount = $request->amount ?? 1;

        $merchantId = env('ABA_MERCHANT_ID');
        $apiKey = env('ABA_API_KEY');
        $hashSecret = env('ABA_HASH_SECRET');
        $apiUrl = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase";

        $payload = [
            "merchant_id" => $merchantId,
            "amount" => $amount,
            "currency" => "USD",
            "tran_id" => $transactionId,
            "continue_success_url" => route('payments.callback.success'),
            "return_url" => route('payments.callback'),
            "cancel_url" => route('payments.callback.cancel'),
            "payment_option" => "abaqr",
            "return_params" => json_encode([
                'test' => true,
                'payment_method' => 'qr',
                'amount' => $amount
            ]),
            "req_time" => now()->format('YmdHis'),
        ];

        // Generate hash
        $dataString = implode("", $payload);
        $hash = hash_hmac('sha512', $dataString, $hashSecret);
        $payload['hash'] = $hash;

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($merchantId . ":" . $apiKey),
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->successful()) {
            $result = $response->json();

            // Create a test payment if not already created
            $payment = Payment::where('transaction_id', $transactionId)->first();
            if (!$payment) {
                $payment = Payment::create([
                    'booking_id' => 0, // Use 0 instead of null
                    'payment_reference' => $transactionId,
                    'payment_method' => 'ABA QR Test',
                    'payment_time' => now(),
                    'amount_paid' => $amount,
                    'transaction_id' => $transactionId,
                    'status' => 'pending',
                ]);
            }

            if (isset($result['qr_string'])) {
                // Return QR code for scanning in the test page
                return view('payments.test.qr-display', [
                    'qrCode' => $result['qr_string'],
                    'amount' => $amount,
                    'transactionId' => $transactionId,
                    'response' => $result
                ]);
            }
        }

        return back()->with('error', 'QR code generation failed: ' . $response->body());
    }

    /**
     * Test card payment with ABA PayWay
     */
    public function testCardPayment(Request $request)
    {
        $transactionId = $request->transaction_id ?? 'TEST_' . time() . rand(100, 999);
        $amount = $request->amount ?? 1;

        $merchantId = env('ABA_MERCHANT_ID');
        $apiKey = env('ABA_API_KEY');
        $hashSecret = env('ABA_HASH_SECRET');
        $apiUrl = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase";

        $payload = [
            "merchant_id" => $merchantId,
            "amount" => $amount,
            "currency" => "USD",
            "tran_id" => $transactionId,
            "continue_success_url" => route('payments.callback.success'),
            "return_url" => route('payments.callback'),
            "cancel_url" => route('payments.callback.cancel'),
            "payment_option" => "cards",
            "return_params" => json_encode([
                'test' => true,
                'payment_method' => 'card',
                'amount' => $amount
            ]),
            "req_time" => now()->format('YmdHis'),
        ];

        // Generate hash
        $dataString = implode("", $payload);
        $hash = hash_hmac('sha512', $dataString, $hashSecret);
        $payload['hash'] = $hash;

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($merchantId . ":" . $apiKey),
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->successful()) {
            $result = $response->json();

            // Create a test payment if not already created
            $payment = Payment::where('transaction_id', $transactionId)->first();
            if (!$payment) {
                $payment = Payment::create([
                    'booking_id' => 0, // Use 0 instead of null
                    'payment_reference' => $transactionId,
                    'payment_method' => 'ABA Card Test',
                    'payment_time' => now(),
                    'amount_paid' => $amount,
                    'transaction_id' => $transactionId,
                    'status' => 'pending',
                ]);
            }

            if (isset($result['checkout_url'])) {
                // Store transaction info for reference
                session(['test_transaction' => [
                    'id' => $transactionId,
                    'amount' => $amount,
                    'time' => now()->format('Y-m-d H:i:s')
                ]]);

                // Redirect to ABA card payment page
                return redirect($result['checkout_url']);
            }
        }

        return back()->with('error', 'Card payment initialization failed: ' . $response->body());
    }

    /**
     * Check transaction status for testing
     */
    public function checkTransactionStatus(Request $request, $transactionId)
    {
        $merchantId = env('ABA_MERCHANT_ID');
        $apiKey = env('ABA_API_KEY');
        $hashSecret = env('ABA_HASH_SECRET');
        $apiUrl = "https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/check-transaction";

        $payload = [
            "merchant_id" => $merchantId,
            "tran_id" => $transactionId,
            "req_time" => now()->format('YmdHis'),
        ];

        // Generate hash
        $dataString = implode("", $payload);
        $hash = hash_hmac('sha512', $dataString, $hashSecret);
        $payload['hash'] = $hash;

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($merchantId . ":" . $apiKey),
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        // Return the complete response for testing purposes
        if ($request->wantsJson()) {
            return response()->json([
                'aba_response' => $response->json(),
                'status' => $response->successful() ? ($response->json()['status'] ?? 'unknown') : 'error',
                'code' => $response->status(),
                'timestamp' => now()->toIso8601String()
            ]);
        }

        // For web requests, return a view with the transaction details
        return view('payments.test.transaction-status', [
            'transactionId' => $transactionId,
            'response' => $response->json(),
            'responseCode' => $response->status(),
            'responseBody' => $response->body(),
        ]);
    }

    /**
     * Sandbox checkout for testing
     */
    public function sandboxCheckout($transactionId)
    {
        // For testing purposes, this would redirect to a simulated checkout page
        return view('payments.test.sandbox-checkout', [
            'transactionId' => $transactionId,
            'testCards' => [
                ['number' => '4242 4242 4242 4242', 'type' => 'Visa', 'result' => 'Success'],
                ['number' => '5555 5555 5555 4444', 'type' => 'Mastercard', 'result' => 'Success'],
                ['number' => '4111 1111 1111 1111', 'type' => 'Visa', 'result' => 'Decline'],
                ['number' => '4000 0000 0000 0002', 'type' => 'Visa', 'result' => 'Decline (Insufficient Funds)'],
            ]
        ]);
    }
}
