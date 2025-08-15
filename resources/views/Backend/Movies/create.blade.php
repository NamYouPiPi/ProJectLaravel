<form method="POST" action="{{route('movies.store')}}"
    enctype="multipart/form-data">
    @csrf

    @include('Backend.Movies.form')
</form>
