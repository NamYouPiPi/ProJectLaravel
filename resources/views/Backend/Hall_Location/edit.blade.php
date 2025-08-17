<form id="updateForm"
      action="{{ route('hall_locations.update', $hall_location->id) }}"
      method="POST" >
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $hall_location->id }}">
    @include('Backend.Hall_Location.form')
</form>
