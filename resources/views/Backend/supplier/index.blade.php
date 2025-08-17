@extends('Backend.layouts.app')
@section('content')
{{-- ============ add title and active =======================--}}
@section('title', 'supplier')
@section('supplier', 'active')
@section('menu-open', 'menu-open')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--================= end of add title and active ==============--}}

    {{-- Alert Container for AJAX responses --}}
    <div id="alert-container"></div>

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')



{{-- ================ end of button add new ===================== --}}
<div class="d-flex justify-content-between  align-content-center mt-3 mb-3 p-3">

 <form method="GET" action="{{ route('suppliers.index') }}" class="d-flex " id="searchForm">
    <div class="float-start d-flex gap-3 ">
        <input type="text" name="search" class="form-control" id="searchInput" placeholder="Search here"
            value="{{ $search }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

<script>
    // Auto-submit the form when typing in the search box (with debounce)
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            document.getElementById('searchForm').submit();
        }, 100); // Adjust delay as needed
    });
</script>
{{-- start filter by status  --}}
<form method="GET" action="{{ route('suppliers.index') }}" class=" " id="filterForm">
<div class="d-flex align-items-center gap-2">
    <label for="status" class="mb-0">Filter By Status</label>
    <select name="status" id="status" class="form-select" style="width: auto; min-width: 150px;">
        <option value="">All</option>
        <option value="active" {{ $searchStatus === 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ $searchStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
</form>

    <x-create_modal dataTable="supplier" title="Add New Supplier" class="">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        Add New Supplier
    </button>
</x-create_modal>


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
        {{ $suppliers->links() }}
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
        }, 2000);
    }
    updateTableRow(supplier)
}
        });
    </script>
@endsection
