<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Name <span class="text-danger">*</span></label>
            <input type="text"  value="{{ old('item_name',$inventory->item_name ?? '') }}"  class="form-control" name="item_name" id="validationCustom01" required />
        </div>
        {{--            <div class="col-md-6">--}}
        <div class="col-md-6">
            <label for="supplier_id" class="form-label float-start">Supplier Name <span class="text-danger">*</span></label>
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
        {{--            </div>--}}
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Category <span class="text-danger">*</span></label>
            <select type="text" class="form-control" name="category" id="validationCustom01" required >
                <option >Please select category</option>
                <option value="snacks" {{ (old('status', $inventory->category ?? '') == 'snacks') ? 'selected' : '' }}>snack</option>
                <option value="foods" {{ (old('status', $inventory->category ?? '') == 'foods') ? 'selected' : '' }}>food</option>
                <option value="drinks" {{ (old('status', $inventory->category ?? '') == 'drinks') ? 'selected' : '' }}>drink</option>
                <option value="others"  {{ (old('status', $inventory->category ?? '') == 'others') ? 'selected' : '' }}>others</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label float-start">Quantity <span class="text-danger">*</span></label>
            <input type="number" value="{{ old('quantity',$inventory->quantity ?? '') }}"  class="form-control" id="validationCustom02" name="quantity" required />
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Unit <span class="text-danger">*</span></label>
            <input type="text" value="{{ old('unit',$inventory->unit ?? '') }}"  class="form-control" name="unit" id="validationCustom01" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label float-start">Stock <span class="text-danger">*</span></label>
{{--            <input type="number" class="form-control" id="validationCustom02" name="stock" required--}}
{{--                   value="{{old('stock', $inventory->stock ?? "")}}" />--}}
        <select class="form-select" name="stock" id="stock" required>
            <option>Select Stock</option>
            <option value="in_stock"  {{ (old('status', $inventory->stock ?? '') == 'in_stock') ? 'selected' : '' }}>In Stock</option>
            <option value="out_of_stock"  {{ (old('status', $inventory->stock ?? '') == 'out_of_stock') ? 'selected' : '' }}>Out of Stock</option>
        </select>
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Cost Price <span class="text-danger">*</span></label>
            <input type="number" value="{{ old('cost_price',$inventory->cost_price ?? '') }}" class="form-control" name="cost_price" id="validationCustom01" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label float-start">Sale Price <span class="text-danger">*</span></label>
            <input type="number" value="{{ old('sale_price',$inventory->sale_price ?? '') }}"  class="form-control" id="validationCustom02" name="sale_price" required />
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label float-start">Stock level <span
                    class="text-danger">*</span></label>
            <input type="number" value="{{ old('stock_level',$inventory->stock_level ?? '') }}" class="form-control" name="stock_level" id="validationCustom01" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label float-start">Reorders Level <span
                    class="text-danger">*</span></label>
            <input type="number" value="{{ old('reorder_level',$inventory->reorder_level ?? '') }}" class="form-control" id="validationCustom02" name="reorder_level" required />
        </div>
    </div>


    <div class="row g-3">
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active" {{ (old('status', $inventory->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (old('status', $inventory->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label float-start">Image</label>
            <input type="file" class="form-control" value="{{ old('image', $inventory->image ?? '') }}" id="image" name="image" accept="image/*">
            @if(isset($inventory) && $inventory->image)
                <img src="{{ asset('storage/' . $inventory->image) }}" alt="Product photo for inventory item in a well-lit" class="img-thumbnail mt-2" style="max-width: 150px;">
            @endif
        </div>
    </div>
</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">{{ isset($inventory) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>

{{---------------- end cart footer ----------------------}}
