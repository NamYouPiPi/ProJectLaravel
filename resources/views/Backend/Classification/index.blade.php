@extends('Backend.layouts.app')
@section('content')
@section('title', 'inventory')
@section('classification', 'active')
@section('movies-menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    {{-- ======================= end of check messange ========================= --}}


    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        @if(auth()->user()->hasPermission('create_classification'))

            <x-create_modal dataTable="classification" title="Add New classification">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg"></i> Add New classification
                </button>
            </x-create_modal>
        @endif

        {{--================================= end of button add new ==========================--}}


    </div>

    <div class="card m-3">
        <table id="example" class="display table table-responsive table-hover  " style="width:100%">
            <thead>
                <tr class="text-center bg-light`">
                    {{-- <th>Id</th> --}}
                    <th>Code</th>
                    <th>Name</th>
                    <th>Age Limit</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Create_at</th>
                    {{-- <th>Update_at</th> --}}
                    {{-- @if(auth()->user()->hasPermission('edit_classification')) --}}
                        <th>Action</th>
                    {{-- @endif --}}
                </tr>
            </thead>
            <tbody>
                @foreach($classifications as $classification)
                    <tr class="text-center" id="classification-row{{$classification->id}}">
                        {{-- <td>{{$classification->id}}</td> --}}
                        <td><span class="badge bg-secondary">{{$classification->code}}</span></td>
                        <td class="text-muted">{{$classification->name}}</td>
                        <td class="text-muted">{{$classification->age_limit}}</td>
                        <td><span class="badge bg-info"> {{$classification->country}}</span></td>
                        <td><span class="badge bg-primary">{{$classification->status}}</span></td>
                        <td class="text-muted">{{$classification->description}}</td>
                        <td>{{ $classification->created_at->format("Y/m/d") }}</td>
                        {{-- <td class="classification-updated">{{ $classification->updated_at->format("Y/m/d") }}</td> --}}
                        <td class="d-flex gap-1">
                            @if(auth()->user()->hasPermission('edit_classification'))
                                <x-update-modal dataTable="classification" title="Edit classification">
                                    <button type="button" class="btn btn-outline-primary btn-sm btn_edit_clss"
                                        data-id="{{$classification->id}}" data-bs-toggle="modal" data-bs-target="#updateModal">edit
                                    </button>
                                </x-update-modal>
                            @endif

                            @if (auth()->user()->hasPermission('delete_classification'))

                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    onclick="confirmDelete({{ $classification->id }}, 'classification')">
                                    del
                                </button>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- --------------- end of display data --------------------------}}


    {{-- ========== paginate ----------------}}
    <div class="d-flex justify-content-between align-items-center m-4">
        {{-- Results info --}}
        <div class="text-muted">
            Showing {{ $classifications->firstItem() ?? 0 }} to {{ $classifications->lastItem() ?? 0 }} of
            {{ $classifications->total() }} results
        </div>

        {{ $classifications->appends(request()->query())->links() }}

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
