<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AbAPayWayService
{
    protected $merchantId;
    protected $apiKey;
    protected $hashSecret;
    protected $endpoint;

    public function __construct()
    {
        $this->merchantId = config('aba.merchant_id');
        $this->apiKey = config('aba.api_key');
        $this->hashSecret = config('aba.hash_secret');
        $this->endpoint = config('aba.api_url');
    }

    public function createPayment($orderId, $amount, $returnUrl)
    {
        $data = [
            'merchant_id' => $this->merchantId,
            'tran_id'     => $orderId,
            'amount'      => $amount,
            'return_url'  => $returnUrl,
            // Add other required fields as per ABA documentation
        ];

        // Generate hash/signature as per ABA documentation
        $data['hash'] = hash_hmac('sha256', implode('', $data), $this->hashSecret);

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
        ])->post($this->endpoint, $data);

        return $response->json();
    }
}
