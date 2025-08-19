@extends('Backend.layouts.app')
@section('content')
@section('title', 'inventory')
@section('inventory', 'active')
@section('menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    {{-- ======================= end of check messange ========================= --}}


    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="classification" title="Add New classification">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New classification
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}



        {{-- ===================== display data on table ===========================--}}
        {{-- <label for="">Category </label>--}}
        {{-- <select class="form-select float-end" style="width: 80px" aria-label="Default select example">
            <option selected>Sort</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select> --}}

    </div>

    <table id="example" class="display table table-responsive table-hover  " style="width:100%">
        <thead>
            <tr class="text-center ">
                <th>Id</th>
                <th>Code</th>
                <th>Name</th>
                <th>Age Limit</th>
                <th>Country</th>
                <th>Status</th>
                <th>Description</th>
                <th>Create_at</th>
                <th>Update_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classifications as $classification)
                <tr class="text-center" id="classification-row{{$classification->id}}">
                    <td>{{$classification->id}}</td>
                    <td class="classification-code">{{$classification->code}}</td>
                    <td class="classification-name">{{$classification->name}}</td>
                    <td class="classification-age-limit">{{$classification->age_limit}}</td>
                    <td class="classification-country">{{$classification->country}}</td>
                    <td class="classification-status">{{$classification->status}}</td>
                    <td class="classification-description">{{$classification->description}}</td>
                    <td class="classification-created">{{ $classification->created_at->format("Y/m/d") }}</td>
                    <td class="classification-updated">{{ $classification->updated_at->format("Y/m/d") }}</td>
                    <td class="d-flex gap-1">
                        <x-update-modal dataTable="classification" title="Edit classification">
                            <button type="button" class="btn btn-success btn_edit_clss" data-id="{{$classification->id}}"
                                data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                            </button>
                        </x-update-modal>

                        <button type="button" class="btn btn-outline-danger"
                                    onclick="confirmDelete({{ $classification->id }}, 'classification')">
                                    <i class="bi bi-trash3"></i>
                                </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- --------------- end of display data --------------------------}}


    {{-- ========== paginate ----------------}}
    <div class="flex justify-center mt-1">
        {{-- {{ $inventories->links() }}--}}
    </div>
    {{-- ---------- end of paginate ------------}}

    {{-- ------------ add file ajax ---------------}}

    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>

        $(document).ready(function () {

            EditById($('.btn_edit_clss'), 'classification');
            // RedirectToIndex();
        });
    </script>


@endsection
