@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                const alertBox = document.getElementById('success-alert');
                if (alertBox) {
                    alertBox.style.display = 'none';
                }
            }, 2000); // 2 seconds
        </script>

    @endif

    <form method="GET" action="{{ route('suppliers.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Search Name or Email" value="{{ $search }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#myModal" id="add">Add New </button>

    <!-- Modal create and update two in one modal -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">
                        {{ isset($supplier) ? 'Edit Supplier Record' : 'Add New Supplier Record' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @if (isset($supplier))
                        @include('supplier.edit', ['supplier' => $supplier])
                    @else
                        @include('supplier.create')
                    @endif
                </div>

{{--                footer modal--}}
                <div class="modal-footer">
                    <!-- Optional Save Button or Actions -->
                </div>
            </div>
        </div>
    </div>
{{--    ======= End of modal add Suppliers =================    --}}


{{--    ================ Table for Suppliers detail all ===================== --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Contact Person</th>
                <th>Supplier Type</th>
                <th>Status</th>
                <th>Address</th>
                <th>Create at</th>
                <th>Update at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->supplier_type }}</td>
                    <td>{{ $supplier->status }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->created_at->format("Y/m/d") }}</td>
                    <td>{{ $supplier->updated_at->format("Y/m/d") }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editSupplierBtn" data-id="{{ $supplier->id }}">Edit</button>
                        <button class="btn btn-danger btn-sm deleteSupplierBtn" data-id="{{ $supplier->id }}">Delete</button>
{{--                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#myModal{{$supplier->id}}" data-id="{{$supplier->id}}" id="add">EDIT </button>--}}

{{--                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" onclick="return confirm('Are you sure?')"--}}
{{--                                class="btn btn-danger btn-sm">Delete</button>--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

{{--    {{ $suppliers->links() }}--}}


@endsection
