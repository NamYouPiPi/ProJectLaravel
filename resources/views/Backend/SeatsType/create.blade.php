<form action="{{route('seatTypes.store')}}" method="post">
    @csrf
    @include('Backend.SeatsType.form')
</form>
