{{-- filepath: c:\xampp\htdocs\Khmer_cenima\resources\views\Backend\Seats\form.blade.php --}}
<!--begin::Body-->
<div class="card-body">
    <div class="row g-3">
        <!-- Hall Name -->
        <div class="col-md-6">
            <label for="hall_id" class="form-label float-start">Hall Name <span class="text-danger">*</span></label>
            <select class="form-select" name="hall_id" id="hall_id" required>
                <option value="">Please select a hall</option>
                @foreach($hallCinema as $hall)
                    <option value="{{ $hall->id }}" @selected(old('hall_id', $seat->hall_id ?? '') == $hall->id)>
                        {{ $hall->cinema_name }} (Capacity: {{ $hall->total_seats }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Seats Type -->
        <div class="col-md-6">
            <label for="seat_type_id" class="form-label float-start">Seat Type <span class="text-danger">*</span></label>
            <select class="form-select" name="seat_type_id" id="seat_type_id" required>
                <option value="">Please select a seat type</option>
                @foreach($seatsType as $seatType)
                    <option value="{{ $seatType->id }}" @selected(old('seat_type_id', $seat->seat_type_id ?? '') == $seatType->id)>
                        {{ $seatType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Seat Number -->
        <div class="col-md-6">
            <label for="seat_number" class="form-label float-start">Seat Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="seat_number" id="seat_number"
                value="{{ old('seat_number', $seat->seat_number ?? '') }}" required />
        </div>

        <!-- Seat Row -->
        <div class="col-md-6">
            <label for="seat_row" class="form-label float-start">Seat Row <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="seat_row" id="seat_row"
                value="{{ old('seat_row', $seat->seat_row ?? '') }}" required />
        </div>

        <!-- Status -->
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" id="status" required>
                <option value="">Please select a status</option>
                @php
                    $statuses = ['available', 'reserved', 'booked', 'cancelled', 'blocked', 'broken'];
                @endphp
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $seat->status ?? '') == $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<!--end::Body-->

<!--begin::Footer-->
<div class="card-footer mt-2 border-top pt-3 ">
    <button class="btn btn-primary float-start" type="submit">{{ isset($seat) ? 'Update Seat' : 'Create Seat' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>
