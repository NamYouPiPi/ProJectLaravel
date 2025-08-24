@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Card Payment Test</h2>
                        <a href="{{ route('payment.test') }}" class="btn btn-sm btn-secondary">Back to Tests</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p>Test credit card payments with the ABA PayWay sandbox.</p>
                        <p>You will be redirected to the ABA PayWay checkout page.</p>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            Test Credit Cards
                        </div>
                        <div class="card-body">
                            <p>You can use these test cards in the sandbox environment:</p>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Card Number</th>
                                        <th>Expiry</th>
                                        <th>CVV</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>4242 4242 4242 4242</td>
                                        <td>Any future date</td>
                                        <td>Any 3 digits</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                    </tr>
                                    <tr>
                                        <td>4000 0000 0000 0002</td>
                                        <td>Any future date</td>
                                        <td>Any 3 digits</td>
                                        <td><span class="badge bg-danger">Declined</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form action="{{ route('payment.test.card.create') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="amount">Amount (USD)</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01" value="1.00">
                        </div>
                        <button type="submit" class="btn btn-primary">Proceed to Card Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
