@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>User Details: {{ $user->name }}</h4>
                        <div>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Name:</div>
                        <div class="col-md-9">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Email:</div>
                        <div class="col-md-9">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Roles:</div>
                        <div class="col-md-9">
                            @forelse($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @empty
                                <span class="text-muted">No roles assigned</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Permissions:</div>
                        <div class="col-md-9">
                            @forelse($user->getAllPermissions() as $permission)
                                <span class="badge bg-info">{{ $permission->name }}</span>
                            @empty
                                <span class="text-muted">No permissions</span>
                            @endforelse
                        </div>
                    </div>

                    <hr>

                    <h5>Manage User Roles</h5>
                    
                    <form action="{{ route('users.assign-role', $user->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label for="role" class="form-label">Add Role</label>
                                <select name="role" id="role" class="form-select">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Assign Role</button>
                            </div>
                        </div>
                    </form>

                    @if(count($user->roles) > 0)
                        <h6>Remove Roles:</h6>
                        <div class="row">
                            @foreach($user->roles as $role)
                                <div class="col-md-4 mb-2">
                                    <form action="{{ route('users.remove-role', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="role" value="{{ $role->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Remove {{ $role->name }}
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
