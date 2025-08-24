@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Details</h2>

    <ul class="list-group">
        <li class="list-group-item"><b>ID:</b> {{ $payment->id }}</li>
        <li class="list-group-item"><b>Booking ID:</b> {{ $payment->booking_id }}</li>
        <li class="list-group-item"><b>Reference:</b> {{ $payment->payment_reference }}</li>
        <li class="list-group-item"><b>Method:</b> {{ $payment->payment_method }}</li>
        <li class="list-group-item"><b>Amount:</b> ${{ number_format($payment->amount_paid,2) }}</li>
        <li class="list-group-item"><b>Status:</b> {{ ucfirst($payment->status) }}</li>
        <li class="list-group-item"><b>Transaction ID:</b> {{ $payment->transaction_id }}</li>
        <li class="list-group-item"><b>Payment Time:</b> {{ $payment->payment_time }}</li>
        <li class="list-group-item"><b>Refund Amount:</b> {{ $payment->refund_amount }}</li>
        <li class="list-group-item"><b>Refund Reason:</b> {{ $payment->refund_reason }}</li>
        <li class="list-group-item"><b>Gateway Response:</b><br><pre>{{ $payment->gateway_response }}</pre></li>
    </ul>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection

;
