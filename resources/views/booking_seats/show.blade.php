@extends('layouts.app')
@section('content')
@section('title', 'Booking Seat Details')
@section('booking', 'active')
    @include('Backend.components.Toast')

    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Booking Seat Details</h3>
                <div>
                    {{-- <a href="{{ route('booking-seats.edit', $bookingSeat) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a> --}}
                    {{-- <a href="{{ route('bookings.show', $bookingSeat->booking_id) }}" class="btn btn-outline-info ms-2"> --}}
                        <i class="bi bi-eye"></i> View Booking
                    </a>
                    {{-- <a href="{{ route('booking-seats.index') }}" class="btn btn-outline-secondary ms-2"> --}}
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Booking Seat Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Booking Reference</th>
                                    <td>
                                        {{-- <a href="{{ route('bookings.show', $bookingSeat->booking_id) }}"> --}}
                                            {{-- {{ $bookingSeat->booking->booking_reference }} --}}
                                        {{-- </a> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Seat</th>
                                    {{-- <td>Row {{ $bookingSeat->seat->row }}, Seat {{ $bookingSeat->seat->seat_number }}</td> --}}
                                </tr>
                                <tr>
                                    <th>Seat Type</th>
                                    {{-- <td>{{ $bookingSeat->seat->type }}</td> --}}
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    {{-- <td>${{ number_format($bookingSeat->price, 2) }}</td> --}}
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($bookingSeat->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    {{-- <td>{{ $bookingSeat->created_at->format('M d, Y H:i') }}</td> --}}
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    {{-- <td>{{ $bookingSeat->updated_at->format('M d, Y H:i') }}</td> --}}
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Showtime Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    {{-- <th width="40%">Movie</th>
                                    <td>{{ $bookingSeat->booking->showtime->movie->title }}</td>
                                </tr>
                                <tr>
                                    <th>Hall</th>
                                    <td>{{ $bookingSeat->booking->showtime->hallCinema->name }}</td> --}}
                                </tr>
                                <tr>
                                    {{-- <th>Start Time</th>
                                    <td>{{ $bookingSeat->booking->showtime->start_time->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>End Time</th>
                                    <td>{{ $bookingSeat->booking->showtime->end_time->format('M d, Y H:i') }}</td> --}}
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Name</th>
                                    {{-- <td>{{ $bookingSeat->booking->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $bookingSeat->booking->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $bookingSeat->booking->customer->phone }}</td> --}}
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex gap-2">
                    {{-- <a href="{{ route('booking-seats.edit', $bookingSeat) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Booking Seat
                    </a> --}}
                    @if($bookingSeat->status != 'cancelled')
                        {{-- <form action="{{ route('booking-seats.destroy', $bookingSeat->id) }}" method="POST"> --}}
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to cancel this seat?')">
                                <i class="bi bi-x-circle"></i> Cancel Seat
                            {{-- </button> --}}
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
