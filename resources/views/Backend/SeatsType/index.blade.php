@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'supplier')
@section('supplier', 'active')
{{--@section('menu-open', 'menu-open')--}}
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{--================= end of add title and active ==============--}}


    {{-- Alert Container for AJAX responses --}}
    <div id="alert-container"></div>

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')
    <x-create_modal dataTable="seatsType" title="Add New seatsType" class="">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createModal">
            Add New Supplier
        </button>
    </x-create_modal>


    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive">
        <table class="table table-hover " id="suppliersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Created</th>
                    {{-- <th>Updated</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seat_types as $seat_type)
                    <tr>
                        <td>{{ $seat_type->name }}</td>
                        <td>{{ $seat_type->price }}</td>
                        <td>
                            @if($seat_type->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($seat_type->status === 'inactive')
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $seat_type->created_at->format('Y-m-d') }}</td>
                        {{-- <td>{{ $seat_type->updated_at->format('Y-m-d') }}</td> --}}
                        <td class="d-flex gap-2">
                            <x-update-modal dataTable="SeatsType" title="update SeatsType">
                                <button type="button" class="btn btn-outline-primary  btnUpdateSeats"
                                    data-id="{{ $seat_type->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </x-update-modal>

                            <button type="button" class="btn btn-outline-danger"
                                onclick="confirmDelete({{ $seat_type->id }}, 'seatTypes')">
                                <i class="bi bi-trash3"></i>
                            </button>

                    </tr>

                @endforeach
            </tbody>

        </table>
    </div>

    {{--================== pagination ====================--}}
    <div class="d-flex justify-content-between align-items-center m-4">
        <div class="text-muted">
            Showing {{ $seat_types->firstItem() ?? 0 }} to {{ $seat_types->lastItem() ?? 0 }} of {{ $seat_types->total() }}
            results
        </div>
        {{ $seat_types->appends(request()->query())->links() }}
    </div>

    <script src="{{ asset('js/supplier-filter.js') }}"></script>

    {{-- ================ end of pagination ================--}}

    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>


        $(document).ready(function () {

            EditById($('.btnUpdateSeats'), 'seatTypes');
        });
    </script>
@endsection
