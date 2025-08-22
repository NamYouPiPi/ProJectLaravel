@extends('Backend.layouts.app')
@section('content')
    @section('title', 'genre')
    @section('inventory', 'active')
{{--    @section('menu-open', 'menu-open')--}}
    {{-- ================== Toast notifications =======================--}}
    @include('Backend.components.Toast')
    {{-- ======================= end of toast notifications ========================= --}}

    {{-- Dashboard Cards --}}
{{--    <div class="row mb-4">--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">--}}
{{--                <div class="card-body text-center">--}}
{{--                    <h5 class="card-title">Total Genres</h5>--}}
{{--                    <div class="stats-number">{{  }}</div>--}}
{{--                    <p class="card-text">All registered genres</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">--}}
{{--                <div class="card-body text-center">--}}
{{--                    <h5 class="card-title">Active Genres</h5>--}}
{{--                    <div class="stats-number">{{  }}</div>--}}
{{--                    <p class="card-text">Currently active</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">--}}
{{--                <div class="card-body text-center">--}}
{{--                    <h5 class="card-title">Inactive Genres</h5>--}}
{{--                    <div class="stats-number">{{  }}</div>--}}
{{--                    <p class="card-text">Currently inactive</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    {{-- Filter Section --}}
    <div class="filter-section">
             {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="customer" title="Add New Customer">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                ➕ Add New Genre
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}


            <div>



        </div>
    </div>



            <div class="card shadow">
                <div class="card-body">
                    <table id="example" class="display table table-responsive table-hover" style="width:100%">
                        <thead class="table-dark">
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="text-center">
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        @if ($customer->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $customer->updated_at->format('Y-m-d') }}</td>
                                    <td class="d-flex gap-2">
                            <x-update-modal dataTable="customer" title="update customer">
                                <button type="button" class="btn btn-outline-primary  btn-sm btn-customer" data-id="{{$customer->id}}"
                                    data-bs-toggle="modal" data-bs-target="#updateModal"><i class="bi bi-pencil"></i>
                                </button>
                            </x-update-modal>
                                       <button type="button" class="btn-sm btn btn-outline-danger"
                                    onclick="confirmDelete({{ $customer->id }}, 'customer')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- --------------- end of display data --------------------------}}




            {{-- ========== paginate ----------------}}
<div class="d-flex justify-content-between align-items-center m-4">
    {{-- Results info --}}
        <div class="text-muted">
           Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} results
        </div>

           {{ $customers->appends(request()->query())->links() }}

    </div>
            {{-- ---------- end of paginate ------------}}

            {{-- ------------ add file ajax ---------------}}
            <script src="{{ asset('js/ajax.js')}}"></script>

            <script>
                $(document).ready(function() {
                    EditById($('.btn-customer'), 'customer');

                });
            </script>
        @endsection
