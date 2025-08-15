<form action="{{ route('hall_locations.store') }}" method="post">
@csrf

    @include('Backend.Hall_Location.form')
</form>
