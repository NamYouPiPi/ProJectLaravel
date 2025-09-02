@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'promotion')
@section('promotion', 'active')
@section('content')

    <div class="d-flex justify-content-between p-3">
         <h1 class="h3 mb-4">Manage Carousels</h1>
    <x-create_modal dataTable="carousel" title="Add New Carousel" class="" >
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Add New Carousel
        </button>
    </x-create_modal>
    </div>
    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')



    <div class="table-responsive card m-2">
        <table class="table table-hover " id="suppliersTable">
            <thead>
                <tr>
                    <th>Carousel Image</th>
                    <th>Status</th>
                    <th>Create At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carousels as $carousel)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $carousel->carousel_image) }}" style="width: 40px ; " alt="">
                        </td>
                        <td>{{ $carousel->status }}</td>
                        <td>{{ $carousel->created_at->format("Y/m/d") }}</td>
                        <td class="d-flex gap-2">
                            <x-update-modal dataTable="promotion" title="update Supplier">
                                <button type="button" class="btn btn-outline-primary btn-sm editSupplierBtn"
                                    data-id="{{ $carousel->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </x-update-modal>

                            <button type="button" class="btn btn-outline-danger btn-sm"
                                onclick="confirmDelete({{ $carousel->id }}, 'carousels')">
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
            Showing {{ $carousels->firstItem() ?? 0 }} to {{ $carousels->lastItem() ?? 0 }} of {{ $carousels->total() }}
            results
        </div>
        {{ $carousels->appends(request()->query())->links() }}
    </div>



    {{-- ================ end of pagination ================--}}

    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>
        $(document).ready(function () {
            EditById($('.editSupplierBtn'), 'suppliers');

        });
    </script>
@endsection
