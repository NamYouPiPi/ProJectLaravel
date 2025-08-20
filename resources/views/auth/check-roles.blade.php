@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Role & Permission Check</div>

                <div class="card-body">
                    <h5>User: {{ $user->name }} ({{ $user->email }})</h5>
                    
                    <h6 class="mt-4">Assigned Roles:</h6>
                    <ul>
                        @forelse($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @empty
                            <li>No roles assigned</li>
                        @endforelse
                    </ul>
                    
                    <h6 class="mt-4">Permissions:</h6>
                    <ul>
                        @forelse($user->getAllPermissions() as $permission)
                            <li>{{ $permission->name }}</li>
                        @empty
                            <li>No permissions available</li>
                        @endforelse
                    </ul>
                    
                    <h6 class="mt-4">Permission Checks:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>Can manage users: <strong>{{ $user->can('manage users') ? 'Yes' : 'No' }}</strong></li>
                                <li>Can manage roles: <strong>{{ $user->can('manage roles') ? 'Yes' : 'No' }}</strong></li>
                                <li>Can manage movies: <strong>{{ $user->can('manage movies') ? 'Yes' : 'No' }}</strong></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Can manage screenings: <strong>{{ $user->can('manage screenings') ? 'Yes' : 'No' }}</strong></li>
                                <li>Can manage bookings: <strong>{{ $user->can('manage bookings') ? 'Yes' : 'No' }}</strong></li>
                                <li>Can view reports: <strong>{{ $user->can('view reports') ? 'Yes' : 'No' }}</strong></li>
                            </ul>
                        </div>
                    </div>
                    
                    <h6 class="mt-4">Role Checks:</h6>
                    <ul>
                        <li>Is admin: <strong>{{ $user->hasRole('admin') ? 'Yes' : 'No' }}</strong></li>
                        <li>Is manager: <strong>{{ $user->hasRole('manager') ? 'Yes' : 'No' }}</strong></li>
                        <li>Is staff: <strong>{{ $user->hasRole('staff') ? 'Yes' : 'No' }}</strong></li>
                        <li>Is user: <strong>{{ $user->hasRole('user') ? 'Yes' : 'No' }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
