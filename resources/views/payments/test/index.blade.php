@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>ABA PayWay Payment Testing</h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <p><strong>Note:</strong> This page is for testing payment functionality with ABA PayWay.</p>
                            <p>You can test both QR code payments and credit card payments.</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body text-center">
                                        <h4>QR Payment Test</h4>
                                        <p>Test ABA QR or Alipay QR payments</p>
                                        <a href="{{ route('payment.test.qr') }}" class="btn btn-primary">Test QR Payment</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4>Card Payment Test</h4>
                                        <p>Test credit card payments</p>
                                        <a href="{{ route('payment.test.card') }}" class="btn btn-primary">Test Card
                                            Payment</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4>Create Custom Test Transaction</h4>
                        <form action="{{ route('payment.test.create') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="amount">Amount (USD)</label>
                                <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01"
                                    value="1.00">
                            </div>
                            <div class="form-group mb-3">
                                <label>Payment Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="qr" value="qr"
                                        checked>
                                    <label class="form-check-label" for="qr">QR Payment</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="card"
                                        value="card">
                                    <label class="form-check-label" for="card">Card Payment</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Create Test Transaction</button>
                        </form>

                        <hr>
                        <h4 class="mt-4">Check Transaction Status</h4>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="text" id="transaction-id" class="form-control" placeholder="Transaction ID"
                                        aria-label="Transaction ID">
                                    <button class="btn btn-outline-secondary" type="button" id="check-status-btn">Check
                                        Status</button>
                                </div>
                            </div>
                        </div>
                        <div id="status-result" class="mt-3 d-none">
                            <div class="card">
                                <div class="card-header">Transaction Status</div>
                                <div class="card-body">
                                    <pre id="status-json" class="bg-light p-3 rounded"></pre>
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
            document.getElementById('check-status-btn').addEventListener('click', function () {
                const transactionId = document.getElementById('transaction-id').value.trim();
                if (!transactionId) {
                    alert('Please enter a transaction ID');
                    return;
                }

                fetch(`{{ url('payments/check-status') }}/${transactionId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('status-json').textContent = JSON.stringify(data, null, 2);
                        document.getElementById('status-result').classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error('Error checking status:', error);
                        alert('Error checking transaction status');
                    });
            });
        </script>
    @endpush
@endsection