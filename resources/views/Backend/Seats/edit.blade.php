<form action="{{route('seats.update' , $seas->id)}}" method="post">
    @csrf
    @method('PUT')
    @include('Backend.Seats.form')
</form>
