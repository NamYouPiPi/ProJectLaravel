@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="text-success">Payment Successful!</h1>
    <p>Your booking was completed successfully.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Home</a>
</div>
@endsection
