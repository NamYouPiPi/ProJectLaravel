<!-- filepath: c:\xampp\htdocs\Khmer_cenima\resources\views\Customers\create.blade.php -->
<form
    action="@isset($employee) {{ route('employees.update', $employee->id) }} @else {{ route('employees.store') }} @endisset"
    method="POST">
    @csrf
    @isset($employee)
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
                <label class="form-label float-start" for="name">Employee Name <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    value="{{ old('name', $employee->name ?? '') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label float-start" for="email">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    value="{{ old('email', $employee->email ?? '') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label float-start" for="age">Position </label>
                <input type="text" class="form-control @error('position') is-invalid @enderror" name="position"
                    id="position" value="{{ old('position', $employee->position ?? '') }}" required>
                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label float-start" for="phone">Phone </label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone"
                    value="{{ old('phone', $employee->phone ?? '') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label float-start" for="age">Hire_date </label>
                <input type="date" class="form-control @error('hire_date') is-invalid @enderror" name="hire_date"
                    id="hire_date" value="{{ old('hire_date', $employee->hire_date ?? '') }}" required>
                @error('hire_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label float-start" for="age">termination_date </label>
                <input type="date" class="form-control @error('termination_date') is-invalid @enderror"
                    name="termination_date" id="termination_date"
                    value="{{ old('termination_date', $employee->termination_date ?? '') }}" required>
                @error('termination_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label float-start" for="dob">DOB </label>
                <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob"
                    value="{{ old('dob', $employee->dob ?? '') }}" required>
                @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label float-start" for="age">salary </label>
                <input type="number" class="form-control @error('salary') is-invalid @enderror" name="salary"
                    id="salary" value="{{ old('salary', $employee->salary ?? '') }}" required>
                @error('salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

        </div>
        <div class="row g-3 ">
            <div class="col-md-6">
                <label for="gender" class="form-label float-start">Gender</label>
                <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option value="other" {{ (old('gender', $employee->gender ?? '') == 'other') ? 'selected' : '' }}>
                        Other</option>
                    <option value="M" {{ (old('gender', $employee->gender ?? '') == 'F') ? 'selected' : '' }}>
                        Male</option>
                    <option value="F" {{ (old('gender', $employee->gender ?? '') == 'M') ? 'selected' : '' }}>Female
                    </option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label float-start">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                    <option value="">Select Status</option>
                    <option value="active" {{ (old('status', $employee->status ?? '') == 'active') ? 'selected' : '' }}>
                        Active</option>
                    <option value="inactive" {{ (old('status', $employee->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label float-start" for="address">Address </label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                    id="address" value="{{ old('address', $employee->address ?? '') }}" required>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>


        </div>

    </div>

    <div class="card-footer mt-2">
        <button class="btn btn-info float-start" type="submit">
            {{ isset($employee) ? 'Update' : 'Save' }}
        </button>
        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
