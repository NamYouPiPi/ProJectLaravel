<form action="{{route('seats.update' , $seats->id)}}" method="post">
    @csrf
    @method('PUT')
    @include('Backend.Seats.form')
</form>
