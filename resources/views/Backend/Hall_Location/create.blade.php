<form action="{{ route('hall_locations.store') }}" method="post" enctype="multipart/form-data">
@csrf

    @include('Backend.Hall_Location.form')
</form>
