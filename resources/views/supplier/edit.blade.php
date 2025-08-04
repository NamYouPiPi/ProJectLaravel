<form id="updateSupplierForm" method="POST" }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $supplier->id }}">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $supplier->name) }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email', $supplier->email) }}" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone"
                       value="{{ old('phone', $supplier->phone) }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="contact_person" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person"
                       value="{{ old('contact_person', $supplier->contact_person) }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="supplier_type" class="form-label">Supplier Type <span class="text-danger">*</span></label>
                <select class="form-control" id="supplier_type" name="supplier_type" required>
                    <option value="">Select Type</option>
                    <option value="manufacturer" {{ old('supplier_type', $supplier->supplier_type) == 'drinks' ? 'selected' : '' }}>Drinks</option>
                    <option value="distributor" {{ old('supplier_type', $supplier->supplier_type) == 'foods' ? 'selected' : '' }}>Foods</option>
                    <option value="wholesaler" {{ old('supplier_type', $supplier->supplier_type) == 'snacks' ? 'selected' : '' }}>Snacks</option>
                    <option value="retailer" {{ old('supplier_type', $supplier->supplier_type) == 'others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" {{ old('status', $supplier->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $supplier->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Supplier</button>
    </div>
</form>
