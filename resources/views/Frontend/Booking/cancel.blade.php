@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h1 class="text-danger">Payment Cancelled</h1>
        <p>Your booking was cancelled or payment was not completed.</p>
        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to Home</a>
    </div>
@endsection