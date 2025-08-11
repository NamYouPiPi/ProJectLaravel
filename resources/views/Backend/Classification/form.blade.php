<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Name <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('code',$classification->code ?? '') }}"
                   class="form-control"
                   name="code"
                   required />
        </div>
        {{--            <div class="col-md-6">--}}
        <div class="col-md-6">
            <label for="supplier_id" class="form-label float-start">Code <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('name',$classification->name ?? '') }}"
                   class="form-control"
                   name="name"  required>
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Age Limit</label>
            <input type="number"
                   value="{{ old('age_limit',$classification->age_limit ?? '') }}"
                   class="form-control"
                   name="age_limit"  required>

        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active"
                    {{ (old('status', $classification->status ?? '') == 'active') ? 'selected' : '' }}
                >Active</option>
                <option value="inactive"
                    {{ (old('status', $classification->status ?? '') == 'inactive') ? 'selected' : '' }}
                >Inactive</option>
            </select>
        </div>
        <div class="mb-1 ">
            <label class="form-label float-start" for="floatingInput">Country</label>
            <input type="text"
                   name="country"
                   value="{{ old('country',$classification->country ?? '') }}"
                   class="form-control" id="floatingInput" >
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label float-start">Description</label>
            <textarea class="form-control"
                      name="description"
                      id="exampleFormControlTextarea1"
                      rows="3">{{ old('description', $classification->description ?? '') }}</textarea>

        </div>
    </div>
</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">{{ isset($classification) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>

{{---------------- end cart footer ----------------------}}
