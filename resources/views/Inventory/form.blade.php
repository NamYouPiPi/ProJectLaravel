<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="validationCustom01" required />
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <label for="supplier_id" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                {{-- <input type="text" class="form-control" name="supplier_id" id="validationCustom01" required />--}}
                <select class="form-select" name="supplier_id" id="supplier_id" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $inventory->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="row g-3">
            <!--begin::Col-->
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Category <span class="text-danger">*</span></label>
                <select type="text" class="form-control" name="category" id="validationCustom01" required>
                    <option value="snacks">snack</option>
                    <option value="foods">food</option>
                    <option value="drinks">drink</option>
                    <option value="others">others</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="validationCustom02" name="quantity" required />
            </div>
        </div>


        <div class="row g-3">
            <!--begin::Col-->
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Unit <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="unit" id="validationCustom01" />
            </div>
            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Stock <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="validationCustom02" name="stock" required
                    value="{{old('contact_person', $suppliers->contact_person ?? "")}}" />
            </div>
        </div>


        <div class="row g-3">
            <!--begin::Col-->
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Cost Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="cost_price" id="validationCustom01" />
            </div>
            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Sale Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="validationCustom02" name="sale_price" required />
            </div>
        </div>


        <div class="row g-3">
            <!--begin::Col-->
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Stock level <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" name="stock_level" id="validationCustom01" />
            </div>
            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Reorders Level <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" id="validationCustom02" name="reoder_level" required />
            </div>
        </div>


        <div class="row g-3">
            <div class="col-md-6">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" name="status" aria-label="Please select status">
                    <option selected>Open this select menu</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
        </div>
    </div>
    <!--end::Body-->
    <!--begin::Footer-->
    <div class="card-footer mt-2">
        <button class="btn btn-info float-start" type="submit">Save</button>
        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
    </div>
