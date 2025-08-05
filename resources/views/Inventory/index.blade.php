@extends('layouts.app')
@section('content')
@section('title', 'inventory')
@section('inventory', 'active')
@section('menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger" id=alert-danger">
            {{ session('error') }}
    @endif

        {{-- ======================= end of check messange ========================= --}}


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('Inventory.create')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        {{--------------------- end modal --------------------}}
        <table id="example" class="display table table-striped table-bordered table-hover  " style="width:100%">
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
                @foreach($Inventories as $inventory)

                    <tr class="text-center">
                        <td>{{$inventory->id}}</td>
                        <td>{{$inventory->supplier_id}}</td>
                        <td>{{$inventory->item_name}}</td>
                        <td>{{$inventory->category}}</td>
                        <td>{{$inventory->quantity}}</td>
                        <td>{{$inventory->unit}}</td>
                        <td>{{$inventory->cost_price}}</td>
                        <td>{{$inventory->sale_price}}</td>
                        <td>{{$inventory->stock_level}}</td>
                        <td>{{$inventory->reorder_level}}</td>
                        <td>{{$inventory->stock}}</td>
                        <td>{{$inventory->image}}</td>
                        <td>{{$inventory->status}}</td>
                        <td>{{ $inventory->created_at->format("Y/m/d") }}</td>
                        <td>{{ $inventory->updated_at->format("Y/m/d") }}</td>

                        {{-- <td><img src="" class="rounded mx-auto d-block" alt="..."></td>--}}
                        <td>
                            <a href="" class="btn btn-info">Edit</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>

                    </tr>

                @endforeach

            </tbody>
        </table>
            <div class="flex justify-center mt-1">
                {{ $Inventories->links() }}
            </div>
@endsection
