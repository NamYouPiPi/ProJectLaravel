@extends('Backend.layouts.app')
@section('title', 'inventory')
@section('inventory', 'active')
@section('menu-open', 'menu-open')
@section('content')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    {{-- ======================= end of check messange ========================= --}}


    <div class="m-4">
        {{-- Dashboard Statistics --}}
        <div class="row mb-4">
            {{-- Total Items --}}
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Items</h5>
                        <h2 class="mb-0">{{ $stats['total_items'] }}</h2>
                        <small>Items in inventory</small>
                    </div>
                </div>
            </div>

            {{-- Low Stock Alert --}}
            <div class="col-md-3">
                <div class="card {{ $stats['low_stock'] > 0 ? 'bg-warning' : 'bg-success' }} text-white">
                    <div class="card-body">
                        <h5 class="card-title">Low Stock Alert</h5>
                        <h2 class="mb-0">{{ $stats['low_stock'] }}</h2>
                        <small>Items need reordering</small>
                    </div>
                </div>
            </div>

            {{-- Out of Stock --}}
            <div class="col-md-3">
                <div class="card {{ $stats['out_of_stock'] > 0 ? 'bg-danger' : 'bg-success' }} text-white">
                    <div class="card-body">
                        <h5 class="card-title">Out of Stock</h5>
                        <h2 class="mb-0">{{ $stats['out_of_stock'] }}</h2>
                        <small>Items at zero quantity</small>
                    </div>
                </div>
            </div>

            {{-- Categories --}}
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <h2 class="mb-0">{{ $stats['categories'] }}</h2>
                        <small>Different item categories</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div class="card mb-4">
            <div class="card-body d-flex  align-items-center gap-4">
                  <div class="d-inline">
                        <x-create_modal dataTable="inventory" title="Add New Inventory">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fas fa-plus"></i> Add New
                            </button>
                        </x-create_modal>
                    </div>
                <form action="{{ route('inventory.index') }}" method="GET" id="filterForm" class="d-flex align-items-center gap-3">
                    {{-- Add New Button --}}


                    {{-- Search --}}
                    <div class="flex-grow-1">
                        <input type="text" name="search" class="form-control" placeholder="Search by item name..."
                            value="{{ request('search') }}">
                    </div>

                    {{-- Category Filter --}}
                    <div style="width: 150px;">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category }}" {{ request('category') == $cat->category ? 'selected' : '' }}>
                                    {{ $cat->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Stock Status Filter --}}
                    <div style="width: 150px;">
                        <select name="stock_status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Stock Status</option>
                            <option value="in" {{ request('stock_status') == 'in' ? 'selected' : '' }}>In Stock</option>
                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    {{-- Reorder Alert Filter --}}
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="reorder_alert" value="true"
                                id="reorderAlert" {{ request('reorder_alert') == 'true' ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <label class="form-check-label" for="reorderAlert">
                                Show Reorder Alerts
                            </label>
                        </div>
                    </div>

                    {{-- Clear Filters --}}
                    <div>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('inventory.index') }}'">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card">
            <div class="card-body">
                <table id="example" class="display table table-responsive table-hover" style="width:100%">
        <thead>
            <tr class="text-center ">
{{--                <th>Id</th>--}}
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
{{--                    <td>{{$inventory->id}}</td>--}}
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

                      <button type="button" class="btn btn-outline-danger"
                                    onclick="confirmDelete({{ $inventory->id }}, 'inventory')">
                                    <i class="bi bi-trash3"></i>
                                </button>

                    </td>
                </tr>
            @endforeach
        </tbody>

                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $inventories->links() }}
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('js/ajax.js')}}"></script>
    <script src="{{ asset('js/inventory-filter.js')}}"></script>
    <script>
        $(document).ready(function () {
            EditById($('.btnEditInventory'), 'inventory')
        });
    </script>
@endsection
