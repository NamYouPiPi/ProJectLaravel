<form action="{{route('Showtime.store')}}" method="post">
    @csrf
    @include('Backend.Showtime.form', ['movies' => $movies, 'hallCinema' => $hallCinema])
</form>
