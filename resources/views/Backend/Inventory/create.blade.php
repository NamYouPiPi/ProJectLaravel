<form action="{{ route('inventory.store') }}" method="post" enctype="multipart/form-data">
    @csrf
     @include('Backend.Inventory.form')

</form>
