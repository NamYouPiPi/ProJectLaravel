<!--begin::Body-->
<div class="card-body">
    <!-- Hidden ID field for updates -->
    <input type="hidden" name="id" value="{{ $hallcinema->id ?? '' }}">

    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Name <span class="text-danger">*</span></label>
            <input type="text"
                    value="{{ old('name',$hallcinema->cinema_name ?? '') }}"
                   class="form-control" name="cinema_name"  required />
        </div>

        <div class="col-md-6">
            <label for="city" class="form-label float-start">Hall Type <span class="text-danger">*</span></label>
            <select class="form-select"  name="hall_type" aria-label="Please select hall type">
                <option value="">Please select hall type</option>
                <option value="standard" {{(old('hall_type',$hallcinema->hall_type ?? '') === 'standard') ? 'selected' : '' }}>Standard</option>
                <option value="vip"  {{(old('hall_type',$hallcinema->hall_type ?? '') === 'vip') ? 'selected' : '' }}>VIP</option>
                <option value="imax"  {{(old('hall_type',$hallcinema->hall_type ?? '') === 'imax') ? 'selected' : '' }}>IMAX</option>
                <option value="4dx"  {{ (old('hall_type', $hallcinema->hall_type ?? '') === '4dx') ? 'selected' : '' }}>4DX</option>
                <option value="3d" {{(old('hall_type',$hallcinema->hall_type ?? '') === '3d') ? 'selected' : '' }}>3D</option>
                <option value="dolby_atmos" {{(old('hall_type',$hallcinema->hall_type ?? '') === 'dolby_atmos') ? 'selected' : '' }}>Dolby Atmos</option>
                <option value="premium" {{(old('hall_type',$hallcinema->hall_type ?? '') === 'premium') ? 'selected' : '' }}>Premium</option>
                <option value="outdoor" {{(old('hall_type',$hallcinema->hall_type ?? '') === 'outdoor') ? 'selected' : '' }}>Outdoor</option>
                <option value="private" {{(old('hall_type',$hallcinema->hall_type ?? '') === 'private') ? 'selected' : '' }}>Private</option>
            </select>
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="state" class="form-label float-start">Total Seats <span class="text-danger">*</span></label>
            <input type="number"
                   value="{{ old('total_seats',$hallcinema->total_seats ?? '') }}"
                   class="form-control" name="total_seats" required >

        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active"
                     {{ (old('status', $hallcinema->status ?? '') ==='active') ? 'selected' : '' }}
                >Active</option>
                <option value="inactive"
                     {{ (old('status', $hallcinema->status ?? '') === 'inactive') ? 'selected' : '' }}
                >Inactive</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="city" class="form-label float-start">Location Hall Name<span class="text-danger">*</span></label>
            <select name="hall_location_id" class="form-select"  aria-label="Please select Hall location Name" required>
                <option value="">Please select location</option>
                    @foreach($hall_location as $location)
                        <option value="{{$location->id}}"
                            {{ (old('hall_location_id', $hallcinema->hall_location_id ?? '') == $location->id) ? 'selected' : '' }}>
                            {{$location->name}}
                        </option>
                    @endforeach
            </select>
        </div>
    </div>

</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-5">
    <button class="btn btn-info float-start" type="submit">
        {{ isset($hallcinema) ? 'Update' : 'Save' }}

    </button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>

{{---------------- end cart footer ----------------------}}
