@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Permission Test</div>

                <div class="card-body">
                    <h4>User: {{ Auth::check() ? Auth::user()->name : 'Not logged in' }}</h4>
                    
                    @if(Auth::check())
                        <h5>Your Roles:</h5>
                        <ul>
                            @forelse(Auth::user()->getRoleNames() as $role)
                                <li>{{ $role }}</li>
                            @empty
                                <li>No roles assigned</li>
                            @endforelse
                        </ul>

                        <h5>Your Permissions:</h5>
                        <ul>
                            @forelse(Auth::user()->getAllPermissions() as $permission)
                                <li>{{ $permission->name }}</li>
                            @empty
                                <li>No permissions available</li>
                            @endforelse
                        </ul>
                    @endif

                    <h5 class="mt-4">Test Links:</h5>
                    <div class="list-group">
                        <a href="{{ route('permission.test.protected') }}" class="list-group-item list-group-item-action">
                            Protected Route (requires 'manage movies' permission)
                        </a>
                        <a href="{{ route('permission.test.admin') }}" class="list-group-item list-group-item-action">
                            Admin Only Route (requires 'admin' role)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
