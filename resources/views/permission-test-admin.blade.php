@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Only Route</div>

                <div class="card-body">
                    <div class="alert alert-success">
                        <strong>Success!</strong> You have the 'admin' role to access this page.
                    </div>
                    
                    <a href="{{ route('permission.test') }}" class="btn btn-primary">Back to Test Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
