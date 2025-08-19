@php
    $hall_location = (isset($hall_location) && is_object($hall_location) && !($hall_location instanceof \Illuminate\Support\Collection)) ? $hall_location : new \stdClass();
@endphp
<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Name <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('name',$hall_location->name ?? '') }}"
                   class="form-control" name="name"  required />
        </div>

        <div class="col-md-6">
            <label for="city" class="form-label float-start">City <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('city',$hall_location->city ?? '') }}"
                   class="form-control" name="city"  required>
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="state" class="form-label float-start">State</label>
            <input type="text"
                   value="{{ old('state',$hall_location->state ?? '') }}"
            class="form-control" name="state"  >

        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">postal code </label>
            <input type="text"
                   value="{{ old('postal_code',$hall_location->postal_code ?? '') }}"
                   class="form-control" name="postal_code"  >
        </div>

    </div>
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="state" class="form-label float-start">country</label>
            <input type="text"
                   value="{{ old('country',$hall_location->country ?? '') }}"
                   class="form-control" name="country"  >
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Phone <span class="text-danger">*</span> </label>
            <input type="text"
                   value="{{ old('phone',$hall_location->phone ?? '') }}"
                   class="form-control"
                   name="phone"  required>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active"
                    {{ (old('status', $hall_location->status ?? '') ==='active') ? 'selected' : '' }}
                >Active</option>
                <option value="inactive"
                    {{ (old('status', $hall_location->status ?? '') === 'inactive') ? 'selected' : '' }}
                >Inactive</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="address" class="form-label float-start">Address <span class="text-danger">*</span></label>
            <textarea type="text"

                   class="form-control"
                   id="address"
                   name="address"
                   required >{{ old('address',$hall_location->address ?? '') }}</textarea>
        </div>
    </div>
</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-5">
    <button class="btn btn-info float-start" type="submit">{{ isset($hall_location) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>

{{---------------- end cart footer ----------------------}}
