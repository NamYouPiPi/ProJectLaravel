@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    
                    <div class="row mt-4">
                        @can('manage movies')
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Movies</h5>
                                    <p class="card-text">Manage movie listings and details</p>
                                    <a href="{{ route('movies.index') }}" class="btn btn-primary">Manage Movies</a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        @can('manage screenings')
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Screenings</h5>
                                    <p class="card-text">Manage movie screenings and schedules</p>
                                    <a href="#" class="btn btn-primary">Manage Screenings</a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        @can('manage bookings')
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Bookings</h5>
                                    <p class="card-text">Manage ticket bookings and reservations</p>
                                    <a href="#" class="btn btn-primary">Manage Bookings</a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        @role('admin')
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Users</h5>
                                    <p class="card-text">Manage users and staff accounts</p>
                                    <a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Roles</h5>
                                    <p class="card-text">Manage roles and permissions</p>
                                    <a href="{{ route('roles.index') }}" class="btn btn-primary">Manage Roles</a>
                                </div>
                            </div>
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
