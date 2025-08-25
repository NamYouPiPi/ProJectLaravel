<form id="updateForm"
      action="{{ route('hall_locations.update', $hall_location->id) }}"
      method="POST" >
    @csrf
    @method('PUT')
    @include('Backend.Hall_Location.form')
</form>
