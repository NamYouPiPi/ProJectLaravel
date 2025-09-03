<form id="updateForm" action="{{ route('hall_locations.update', $hall_location) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('Backend.Hall_Location.form')
</form>
