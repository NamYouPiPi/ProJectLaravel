<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Main Genre <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('main_genre',$genre->main_genre ?? '') }}"
                   class="form-control" name="main_genre"  required />
        </div>
        {{--            <div class="col-md-6">--}}
        <div class="col-md-6">
            <label for="supplier_id" class="form-label float-start">Sub Genre <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('sub_genre',$genre->sub_genre ?? '') }}"
                   class="form-control" name="sub_genre"  required>
        </div>
        {{--            </div>--}}
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Description</label>
            <input type="text"
                   value="{{ old('description',$genre->description ?? '') }}" "
                   class="form-control" name="description"  required>

        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active"
                    {{ (old('status', $genre->status ?? '') == 'active') ? 'selected' : '' }}
                >Active</option>
                <option value="inactive"
                    {{ (old('status', $genre->status ?? '') == 'inactive') ? 'selected' : '' }}
                >Inactive</option>
            </select>
        </div>

    </div>
</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">{{ isset($inventory) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>

{{---------------- end cart footer ----------------------}}
