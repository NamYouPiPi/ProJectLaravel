<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{old('name',$suppliers->name ?? "")}}" id="validationCustom01" required />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="validationCustom02" value="{{old('email',$suppliers->email ?? "")}}" name="email" required />
        </div>
    </div>
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Phone <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="phone" id="validationCustom01" value="{{old('phone',$suppliers->phone ?? "")}}" maxlength="15" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label">Contact Person</label>
            <input type="text" class="form-control" id="validationCustom02" name="contact_person" required value="{{old('contact_person',$suppliers->contact_person ?? "")}}" />
        </div>
    </div>
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="supplier_type" class="form-label">supplier type <span class="text-danger">*</span></label>
            <select class="form-select" name="supplier_type" aria-label="Please select status">
                <option selected>Open this select menu</option>
                <option value="drinks">Drinks</option>
                <option value="foods">Foods</option>
                <option value="snacks">Snacks</option>
                <option value="others">Others</option>

            </select>
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option selected>Open this select menu</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>

            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label" >Address</label>
        <input type="text" class="form-control" id="address" name="address"  value="{{old('address',$suppliers->address ?? "")}}">
    </div>
</div>
<!--end::Body-->
<!--begin::Footer-->
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">Save</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>
