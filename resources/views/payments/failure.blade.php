@extends('Backend.layouts.app')
@section('content')
@section('title', 'Payment Failed')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="card-title mb-3">Payment Failed</h2>
                    <p class="card-text mb-4">
                        We couldn't process your payment for booking <strong>#{{ $booking->booking_reference }}</strong>.
                        Please try again or contact our support team for assistance.
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('payment.initiate', $booking->id) }}" class="btn btn-primary px-4">
                            <i class="bi bi-arrow-repeat me-2"></i> Try Again
                        </a>
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-eye me-2"></i> View Booking Details
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Booking Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Movie:</strong> {{ $booking->showtime->movie->title }}</p>
                            <p><strong>Showtime:</strong> {{ $booking->showtime->start_time->format('M d, Y H:i') }}</p>
                            <p><strong>Cinema:</strong> {{ $booking->showtime->hall->cinema_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Amount:</strong> ${{ number_format($booking->final_amount, 2) }}</p>
                            <p><strong>Transaction ID:</strong> {{ $booking->transaction_id ?? 'N/A' }}</p>
                            <p><strong>Payment Status:</strong> <span class="badge bg-danger">Failed</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
