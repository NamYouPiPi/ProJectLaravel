<form id="updateForm"
    action="{{ route('inventory.update', $inventory->id) }}"
    method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('Backend.Inventory.form')

</form>
