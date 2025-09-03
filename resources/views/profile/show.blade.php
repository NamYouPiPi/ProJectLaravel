@extends('Backend.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold">Profile</div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-4">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=100" alt="Profile Image" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <div class="text-muted">{{ $user->email }}</div>
                            @if($user->phone)
                                <div class="text-muted">📞 {{ $user->phone }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Bio:</strong>
                        <div class="border rounded p-2 bg-light">{{ $user->bio ?? 'No bio provided.' }}</div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    <a href="{{ route('profile.show') }}#change-password" class="btn btn-outline-secondary ms-2">Change Password</a>
                </div>
            </div>
            <div class="card" id="change-password">
                <div class="card-header bg-light fw-bold">Change Password</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.changePassword') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="5">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="5">
                        </div>
                        <button type="submit" class="btn btn-success">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
