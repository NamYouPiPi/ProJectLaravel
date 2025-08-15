<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $supplier->name ?? '') }}" id="validationCustom01" required />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="validationCustom02" value="{{ old('email', $supplier->email ?? '') }}" name="email" required />
        </div>
    </div>
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Phone <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="phone" id="validationCustom01" value="{{ old('phone', $supplier->phone ?? '') }}" maxlength="15" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label">Contact Person</label>
            <input type="text" class="form-control" id="validationCustom02" name="contact_person" required value="{{ old('contact_person', $supplier->contact_person ?? '') }}" />
        </div>
    </div>
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="supplier_type" class="form-label">supplier type <span class="text-danger">*</span></label>
            <select class="form-select" name="supplier_type" aria-label="Please select status">
                <option value="">Select Type</option>
                <option value="drinks" {{ (old('supplier_type', $supplier->supplier_type ?? '') == 'drinks') ? 'selected' : '' }}>Drinks</option>
                <option value="foods" {{ (old('supplier_type', $supplier->supplier_type ?? '') == 'foods') ? 'selected' : '' }}>Foods</option>
                <option value="snacks" {{ (old('supplier_type', $supplier->supplier_type ?? '') == 'snacks') ? 'selected' : '' }}>Snacks</option>
                <option value="movies" {{ (old('supplier_type', $supplier->supplier_type ?? '') == 'movies') ? 'selected' : '' }}>Movies</option>
                <option value="others" {{ (old('supplier_type', $supplier->supplier_type ?? '') == 'others') ? 'selected' : '' }}>Others</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Select Status</option>
                <option value="active" {{ (old('status', $supplier->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (old('status', $supplier->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $supplier->address ?? '') }}">
    </div>
</div>
<!--end::Body-->
<!--begin::Footer-->
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">{{ isset($supplier) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>
