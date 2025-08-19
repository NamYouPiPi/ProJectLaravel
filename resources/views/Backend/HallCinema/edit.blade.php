<form id="updateForm"
      method="POST" action="{{route('hallCinema.update' , $hallCinema->id)}}">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $hallCinema->id }}">
    @include('Backend.HallCinema.form')
</form>
