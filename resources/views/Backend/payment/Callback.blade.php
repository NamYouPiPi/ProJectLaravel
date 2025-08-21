{{-- filepath: resources/views/payment/callback.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>ABA Payment Callback</h2>
        <div>
            <h4>Payment Response Data:</h4>
            <pre>{{ print_r($data, true) }}</pre>
        </div>
    </div>
@endsection
