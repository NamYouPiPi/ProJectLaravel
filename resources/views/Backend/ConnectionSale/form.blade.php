<div class="card-body">
    <!-- Hidden ID field for updates -->
    <input type="hidden" name="id" value="{{ $connection_sale->id ?? '' }}">

    <div class="row g-3">
        <div class="col-md-6">
            <label for="quantity_0" class="form-label float-start">Quantity <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control"
                id="quantity_0"
                name="quantity[]"
                min="1"
                step="1"
                value="{{ old('quantity.0', $connection_sale->quantity ?? '') }}"
                required
            />
        </div>

        <div class="col-md-6">
            <label for="price_0" class="form-label float-start">Price <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control"
                id="price_0"
                name="price[]"
                min="0"
                step="0.01"
                value="{{ old('price.0', $connection_sale->price ?? '') }}"
                required
            />
        </div>
    </div>

    <div class="row g-3 mt-0">
        <div class="col-md-6">
            <label for="inventory_0" class="form-label float-start">Item Name <span class="text-danger">*</span></label>
            <select class="form-select" name="inventory_id[]" id="inventory_0" required>
                <option value="">Select Item</option>
                @foreach($inventories as $inventory)
                    <option
                        value="{{ $inventory->id }}"
                        {{ (string)old('inventory_id.0', $selectedInventoryId ?? ($sale->inventory_id ?? '')) === (string)$inventory->id ? 'selected' : '' }}
                    >
                        {{ $inventory->item_name }}
                    </option>
                @endforeach
            </select>

        </div>

        <div class="col-md-6">
            <label for="total_price_0" class="form-label float-start">Total <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control"
                id="total_price_0"
                name="total_price[]"
                min="0"
                step="0.01"
                value="{{ old('total_price.0', $connection_sale->total_price ?? '') }}"
                readonly
            />
        </div>
    </div>

    <div class="card-footer mt-3">
        <button class="btn btn-info float-start" type="submit">{{ isset($connection_sale) ? 'Update' : 'Save' }}</button>
        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const quantity = document.getElementById('quantity_0');
            const price = document.getElementById('price_0');
            const total = document.getElementById('total_price_0');

            function recalc() {
                const q = parseFloat(quantity.value) || 0;
                const p = parseFloat(price.value) || 0;
                total.value = (q * p).toFixed(2);
            }

            quantity.addEventListener('input', recalc);
            price.addEventListener('input', recalc);

            // Initial calculation
            recalc();
        });
    </script>
@endpush
