@extends('Backend.layouts.app')
@section('content')
    @section('title', 'Edit Booking')
    @section('booking', 'active')

<div class="card shadow mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Booking Details #{{ $booking->booking_reference }}</h3>
            <div>
                {{-- <a href="{{ route('generateInvoice', $booking->id) }}" class="btn btn-outline-primary" target="_blank">
                    <i class="bi bi-file-pdf"></i> Generate Invoice
                </a> --}}
                {{-- <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-pencil"></i> Edit Booking
                </a> --}}
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-left"></i> Back to Bookings
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Booking Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Reference Number</th>
                                <td>{{ $booking->booking_reference }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($booking->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($booking->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif ($booking->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif ($booking->status == 'completed')
                                        <span class="badge bg-info">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td>{{ $booking->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $booking->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Expires At</th>
                                <td>{{ ($booking->expires_at && !is_string($booking->expires_at)) ? $booking->expires_at->format('M d, Y H:i') : ($booking->expires_at ?: 'N/A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Financial Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Total Amount</th>
                                <td>${{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Booking Fee</th>
                                <td>${{ number_format($booking->booking_fee, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>${{ number_format($booking->discount_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Final Amount</th>
                                <td class="fw-bold">${{ number_format($booking->final_amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Name</th>
                                <td>{{ $booking->customer->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $booking->customer->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $booking->customer->phone }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Showtime Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Movie</th>
                                <td>{{ $booking->showtime->movie->title }}</td>
                            </tr>
                            <tr>
                                <th>Cinema Hall</th>
                                <td>{{ $booking->showtime->hall->cinema_name }}</td>
                            </tr>
                            <tr>
                                <th>Start Time</th>
                                <td>{{ $booking->showtime->start_time->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>End Time</th>
                                <td>{{ $booking->showtime->end_time->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Booked Seats</h5>
                {{-- Comment out the entire button or uncomment the entire button --}}
                {{-- <a href="{{ route('booking-seats.create', ['booking_id' => $booking->id]) }}" 
                    class="btn btn-sm btn-outline-light">
                    <i class="bi bi-plus-circle"></i> Add Seat
                </a> --}}
            </div>
            <div class="card-body">
                @if($booking->seats && $booking->seats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Seat Number</th>
                                    <th>Row</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->seats as $seat)
                                    <tr>
                                        <td>{{ $seat->seat->seat_number }}</td>
                                        <td>{{ $seat->seat->row }}</td>
                                        <td>{{ $seat->seat->type }}</td>
                                        <td>${{ number_format($seat->price, 2) }}</td>
                                        <td>
                                            @if($seat->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('booking-seats.edit', $seat->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if($seat->status == 'active')
                                                    <form action="{{ route('booking-seats.destroy', $seat->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure you want to cancel this seat?')">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        No seats have been booked yet. Click "Add Seat" to book seats for this booking.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex gap-2">
                @if($booking->status == 'pending')
                    <form action="{{ route('confirmBooking', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirm Booking
                        </button>
                    </form>
                    
                    <!-- Add Payment Button -->
                    @if($booking->payment_status == 'pending')
                        <a href="{{ route('payment.initiate', $booking->id) }}" class="btn btn-primary">
                            <i class="bi bi-credit-card"></i> Pay with ABA PayWay
                        </a>
                    @endif
                @endif

                @if($booking->status != 'cancelled' && $booking->status != 'completed')
                    <form action="{{ route('cancelBooking', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                            <i class="bi bi-x-circle"></i> Cancel Booking
                        </button>
                    </form>
                @endif
                
                <!-- Display Payment Status -->
                @if($booking->payment_status == 'paid')
                    <div class="ms-auto">
                        <span class="badge bg-success p-2">
                            <i class="bi bi-check-circle-fill me-1"></i> Payment Completed
                        </span>
                    </div>
                @elseif($booking->payment_status == 'failed')
                    <div class="ms-auto">
                        <span class="badge bg-danger p-2">
                            <i class="bi bi-x-circle-fill me-1"></i> Payment Failed
                        </span>
                        <a href="{{ route('payment.initiate', $booking->id) }}" class="btn btn-sm btn-outline-primary ms-2">
                            <i class="bi bi-arrow-repeat"></i> Retry Payment
                        </a>
                    </div>
                @elseif($booking->payment_status == 'pending' && $booking->transaction_id)
                    <div class="ms-auto">
                        <span class="badge bg-warning p-2">
                            <i class="bi bi-hourglass-split me-1"></i> Payment Pending
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
