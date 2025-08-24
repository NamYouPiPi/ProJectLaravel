<form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror"
                required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} ({{ $customer->email }})
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-6 mb-3">
            <label for="showtime_id" class="form-label">Showtime</label>
            <select name="showtime_id" id="showtime_id" class="form-select @error('showtime_id') is-invalid @enderror"
                required>
                <option value="">Select Showtime</option>
                @foreach ($showtimes as $showtime)
                    <option value="{{ $showtime->id }}" {{ old('showtime_id') == $showtime->id ? 'selected' : '' }}>
                        {{ $showtime->movie->title }} - {{ $showtime->start_time->format('M d, H:i') }}
(Hall: {{ $showtime->hall->cinema_name ?? 'N/A' }})
                        </option>
                @endforeach
            </select>
            @error('showtime_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount"
                class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', 0) }}"
                step="0.01" min="0" required>
            @error('total_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="booking_fee" class="form-label">Booking Fee</label>
            <input type="number" name="booking_fee" id="booking_fee"
                class="form-control @error('booking_fee') is-invalid @enderror" value="{{ old('booking_fee', 0) }}"
                step="0.01" min="0" required>
            @error('booking_fee')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="discount_amount" class="form-label">Discount Amount</label>
            <input type="number" name="discount_amount" id="discount_amount"
                class="form-control @error('discount_amount') is-invalid @enderror"
                value="{{ old('discount_amount', 0) }}" step="0.01" min="0">
            @error('discount_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-gradient">Create Booking</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
