<form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label float-start">Name</label>
        <input type="text" class="form-control" value="{{old('name', isset($user) ? $user->name : '')}}" id="name"
            name="name" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label float-start">Email</label>
        <input type="email" class="form-control" value="{{old('email', isset($user) ? $user->email : '')}}" id="email"
            name="email" required>
    </div>

    @if(!isset($user))
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    @endif

    <div class="mb-3">
        <label for="role" class="form-label float-start">Role</label>
        <select class="form-select" id="role" name="role_id" required>
            <option value="">Select Role FOR USERS</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ (old('role_id') == $role->id || (isset($user) && $user->role_id == $role->id)) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary" type="submit">{{ isset($user) ? 'Update' : 'Save' }} User</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</form>
