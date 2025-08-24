@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Scan QR Code (Test Mode)</h3>
                            <a href="{{ route('payment.test') }}" class="btn btn-sm btn-secondary">Back to Tests</a>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h4>Amount: ${{ number_format($amount, 2) }}</h4>
                        <p>Scan this QR code with your ABA mobile app (test mode)</p>

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
                                <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ urlencode($qrCode) }}&chs=250x250"
                                    alt="Payment QR Code" class="img-fluid">
                            @endif
                        </div>

                        <div id="payment-status" class="alert alert-info">
                            Waiting for payment...
                        </div>

                        <div class="mt-3">
                            <button id="check-status-btn" class="btn btn-primary">Check Status</button>
                            <a href="{{ route('payment.test.qr') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                        <div class="mt-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Technical Details</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
                                    <p><strong>QR String:</strong> <span class="text-muted">{{ $qrCode }}</span></p>
                                    <p><strong>Response:</strong></p>
                                    <pre class="bg-light p-2">{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
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
                fetch(`{{ url('payments/check-status') }}/${transactionId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then data => {
                        if (data.status === 'success') {
                            clearInterval(checkStatusInterval);
                            document.getElementById('payment-status').className = 'alert alert-success';
                            document.getElementById('payment-status').textContent = 'Payment successful!';
                            document.getElementById('check-status-btn').disabled = true;
                        } else if (data.status === 'error' || data.status === 'failed') {
                            clearInterval(checkStatusInterval);
                            document.getElementById('payment-status').className = 'alert alert-danger';
                            document.getElementById('payment-status').textContent = 'Payment failed. Please try again.';
                        } else {
                            document.getElementById('payment-status').textContent = 'Status: ' + data.status;
                        }
                    })
                .catch (error => {
                    console.error('Error checking payment status:', error);
                });
            }

            // Check payment status when button is clicked
            document.getElementById('check-status-btn').addEventListener('click', checkPaymentStatus);

            // Start checking payment status every 5 seconds
            document.addEventListener('DOMContentLoaded', function () {
                checkStatusInterval = setInterval(checkPaymentStatus, 5000);
            });
        </script>
    @endpush
@endsection