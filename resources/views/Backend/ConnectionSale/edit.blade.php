<form id="updateForm"
      action="{{ route('sale.update', $connection_sale->id) }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('Backend.ConnectionSale.form')

</form>
