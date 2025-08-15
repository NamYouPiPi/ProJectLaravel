<form id="updateForm"
      action="{{ route('genre.update', $genre->id) }}"
      method="POST">
    @csrf
    @method('PUT')
    @include('Backend.Genre.form')

</form>
