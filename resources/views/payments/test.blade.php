@extends('Backend.layouts.app')
@section('content')
@section('title', 'Test Payment Gateway')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">ABA PayWay Gateway Test</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p><strong>Testing Environment:</strong> This page allows you to test the ABA PayWay integration.</p>
                        <p>Merchant ID: <code>{{ env('ABA_MERCHANT_ID') }}</code></p>
                        <p>API URL: <code>{{ env('ABA_API_URL') }}</code></p>
                    </div>
                    
                    <h5 class="mt-4">Test Transaction</h5>
                    <form action="{{ route('payment.test.create') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount (USD)</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="10.00" required>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="Test Payment" required>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Create Test Transaction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Test with Existing Bookings</h5>
                </div>
                <div class="card-body">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Booking Reference</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->booking_reference }}</td>
                                            <td>{{ $booking->customer->name }}</td>
                                            <td>${{ number_format($booking->final_amount, 2) }}</td>
                                            <td>
                                                @if($booking->payment_status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($booking->payment_status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($booking->payment_status == 'failed')
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('payment.initiate', $booking->id) }}" class="btn btn-sm btn-primary">
                                                    Pay Now
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No unpaid bookings found for testing.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-12 mt-4">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Transaction Status Check</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="transaction_id" class="form-label">Transaction ID</label>
                            <input type="text" class="form-control" id="transaction_id" placeholder="Enter transaction ID">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" onclick="checkTransactionStatus()" class="btn btn-secondary">Check Status</button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div id="status-result" class="p-3 border rounded bg-light d-none">
                            <pre id="status-json" class="mb-0"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function checkTransactionStatus() {
        const transactionId = document.getElementById('transaction_id').value;
        if (!transactionId) {
            alert('Please enter a transaction ID');
            return;
        }
        
        fetch(`{{ url('/payment-test/check-transaction-status') }}/${transactionId}`)
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('status-result');
                const jsonPre = document.getElementById('status-json');
                
                resultDiv.classList.remove('d-none');
                jsonPre.textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error checking transaction status');
            });
    }
</script>
@endsection
