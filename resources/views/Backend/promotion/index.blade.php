@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'promotion')
@section('promotion', 'active')
@section('content')
    <h1 class="h3 mb-4">Manage Promotions</h1>

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')


    <x-create_modal dataTable="promotion" title="Add New Promotion" class="">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Add New Promotion
        </button>
    </x-create_modal>
    <div class="table-responsive card m-2">
        <table class="table table-hover " id="suppliersTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Promotion Image</th>
                    <th>Description</th>
                    <th>Create At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promotions as $promotion)
                    <tr>
                        <td>{{ $promotion->title }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $promotion->proImage) }}" style="width: 40px ; " alt="">
                        </td>
                        <td>{{ $promotion->description }}</td>
                        <td>{{ $promotion->created_at->format("Y/m/d") }}</td>
                        <td class="d-flex gap-2">
                            <x-update-modal dataTable="promotion" title="update Supplier">
                                <button type="button" class="btn btn-outline-primary btn-sm editSupplierBtn"
                                    data-id="{{ $promotion->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </x-update-modal>

                            <button type="button" class="btn btn-outline-danger btn-sm"
                                onclick="confirmDelete({{ $promotion->id }}, 'promotions')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- ================ Table for Suppliers detail all ===================== --}}


    {{--================== pagination ====================--}}
    <div class="d-flex justify-content-between align-items-center m-4">
        <div class="text-muted">
            Showing {{ $promotions->firstItem() ?? 0 }} to {{ $promotions->lastItem() ?? 0 }} of {{ $promotions->total() }}
            results
        </div>
        {{ $promotions->appends(request()->query())->links() }}
    </div>



    {{-- ================ end of pagination ================--}}

    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>
        $(document).ready(function () {
            EditById($('.editSupplierBtn'), 'suppliers');

        });
    </script>
@endsection
