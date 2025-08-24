@extends('Backend.layouts.app')
@section('content')
    @section('title', 'Edit Booking Seat')
    @section('booking', 'active')
    @include('Backend.components.Toast')

    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Edit Booking Seat</h3>
                <div>
                    <a href="{{ route('bookings.show', $bookingSeat->booking_id) }}" class="btn btn-outline-info">
                        <i class="bi bi-eye"></i> View Booking
                    </a>
                    <a href="{{ route('booking-seats.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-arrow-left"></i> Back to Booking Seats
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('booking-seats.update', $bookingSeat->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="booking_id" class="form-label">Booking</label>
                        <select name="booking_id" id="booking_id" class="form-select @error('booking_id') is-invalid @enderror" required>
                            <option value="">Select Booking</option>
                            @foreach ($bookings as $booking)
                                <option value="{{ $booking->id }}" {{ old('booking_id', $bookingSeat->booking_id) == $booking->id ? 'selected' : '' }}>
                                    {{ $booking->booking_reference }} - {{ $booking->customer->name }} ({{ $booking->showtime->movie->title }})
                                </option>
                            @endforeach
                        </select>
                        @error('booking_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="seat_id" class="form-label">Seat</label>
                        <select name="seat_id" id="seat_id" class="form-select @error('seat_id') is-invalid @enderror" required>
                            <option value="">Select Seat</option>
                            @foreach ($seats as $seat)
                                <option value="{{ $seat->id }}" {{ old('seat_id', $bookingSeat->seat_id) == $seat->id ? 'selected' : '' }}>
                                    Row {{ $seat->row }}, Seat {{ $seat->seat_number }} ({{ $seat->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('seat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                            value="{{ old('price', $bookingSeat->price) }}" step="0.01" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $bookingSeat->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="cancelled" {{ old('status', $bookingSeat->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-gradient">Update Booking Seat</button>
                    <a href="{{ route('booking-seats.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
