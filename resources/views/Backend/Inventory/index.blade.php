@extends('Backend.layouts.app')
@section('content')
@section('title', 'inventory')
@section('inventory', 'active')
@section('menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    {{-- ======================= end of check messange ========================= --}}


    <div class="m-4 d-flex justify-content-between">
        {{-- <label for="">Category </label>--}}
        <select class="form-select float-end" style="width: 80px" aria-label="Default select example">
            <option selected>Sort</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="inventory" title="Add New Inentory">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New Inventroy
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}



        {{-- ===================== display data on table ===========================--}}


    </div>

    <table id="example" class="display table table-responsive table-hover  " style="width:100%">
        <thead>
            <tr class="text-center ">
                <th>Id</th>
                <th>Supplier Name</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Cost Price</th>
                <th>Sale Price</th>
                <th>Stock Level</th>
                <th>Reorder Level</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Status</th>
                <th>Create_at</th>
                <th>Update_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inventory)
                <tr class="text-center" id="inventory{{$inventory->id}}">
                    <td>{{$inventory->id}}</td>
                    <td>{{$inventory->supplier_name}}</td>
                    <td>{{$inventory->item_name}}</td>
                    <td>{{$inventory->category}}</td>
                    <td>{{$inventory->quantity}}</td>
                    <td>{{$inventory->unit}}</td>
                    <td>{{$inventory->cost_price}}</td>
                    <td>{{$inventory->sale_price}}</td>
                    <td>{{$inventory->stock_level}}</td>
                    <td>{{$inventory->reorder_level}}</td>
                    <td>{{$inventory->stock}}</td>
                    {{-- ====== base image url i read from .end file ============ --}}
                    <td><img src="{{config('app.image_base_url')}}{{$inventory->image}}" alt="Avatar"
                            class="rounded-circle img-fluid" style="width: 40px; height: 40px;"></td>
                    <td>{{$inventory->status}}</td>
                    <td>{{ $inventory->created_at->format("Y/m/d") }}</td>
                    <td>{{ $inventory->updated_at->format("Y/m/d") }}</td>
                    <td class="d-flex gap-1">
                        <x-update-modal dataTable="inventory" title="Edit Inventory">
                            <button type="button" class="btn btn-success btnEditInventory" data-id="{{$inventory->id}}"
                                data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                            </button>
                        </x-update-modal>

                        <x-delete-modal dataTable="inventory" title="Delete Inventory">
                            <button type="button" class="btn btn-danger btndeleteInventory" data-id="{{ $inventory->id}}"
                                data-bs-toggle="modal" data-bs-target="#deletemodal">
                                Delete
                            </button>
                        </x-delete-modal>

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {{-- --------------- end of display data --------------------------}}


    {{-- ========== paginate ----------------}}
    <div class="flex justify-center mt-1">
        {{ $inventories->links() }}
    </div>
    {{-- ---------- end of paginate ------------}}

    {{-- ------------ add file ajax ---------------}}

    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>
        $(document).ready(function () {

            DeleteById($('.btndeleteInventory'), 'inventory')
            EditById($('.btnEditInventory'), 'inventory')
        });
    </script>


@endsection
