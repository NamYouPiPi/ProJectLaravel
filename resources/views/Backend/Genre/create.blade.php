<form method="post" action="{{route('genre.store')}}">
    @csrf
    @include("Backend.Genre.form")

</form>
