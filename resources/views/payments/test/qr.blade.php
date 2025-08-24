@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>QR Payment Test</h2>
                        <a href="{{ route('payment.test') }}" class="btn btn-sm btn-secondary">Back to Tests</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p>Test ABA QR payments with the sandbox environment.</p>
                        <p>You can use the ABA mobile app in test mode to scan the generated QR code.</p>
                    </div>

                    <form action="{{ route('payment.test.qr.create') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="amount">Amount (USD)</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01" value="1.00">
                        </div>
                        <button type="submit" class="btn btn-primary">Generate QR Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
