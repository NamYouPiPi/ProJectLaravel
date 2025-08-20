@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Roles and Permissions</div>

                <div class="card-body">
                    <h5>Hello, {{ $user->name }}</h5>
                    
                    <div class="mt-4">
                        <h6>Your Roles:</h6>
                        <ul>
                            @forelse ($user->roles as $role)
                                <li>{{ $role->name }}</li>
                            @empty
                                <li>No roles assigned</li>
                            @endforelse
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Your Permissions:</h6>
                        <ul>
                            @forelse ($user->getAllPermissions() as $permission)
                                <li>{{ $permission->name }}</li>
                            @empty
                                <li>No permissions available</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
