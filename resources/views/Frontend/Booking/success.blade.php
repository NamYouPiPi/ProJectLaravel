@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 40px auto; text-align:center;">
        <div style="font-size:48px; color:#4caf50; margin-bottom:16px;">&#10003;</div>
        <h2>Payment Complete</h2>
        <p>Thank you for your payment. Your booking is confirmed.</p>
        <a href="{{ url('/') }}" class="btn btn-primary" style="margin-top:24px;">Back to Home</a>
    </div>
@endsection