@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="success-icon my-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="card-title text-success">Success</h2>
                    <p class="card-text">Your payment was processed successfully.</p>
                    <p>Thank you for your purchase!</p>
                    <div class="mt-4">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary">Back to Bookings</a>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Return to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                            <p><strong>Transaction ID:</strong> {{ $booking->transaction_id }}</p>
                            <p><strong>Payment Status:</strong> <span class="badge bg-success">Paid</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
