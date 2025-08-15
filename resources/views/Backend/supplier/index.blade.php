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
    @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif
    {{-- ======================= end of check messange ========================= --}}

    {{-- ============ input search ========================== --}}
    <form method="GET" action="{{ route('suppliers.index') }}" class="mb-3 m-3">
        <div class="float-start d-flex gap-3 ">
            <input type="text " name="search" class="form-control" id="exampleFormControlInput1" placeholder="Search here "
                value="{{ $search }}">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Reset</a>
        </div>

        {{-- ======== button modal for create a suppliers ======================= --}}

    </form>
    {{--=============== end of search ===========================--}}

{{--============= click button add new =============--}}
<x-create_modal dataTable="supplier" title="Add New Supplier" class="float-end">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        Add New Supplier
    </button>
</x-create_modal>

{{-- ================ end of button add new ===================== --}}



    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive">
        <table class="table table-hover " id="suppliersTable">
            <thead>
                <tr>
                    <th>ID</th>
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
                        <td>{{ $supplier->id }}</td>
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
            DeleteById($('.btnSupplier'), 'suppliers', '#supplier-row');
            EditById($('.editSupplierBtn') , 'suppliers');
        });
    </script>
@endsection
