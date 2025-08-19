@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'supplier')
@section('supplier', 'active')
@section('menu-open', 'menu-open')
@section('content')

    {{--================= end of add title and active ==============--}}


    {{-- Alert Container for AJAX responses --}}
    <div id="alert-container"></div>

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    <div class="m-4">
        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card supplier-card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Suppliers</h5>
                        <h2 class="mb-0">{{ $suppliers->total() }}</h2>
                        <small>Registered suppliers</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card supplier-card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Active Suppliers</h5>
                        <h2 class="mb-0">{{ $suppliers->where('status', 'active')->count() }}</h2>
                        <small>Currently active</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card supplier-card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Inactive Suppliers</h5>
                        <h2 class="mb-0">{{ $suppliers->where('status', 'inactive')->count() }}</h2>
                        <small>Currently inactive</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card supplier-card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Supplier Types</h5>
                        <h2 class="mb-0">{{ $suppliers->unique('supplier_type')->count() }}</h2>
                        <small>Different categories</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <x-create_modal dataTable="supplier" title="Add New Supplier">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fas fa-plus"></i> Add Supplier
                            </button>
                        </x-create_modal>
                    </div>
                <form method="GET" action="{{ route('suppliers.index') }}" class="d-flex align-items-center gap-3 float-end" id="filterForm">
                    {{-- Add New Button --}}


                    {{-- Search Box --}}
                    <div class="flex-grow-1">
                        <input type="text" name="search" class="form-control search-box" id="searchInput"
                            placeholder="Search by name, email, or phone..." value="{{ $search }}">
                    </div>

                    {{-- Status Filter --}}
                    <div style="width: 150px;">
                        <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ $searchStatus === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $searchStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Clear Filters --}}
                    <div>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>
{{--
    <x-create_modal dataTable="supplier" title="Add New Supplier" class="">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        Add New Supplier
    </button>
</x-create_modal> --}}


<script>
    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>

</div>


    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive">
        <table class="table table-hover " id="suppliersTable">
            <thead>
                <tr>
{{--                    <th>ID</th>--}}
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Contact Person</th>
                    <th>Supplier Type</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr id="supplier-row{{ $supplier->id }}">
{{--                        <td>{{ $supplier->id }}</td>--}}
                        <td class="supplier-name">{{ $supplier->name }}</td>
                        <td class="supplier-email">{{ $supplier->email }}</td>
                        <td class="supplier-phone">{{ $supplier->phone }}</td>
                        <td class="supplier-contact">{{ $supplier->contact_person }}</td>
                        <td class="supplier-type">{{ $supplier->supplier_type }}</td>
                        <td class="supplier-status">{{ $supplier->status }}</td>
                        <td class="supplier-address">{{ $supplier->address }}</td>
                        <td>{{ $supplier->created_at->format("Y/m/d") }}</td>
                        <td class="supplier-updated">{{ $supplier->updated_at->format("Y/m/d") }}</td>
                        <td class="d-flex gap-2">
                            <x-update-modal dataTable="supplier" title="update Supplier">
                                <button type="button" class="btn btn-warning  editSupplierBtn" data-id="{{ $supplier->id }}">
                                    Update
                                </button>
                            </x-update-modal>

                            <x-delete-modal dataTable="supplier" title="Add New Supplier">
                                <button type="button" class="btn btn-danger btnSupplier"
                                    data-id="{{ $supplier->id}}" data-bs-toggle="modal" data-bs-target="#deletemodal">
                                    Delete
                                </button>
                            </x-delete-modal>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{--================== pagination ====================--}}
    <div class="flex justify-center mt-1">

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>

    <script src="{{ asset('js/supplier-filter.js') }}"></script>

    </div>
    {{-- ================ end of pagination ================--}}

    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>
        $(document).ready(function () {
            DeleteById($('.btnSupplier'), 'suppliers');
            EditById($('.editSupplierBtn') , 'suppliers');

        function updateTableRow(supplier) {
        let row = $("#supplier-row" + supplier.id);
        if (row.length) {
        row.find(".supplier-name").text(supplier.name);
        row.find(".supplier-email").text(supplier.email);
        row.find(".supplier-phone").text(supplier.phone);
        row.find(".supplier-contact").text(supplier.contact_person);
        row.find(".supplier-type").text(supplier.supplier_type);
        row.find(".supplier-status").text(supplier.status);
        row.find(".supplier-address").text(supplier.address);
        row.find(".supplier-updated").text(
            new Date().toLocaleDateString("en-CA")
        );
        // Add a highlight effect
        row.addClass("table-success");
        setTimeout(() => {
            row.removeClass("table-success");
        }, 500);
    }
    updateTableRow(supplier)
}
        });
    </script>
@endsection
