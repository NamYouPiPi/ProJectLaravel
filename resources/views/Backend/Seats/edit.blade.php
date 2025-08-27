<form id="updateForm" action="{{ route('seats.update', $seat) }}" method="post">
    @csrf
    @include('Backend.Seats.form')
</form>
