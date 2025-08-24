@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Payment</h2>

    <form action="{{ route('payments.update', $payment) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" value="{{ $payment->amount_paid }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="success" {{ $payment->status == 'success' ? 'selected' : '' }}>Success</option>
                <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Payment</button>
    </form>
</div>
@endsection
