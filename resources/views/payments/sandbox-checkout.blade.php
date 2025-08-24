@extends('Backend.layouts.app')
@section('content')
@section('title', 'Sandbox Checkout')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">ABA PayWay Sandbox Checkout</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="https://www.ababank.com/fileadmin/user_upload/ABA_Logo_2023.svg" alt="ABA Bank" style="height: 60px;">
                    </div>
                    
                    <div class="alert alert-info">
                        <p><strong>Sandbox Mode</strong> - This is a simulated checkout page for testing.</p>
                    </div>
                    
                    <div class="mb-4">
                        <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
                    </div>
                    
                    <form id="payment-form" class="mb-4">
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="card_number" value="4111 1111 1111 1111" readonly>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiry" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry" value="12/25" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" value="123" readonly>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success btn-lg" onclick="simulateSuccess()">
                                Simulate Successful Payment
                            </button>
                            <button type="button" class="btn btn-danger" onclick="simulateFailure()">
                                Simulate Failed Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function simulateSuccess() {
        // Simulate a successful payment
        const data = {
            tran_id: '{{ $transactionId }}',
            status: 0, // 0 means success
            hash: 'simulated_hash'
        };
        
        submitPaymentResult(data);
    }
    
    function simulateFailure() {
        // Simulate a failed payment
        const data = {
            tran_id: '{{ $transactionId }}',
            status: 1, // 1 means failure
            hash: 'simulated_hash'
        };
        
        submitPaymentResult(data);
    }
    
    function submitPaymentResult(data) {
        // Create a form and submit it to the callback URL
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ $callbackUrl }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add the data fields
        for (const key in data) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection
