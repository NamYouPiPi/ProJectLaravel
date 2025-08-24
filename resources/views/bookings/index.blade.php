@extends('Backend.layouts.app')
@section('content')
@section('title', 'Bookings')
@section('booking', 'active')
    @include('Backend.components.Toast')

    {{-- Filter Section --}}
    <div class="filter-section mb-4">
        <x-create_modal dataTable="booking" title="Add New Booking">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                ➕ Add New Genre
            </button>
        </x-create_modal>

        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('bookings.index') }}" method="GET" class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Filter by Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table id="example" class="display table table-responsive table-hover" style="width:100%">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Ref #</th>
                        <th>Customer</th>
                        <th>Movie</th>
                        <th>Showtime</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="text-center">
                            <td>{{ $booking->booking_reference }}</td>
                            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->showtime->movie->title ?? 'N/A' }}</td>
                            <td>{{ $booking->showtime ? $booking->showtime->start_time->format('M d, H:i') : 'N/A' }}</td>
                            <td>${{ number_format($booking->final_amount, 2) }}</td>
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
                            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($booking->status != 'cancelled')
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to cancel this booking?')">
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
    </div>

    {{-- ========== paginate ----------------}}
    <div class="d-flex justify-content-between align-items-center m-4">
        {{-- Results info --}}
        <div class="text-muted">
            Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }}
            results
        </div>

        {{ $bookings->appends(request()->query())->links() }}
    </div>
@endsection
