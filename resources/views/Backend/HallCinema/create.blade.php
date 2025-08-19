<form action="{{ route('hallCinema.store') }}" method="post">
    @csrf

    @include("Backend.HallCinema.form", ['hall_location' => $hall_location])
</form>
