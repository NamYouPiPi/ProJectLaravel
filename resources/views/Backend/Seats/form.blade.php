<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="hall_id" class="form-label">Hall Name <span class="text-danger">*</span></label>
            <select class="form-select" name="hall_id" id="hall_id">
                <option value="">Please select hall</option>
                @foreach($hallCinema as $hall)
                    <option value="{{ $hall->id }}" {{ (old('hall_id', isset($seat) && $seat->hall_id ? $seat->hall_id : '') == $hall->id ? 'selected' : '') }}>
                        {{ $hall->cinema_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="seat_types" class="form-label">Seats Type <span class="text-danger">*</span></label>
            <select class="form-select" name="seat_type_id">
                <option value="">Please select seat type</option>
                @foreach($seatsType as $seatType)
                    <option value="{{ $seatType->id }}" {{ old('seat_type_id', $seat->seat_type_id ?? '') == $seatType->id ? 'selected' : '' }}>
                        {{ $seatType->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 ">
            <label for="seat_number" class="form-label">Seat Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="seat_number" id="seat_number" value="{{ old('seat_number', $seat->seat_number ?? '') }}" required />
        </div>
        <div class="col-md-6 ">
            <label for="seat_row" class="form-label">Seat Row <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="seat_row" id="seat_row" value="{{ old('seat_row', $seat->seat_row ?? '') }}" required />
            </div>
    </div>
{{--    'available',
                'reserved',
                'booked',
                'cancelled',
                'blocked',
                'broken'--}}
    <div class="col-md-6">
        <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
        <select class="form-select" name="status" aria-label="Please select status">
            <option value="">Please select status</option>
            <option value="available"{{ (old('available', $seat->status ?? '') == 'available') ? 'selected' : '' }}>Available</option>
            <option value="reserved"{{ (old('reserved', $seat->status ?? '') == 'reserved') ? 'selected' : '' }}>Reserved</option>
            <option value="booked"{{ (old('booked', $seat->status ?? '') == 'booked') ? 'selected' : '' }}>Booked</option>
            <option value="cancelled"{{ (old('cancelled', $seat->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
            <option value="blocked"{{ (old('blocked', $seat->status ?? '') == 'blocked') ? 'selected' : '' }}>Blocked</option>
            <option value="broken"{{ (old('broken', $seat->status ?? '') == 'broken') ? 'selected' : '' }}>Broken</option>
        </select>
    </div>
</div>
<!--end::Body-->
<!--begin::Footer-->
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">{{ isset($seat) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>
