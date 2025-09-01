@extends('Backend.layouts.app')
@section('content')
    @section('title', 'Booking Seats')
    @section('booking', 'active')
    @include('Backend.components.Toast')

    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Manage Booking Seats</h3>
                <x-create_modal dataTable="booking_seats" title="Add New Booking Seat">
                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i class="bi bi-plus-lg"></i> Add Booking Seat
                    </button>
                </x-create_modal>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('booking-seats.index') }}" method="GET" class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <label class="input-group-text" for="booking_id">Filter by Booking:</label>
                            <select class="form-select" id="booking_id" name="booking_id">
                                <option value="">All Bookings</option>
                                @foreach(\App\Models\Booking::orderBy('created_at', 'desc')->get() as $booking)
                                    <option value="{{ $booking->id }}" {{ request('booking_id') == $booking->id ? 'selected' : '' }}>
                                        {{ $booking->booking_reference }} - {{ $booking->customer->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Booking Reference</th>
                            <th>Seat</th>
                            <th>Movie</th>
                            <th>Showtime</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingSeats as $seat)
                            <tr class="text-center">
                                <td>
                                    <a href="{{ route('bookings.show', $seat->booking_id) }}">
                                        {{ $seat->booking->booking_reference }}
                                    </a>
                                </td>
                                <td>
                                    Row {{ $seat->seat->row }}, Seat {{ $seat->seat->seat_number }}
                                    <span class="badge bg-info">{{ $seat->seat->type }}</span>
                                </td>
                                <td>{{ $seat->booking->showtime->movie->title ?? 'N/A' }}</td>
                                <td>
                                    {{ $seat->booking->showtime ? $seat->booking->showtime->start_time->format('M d, H:i') : 'N/A' }}
                                </td>
                                <td>${{ number_format($seat->price, 2) }}</td>
                                <td>
                                    @if($seat->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                {{-- <td>{{ $seat->created_at->format('Y-m-d H:i') }}</td> --}}
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('booking-seats.edit', $seat->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($seat->status != 'cancelled')
                                            <form action="{{ route('booking-seats.destroy', $seat->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this seat?')">
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

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $bookingSeats->firstItem() ?? 0 }} to {{ $bookingSeats->lastItem() ?? 0 }} of {{ $bookingSeats->total() }} results
                </div>
                {{ $bookingSeats->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
