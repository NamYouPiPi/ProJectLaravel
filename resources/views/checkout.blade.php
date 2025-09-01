<h1>Checkout</h1>
<p>Total amount: $1.00</p>
<form method="POST" action="{{ route('payway.payment') }}">
    @csrf
    <button type="submit">Pay with ABA PayWay</button>
</form>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
