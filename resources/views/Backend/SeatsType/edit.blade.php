<form action="{{ route('seatTypes.update', $seat_type->id) }}" method="POST">
    @csrf
    @method('PUT')
    @include('Backend.SeatsType.form')
</form>