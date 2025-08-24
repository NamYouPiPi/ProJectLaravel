<form action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}" method="POST">
    @csrf
    @if(isset($role))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label float-start">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $role->name ?? '') }}"
               id="name"
               name="name"
               required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="display_name" class="form-label float-start">Display Name</label>
        <input type="text" class="form-control @error('display_name') is-invalid @enderror"
               value="{{ old('display_name', $role->display_name ?? '') }}"
               id="display_name"
               name="display_name"
               required>
        @error('display_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label float-start">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror"
                  id="description"
                  name="description"
                  rows="3">{{ old('description', $role->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input @error('is_protected') is-invalid @enderror"
                   id="is_protected"
                   name="is_protected"
                   {{ old('is_protected', $role->is_protected ?? false) ? 'checked' : '' }}>
            <label class="form-check-label float-start" for="is_protected">
                Is Protected
            </label>
            @error('is_protected')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary" type="submit">
            {{ isset($role) ? 'Update' : 'Save' }} Role
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
    </div>
</form>
