<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
<div class="container">
    <h2>Payments List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('payments.create') }}" class="btn btn-primary mb-3">Add Payment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking</th>
                <th>Reference</th>
                <th>Method</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->booking_id }}</td>
                    <td>{{ $payment->payment_reference }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>${{ number_format($payment->amount_paid, 2) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ $payment->payment_time }}</td>
                    <td>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                        @if($payment->status === 'success')
                            <form action="{{ route('payments.refund', $payment) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="refund_amount" value="{{ $payment->amount_paid }}">
                                <input type="hidden" name="refund_reason" value="Test refund">
                                <button type="submit" class="btn btn-sm btn-dark">Refund</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>