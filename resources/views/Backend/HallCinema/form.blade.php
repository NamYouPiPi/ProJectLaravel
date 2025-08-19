<!--begin::Body-->
@php
    $hallCinema = (isset($hallCinema) && is_object($hallCinema) && !($hallCinema instanceof \Illuminate\Support\Collection)) ? $hallCinema : new \stdClass();
@endphp
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Hall Name <span
                    class="text-danger">*</span></label>
            <input type="text" value="{{ old('cinema_name', $hallCinema->cinema_name ?? '') }}" class="form-control"
                name="cinema_name" required />
        </div>

        <div class="col-md-6">
            <label for="city" class="form-label float-start">Hall Type <span class="text-danger">*</span></label>
            <select class="form-select" name="hall_type" aria-label="Please select hall type">
                <option value="">Please select hall type</option>
                @php
                    $hallTypes = [
                        'standard' => 'Standard',
                        'vip' => 'VIP',
                        'imax' => 'IMAX',
                        '4dx' => '4DX',
                        '3d' => '3D',
                        'dolby_atmos' => 'Dolby Atmos',
                        'premium' => 'Premium',
                        'outdoor' => 'Outdoor',
                        'private' => 'Private'
                    ];
                    $selectedType = old('hall_type', $hallCinema->hall_type ?? '');
                @endphp
                @foreach($hallTypes as $typeValue => $typeLabel)
                    <option value="{{ $typeValue }}" {{ $selectedType === $typeValue ? 'selected' : '' }}>{{ $typeLabel }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="state" class="form-label float-start">Total Seats <span class="text-danger">*</span></label>
            <input type="number" value="{{ old('total_seats', $hallCinema->total_seats ?? '') }}" class="form-control"
                name="total_seats" required>
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            @php
                $selectedStatus = old('status', $hallCinema->status ?? '');
            @endphp
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active" {{ $selectedStatus === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $selectedStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Debug: Show hall_location content --}}

        {{-- <pre>{{ print_r($hall_location, true) }}</pre> --}}
        <div class="col-md-6">
            <label for="city" class="form-label float-start">Location Hall Name<span
                    class="text-danger">*</span></label>
            <select name="hall_location_id" class="form-select" aria-label="Please select Hall location Name" required>
                <option value="">Please select location</option>
                @foreach($hall_location as $location)
                    <option value="{{ $location->id }}" {{ old('hall_location_id', optional($hallCinema)->hall_location_id) == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-5">
    <button class="btn btn-info float-start" type="submit">
        {{ isset($hallCinema) && !empty($hallCinema->id) ? 'Update' : 'Save' }}
    </button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>
{{---------------- end cart footer ----------------------}}
