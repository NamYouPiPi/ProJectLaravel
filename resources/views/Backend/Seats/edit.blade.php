<form action="{{ route('seats.update', $seat) }}" method="post">
    @csrf
    @method('PUT')
    @include('Backend.Seats.form')
</form>
