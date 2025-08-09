<form id="updateForm"
      action="{{ route('sale.update.', $sale->id) }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    hello world
{{--    @include('Backend.ConnectionSale.form')--}}

</form>
