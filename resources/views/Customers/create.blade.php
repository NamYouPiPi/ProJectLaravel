<!-- filepath: c:\xampp\htdocs\Khmer_cenima\resources\views\Customers\create.blade.php -->
<form
    action="@isset($customer) {{ route('customer.update', $customer->id) }} @else {{ route('customer.store') }} @endisset"
    method="POST">
    @csrf
    @isset($customer)
        @method('PUT')
    @endisset

    <!-- Display any validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label float-start" for="name">Customer Name <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    value="{{ old('name', $customer->name ?? '') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label float-start" for="email">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    value="{{ old('email', $customer->email ?? '') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="row g-3 mt-2">
            @if(!isset($customer))
                <div class="col-md-6">
                    <label class="form-label float-start" for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label float-start" for="password_confirmation">Confirm Password <span
                            class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                        required>
                </div>
            @endif
        </div>
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label class="form-label float-start" for="phone">Phone number <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone"
                    value="{{ old('phone', $customer->phone ?? '') }}" required>
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label float-start">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                    <option value="">Select Status</option>
                    <option value="active" {{ (old('status', $customer->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ (old('status', $customer->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card-footer mt-2">
        <button class="btn btn-info float-start" type="submit">
            {{ isset($customer) ? 'Update' : 'Save' }}
        </button>
        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
