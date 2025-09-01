<!-- filepath: c:\xampp\htdocs\Khmer_cenima\resources\views\Customers\create.blade.php -->
<form action="{{ route('permission.store') }}" method="POST">
    @csrf
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
                <label class="form-label float-start" for="name"> Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label float-start" for="display_name">Display Name <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name"
                    id="display_name"  required>
                @error('display_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="row g-3 mt-2">
            <div class="mb-3">
                <label for="group" class="form-label">Group</label>
                <input type="text" class="form-control" id="group" name="group" >
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
    </div>

    <div>
        <button class="btn btn-info float-start" type="submit">
            Save Permission
        </button>
        <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
