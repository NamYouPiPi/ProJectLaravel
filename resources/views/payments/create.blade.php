@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Payment</h2>

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Booking ID (optional)</label>
            <input type="number" name="booking_id" class="form-control">
        </div>

        <div class="mb-3">
            <label>Payment Reference</label>
            <input type="text" name="payment_reference" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Payment Method</label>
            <input type="text" name="payment_method" class="form-control" value="ABA" required>
        </div>

        <div class="mb-3">
            <label>Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Payment</button>
    </form>
</div>
@endsection
