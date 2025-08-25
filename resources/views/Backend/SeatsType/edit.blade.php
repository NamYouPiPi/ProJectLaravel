<form action="{{ route('seatTypes.update', $seatType) }}" method="POST">
    @csrf
    @method('PUT')
    @include('Backend.SeatsType.form')
</form>
