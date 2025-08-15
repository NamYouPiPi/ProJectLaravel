<form method="post" action="{{route('movies.update', $movies->id)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('Backend.Movies.form')

</form>
