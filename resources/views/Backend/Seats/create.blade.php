<form action="{{ route('seats.store')}}" method="post">
@csrf
    @include('Backend.Seats.form')
</form>
