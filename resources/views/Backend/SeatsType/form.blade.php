<!--begin::Body-->
    <div class="card-body">
        <div class="row g-3">
            <!-- Seat Type Name -->
            <div class="col-md-6">
                <label for="name" class="form-label">Seat Type <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $seatType->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="col-md-6">
                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price', $seatType->price ?? '') }}" step="0.1" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3 mt-3">
            <!-- Status -->
            <div class="col-md-6">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="">Please select status</option>
                    <option value="active" {{ old('status', $seatType->status ?? '') === 'active' ? 'selected' : '' }}>
                        Active</option>
                    <option value="inactive" {{ old('status', $seatType->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!--begin::Footer-->
    <div class="card-footer mt-4 d-flex justify-content-between">
        <button type="submit" class="btn btn-info">
            {{ isset($seatType) ? 'Update' : 'Save' }}
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
