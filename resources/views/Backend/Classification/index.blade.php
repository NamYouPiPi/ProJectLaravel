@extends('Backend.layouts.app')
@section('content')
    @section('title', 'inventory')
    @section('inventory', 'active')
    @section('menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger" id=alert-danger">
            {{ session('error') }}
            @endif
            {{-- ======================= end of check messange ========================= --}}


            <div class="m-4 d-flex justify-content-between">
                {{-- ==================== begin button add new ========================--}}
                <x-create_modal dataTable="classification" title="Add New classification">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        Add New Inventroy
                    </button>
                </x-create_modal>
                {{--================================= end of button add new ==========================--}}



                {{-- ===================== display data on table ===========================--}}
                {{--            <label for="">Category </label>--}}
                <select class="form-select float-end" style="width: 80px" aria-label="Default select example">
                    <option selected>Sort</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

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
                <tr class="text-center" id="classification">
                    <td>{{$classification->id}}</td>
                    <td>{{$classification->code}}</td>
                    <td>{{$classification->name}}</td>
                    <td>{{$classification->age_limit}}</td>
                    <td>{{$classification->country}}</td>
                    <td>{{$classification->status}}</td>
                    <td>{{$classification->description}}</td>
                    <td>{{ $classification->created_at->format("Y/m/d") }}</td>
                    <td>{{ $classification->updated_at->format("Y/m/d") }}</td>
                    <td class="d-flex gap-1">
                        <x-update-modal dataTable="classification" title="Edit classification">
                            <button type="button" class="btn btn-success btn_edit_clss" data-id="{{$classification->id}}"
                                    data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                            </button>
                        </x-update-modal>

                        <x-delete-modal dataTable="classification" title="Delete classification">
                            <button type="button" class="btn btn-danger btn_delete_clss" data-id="{{ $classification->id}}"
                                    data-bs-toggle="modal" data-bs-target="#deletemodal">
                                Delete
                            </button>
                        </x-delete-modal>

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{-- --------------- end of display data --------------------------}}


            {{-- ========== paginate ----------------}}
            <div class="flex justify-center mt-1">
{{--                {{ $inventories->links() }}--}}
            </div>
            {{-- ---------- end of paginate ------------}}

            {{-- ------------ add file ajax ---------------}}

            <script src="{{ asset('js/ajax.js')}}"></script>

            <script>
                $(document).ready(function() {
                    //
                    DeleteById($('.btn_delete_clss'), 'classification')
                    EditById($('.btn_edit_clss'), 'classification')
                });
            </script>


        @endsection
