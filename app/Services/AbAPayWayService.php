<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AbaPaywayService
{
    protected $merchantId;
    protected $apiKey;
    protected $apiUrl;
    protected $hashSecret;

    public function __construct()
    {
        $this->merchantId = env('ABA_MERCHANT_ID');
        $this->apiKey = env('ABA_API_KEY');
        $this->apiUrl = env('ABA_API_URL');
        $this->hashSecret = env('ABA_HASH_SECRET');
    }

    /**
     * Generate checkout URL for a booking
     */
    public function generateCheckoutUrl($booking)
    {
        $reqTime = date('YmdHis');
        $tranId = 'CINEMA' . $booking->id . time();
        
        // Format items for ABA PayWay - handle case where seats might be null
        $seatCount = $booking->seats && $booking->seats->count() > 0 ? $booking->seats->count() : 1;
        $itemPrice = $seatCount > 0 ? number_format($booking->final_amount / $seatCount, 2) : number_format($booking->final_amount, 2);
        
        $items = [
            [
                'name' => 'Movie Ticket: ' . $booking->showtime->movie->title,
                'quantity' => $seatCount,
                'price' => $itemPrice
            ]
        ];
        
        $encodedItems = base64_encode(json_encode($items));
        
        // Prepare request data
        $data = [
            'merchant_id' => $this->merchantId,
            'req_time' => $reqTime,
            'tran_id' => $tranId,
            'amount' => number_format($booking->final_amount, 2),
            'items' => $encodedItems,
            'currency' => 'USD',
            'return_url' => route('payment.callback'),
            'continue_success_url' => route('payment.success', $booking->id),
            'payment_option' => 'cards',
            'return_deeplink' => '',
        ];
        
        // Generate hash
        $data['hash'] = $this->generateHash($data);
        
        // Store transaction info in the database
        $booking->update([
            'transaction_id' => $tranId,
            'payment_status' => 'pending'
        ]);
        
        // Send request to ABA PayWay
        $response = $this->sendRequest($data);
        
        if (isset($response['checkout_url'])) {
            return $response['checkout_url'];
        }
        
        Log::error('ABA PayWay error: ' . json_encode($response));
        return null;
    }
    
    /**
     * Generate hash for the request
     */
    protected function generateHash($data)
    {
        $stringToHash = $this->merchantId . $data['tran_id'] . $data['amount'] . $data['items'] . $data['currency'] . $data['req_time'];
        return hash_hmac('sha512', $stringToHash, $this->apiKey);
    }
    
    /**
     * Send request to ABA PayWay API
     */
    protected function sendRequest($data, $url = null)
    {
        $url = $url ?: $this->apiUrl;
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Origin: ' . env('APP_URL')
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            Log::error('cURL Error: ' . $err);
            return ['error' => $err];
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Verify the callback from ABA PayWay
     */
    public function verifyCallback($data)
    {
        if (!isset($data['tran_id'], $data['status'], $data['hash'])) {
            return false;
        }
        
        $calculatedHash = hash_hmac('sha512', $data['tran_id'] . $data['status'], $this->apiKey);
        
        return $calculatedHash === $data['hash'];
    }
    
    /**
     * Check transaction status with ABA PayWay
     */
    public function checkTransactionStatus($transactionId)
    {
        $data = [
            'merchant_id' => $this->merchantId,
            'req_time' => date('YmdHis'),
            'tran_id' => $transactionId,
        ];
        
        // Generate hash
        $data['hash'] = hash_hmac('sha512', 
            $data['merchant_id'] . $data['tran_id'] . $data['req_time'], 
            $this->apiKey
        );
        
        // Send request to ABA PayWay check transaction endpoint
        return $this->sendRequest($data, $this->apiUrl . '/check-transaction');
    }
}
