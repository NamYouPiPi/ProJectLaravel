@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Scan QR Code to Pay</h3>
                </div>
                <div class="card-body text-center">
                    <h4>Amount: ${{ number_format($amount, 2) }}</h4>
                    <p>Scan this QR code with your ABA mobile app</p>
                    
                    <div class="my-4">
                        @if(class_exists('SimpleSoftwareIO\QrCode\Facades\QrCode'))
                            <div class="qr-container">
                                <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(250)->generate($qrCode)) }}" 
                                     alt="Payment QR Code" class="img-fluid">
                            </div>
                        @else
                            <div class="alert alert-warning">
                                QR Code package not installed. Please run: <br>
                                <code>composer require simplesoftwareio/simple-qrcode</code>
                            </div>
                        @endif
                    </div>
                    
                    <div id="payment-status" class="alert alert-info">
                        Waiting for payment...
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const transactionId = "{{ $transactionId }}";
    let checkStatusInterval;
    
    function checkPaymentStatus() {
        fetch(`{{ url('payments/check-status') }}/${transactionId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    clearInterval(checkStatusInterval);
                    document.getElementById('payment-status').className = 'alert alert-success';
                    document.getElementById('payment-status').textContent = 'Payment successful! Redirecting...';
                    setTimeout(() => {
                        window.location.href = "{{ route('payments.callback.success') }}";
                    }, 2000);
                } else if (data.status === 'error' || data.status === 'failed') {
                    clearInterval(checkStatusInterval);
                    document.getElementById('payment-status').className = 'alert alert-danger';
                    document.getElementById('payment-status').textContent = 'Payment failed. Please try again.';
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
            });
    }
    
    // Start checking payment status every 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        checkStatusInterval = setInterval(checkPaymentStatus, 3000);
    });
</script>
@endpush
@endsection
