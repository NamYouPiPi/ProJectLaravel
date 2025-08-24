@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Transaction Status</h2>
                        <a href="{{ route('payment.test') }}" class="btn btn-sm btn-secondary">Back to Tests</a>
                    </div>
                </div>
                <div class="card-body">
                    <h4>Transaction ID: {{ $transactionId }}</h4>
                    
                    <div class="alert alert-{{ isset($response['status']) && $response['status'] == 'success' ? 'success' : 'info' }}">
                        Status: <strong>{{ isset($response['status']) ? ucfirst($response['status']) : 'Unknown' }}</strong>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header">Response Details</div>
                        <div class="card-body">
                            <p><strong>Response Code:</strong> {{ $responseCode }}</p>
                            <div class="bg-light p-3 rounded">
                                <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('payment.check.status', $transactionId) }}" class="btn btn-primary">Refresh Status</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
