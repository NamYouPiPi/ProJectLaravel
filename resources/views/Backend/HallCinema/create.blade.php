<form action="{{ route('hallCinema.store') }}" method="post">
    @csrf

    @include('Backend.HallCinema.form')
</form>
