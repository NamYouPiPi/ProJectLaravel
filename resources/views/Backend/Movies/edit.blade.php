<form id="updateForm" method="POST" action="{{ route('movies.update', $movies->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $movies->id }}">
    @include('Backend.Movies.form')


</form>
