@extends('layouts.app')

@section('content')
    <div class="container " style="max-width: 500px; margin: 40px auto;">
        <h2 style="margin-top: 50px">Payment - ABA PayWay</h2>
        <div style="margin: 24px 0;">
            <div>Movie: {{ $movie->title }}</div>
            <div>Showtime: {{ $showtime->start_time ?? '' }}</div>
            <div>Seats: {{ implode(', ', $seats) }}</div>
            <div>Total: ${{ number_format($total, 2) }}</div>
        </div>
        <div style="text-align:center; margin: 24px 0;">
            <form action="{{ route('aba.payway.redirect') }}" method="POST">
                @csrf
                <input type="hidden" name="amount" value="{{ $total }}">
                <input type="hidden" name="order_id" value="{{ uniqid('ORDER_') }}">
                <input type="hidden" name="description"
                    value="Movie: {{ $movie->title }}, Seats: {{ implode(', ', $seats) }}">
                <button type="submit" class="btn btn-success" style="width:100%; font-size:18px;">
                    Pay with ABA Mobile
                </button>
            </form>
            <div style="color:#888; font-size:14px; margin-top:10px;">
                You will be redirected to ABA Mobile to complete your payment.
            </div>
        </div>
    </div>
@endsection
