@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px; margin: 40px auto;">
    <h2>Pay with ABA QR</h2>
    <div style="margin: 24px 0;">
        <div>Order: {{ $order_id }}</div>
        <div>Description: {{ $description }}</div>
        <div>Amount: ${{ number_format($amount, 2) }}</div>
    </div>
    <div style="text-align:center; margin: 24px 0;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeData) }}" alt="ABA QR Code">
        <div style="color:#888; font-size:14px; margin-top:10px;">
            Scan this QR code with your ABA Mobile app to pay.
        </div>
    </div>
    <form action="{{ $return_url }}" method="GET">
        <button type="submit" class="btn btn-success" style="width:100%; font-size:18px;">Payment Complete</button>
    </form>
</div>
@endsection
