@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'supplier')
@section('supplier', 'active')
@section('inventory-menu-open', 'menu-open')
@section('content')
    <style>
        /* Stats Cards */
        .supplier-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            border: none;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .supplier-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .supplier-card .card-body {
            padding: 1.5rem;
        }

        .supplier-card h5 {
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .supplier-card h2 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        /* Table Styles */
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        #suppliersTable {
            margin-bottom: 0;
        }

        #suppliersTable thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        #suppliersTable tbody tr {
            transition: background-color 0.2s;
        }

        #suppliersTable tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Highlight effect animation */
        .table-success {
            animation: highlight-fade 2s ease-in-out;
        }

        @keyframes highlight-fade {
            0% {
                background-color: rgba(40, 167, 69, 0.2);
            }

            100% {
                background-color: transparent;
            }
        }

        /* Buttons and actions */
        .btn-outline-primary,
        .btn-outline-danger {
            border-radius: 5px;
            padding: 0.375rem 0.75rem;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 2px 5px rgba(13, 110, 253, 0.3);
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
        }

        /* Filter form */
        #filterForm {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
        }

        .search-box {
            min-width: 250px;
            border-radius: 6px;
        }

        /* Pagination */
        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .page-link {
            color: #0d6efd;
            border-radius: 5px;
            margin: 0 3px;
        }

        /* Status badges */
        .supplier-status {
            position: relative;
        }

        .supplier-status:before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .supplier-status:contains("active"):before {
            background-color: #28a745;
        }

        .supplier-status:contains("inactive"):before {
            background-color: #dc3545;
        }
    </style>

    {{--================= end of add title and active ==============--}}



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
            <div class="card-body bg-red d-flex justify-content-between align-items-center">
                <div>
                    <x-create_modal dataTable="supplier" title="Add New Supplier">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="bi bi-plus-lg"></i> Add Supplier
                        </button>
                    </x-create_modal>
                </div>
                <div class="float-end">
                    <form method="GET" action="{{ route('suppliers.index') }}" class="d-flex align-items-center gap-3 "
                        id="filterForm">
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
                                <option value="inactive" {{ $searchStatus === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
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
        </div>
        {{--
        <x-create_modal dataTable="supplier" title="Add New Supplier" class="">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New Supplier
            </button>
        </x-create_modal> --}}


        <script>
            document.getElementById('status').addEventListener('change', function () {
                document.getElementById('filterForm').submit();
            });
        </script>

    </div>


    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive card px-5">
        <table class="table table-hover p-3 " id="suppliersTable">
            <thead>
                <tr>
                    {{-- <th>ID</th>--}}
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Contact Person</th>
                    <th>Supplier Type</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Created</th>
                    {{-- <th>Updated</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                            <tr class="text-muted" id="supplier-row{{ $supplier->id }}">
                                {{-- <td>{{ $supplier->id }}</td>--}}
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->contact_person }}</td>
                                {{-- <td><span class="badge bg-{{ $supplier->supplier_type === 'drinks' ? 'primary' : 'secondary' }}">{{
                                        $supplier->supplier_type }}</span></td> --}}
                                <td>
                                    <span class="badge
                        @if($supplier->supplier_type === 'drinks') bg-primary
                        @elseif($supplier->supplier_type === 'foods') bg-success
                        @elseif($supplier->supplier_type === 'snacks') bg-warning text-dark
                        @elseif($supplier->supplier_type === 'movies') bg-info text-dark
                        @elseif($supplier->supplier_type === 'others') bg-secondary
                        @else bg-light text-dark
                        @endif
                    ">
                                        {{ $supplier->supplier_type ?? 'N/A' }}
                                    </span>
                                </td>
                                <td><span
                                        class="badge bg-{{ $supplier->status === 'active' ? 'success' : 'danger' }}">{{ $supplier->status }}</span>
                                </td>
                                <td>{{ $supplier->address }}</td>
                                <td>{{ $supplier->created_at->format("Y/m/d") }}</td>
                                {{-- <td class="supplier-updated">{{ $supplier->updated_at->format("Y/m/d") }}</td> --}}
                                <td class="d-flex gap-2">
                                    <x-update-modal dataTable="supplier" title="update Supplier">
                                        <button type="button" class="btn btn-outline-primary btn-sm editSupplierBtn"
                                            data-id="{{ $supplier->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </x-update-modal>

                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="confirmDelete({{ $supplier->id }}, 'suppliers')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{--================== pagination ====================--}}
   <div class="d-flex justify-content-between align-items-center m-4">
        <div class="text-muted">
            Showing {{ $suppliers->firstItem() ?? 0 }} to {{ $suppliers->lastItem() ?? 0 }} of {{ $suppliers->total() }} results
        </div>
        {{ $suppliers->appends(request()->query())->links() }}
    </div>


</div>

{{-- ================ end of pagination ================--}}
<script src="{{ asset('js/supplier-filter.js') }}"></script>
    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>
        $(document).ready(function () {
            EditById($('.editSupplierBtn'), 'suppliers');

        });
    </script>
@endsection
