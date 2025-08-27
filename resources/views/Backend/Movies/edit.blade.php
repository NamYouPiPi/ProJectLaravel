<form id="updateForm" method="POST" action="{{ route('movies.update', $movie) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    {{-- <input type="hidden" name="id" value="{{ $movie->id }}"> --}}
    @include('Backend.Movies.form')


</form>