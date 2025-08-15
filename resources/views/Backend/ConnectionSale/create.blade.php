<form class="form-validate" action="{{route('sale.store')}}" method="post" enctype="multipart/form-data" >
    @csrf
    @include('Backend.ConnectionSale.form')
</form>



