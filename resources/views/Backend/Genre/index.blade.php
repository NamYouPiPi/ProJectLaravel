@extends('Backend.layouts.app')
@section('content')
    @section('title', 'genre')
    @section('inventory', 'active')
    @section('menu-open', 'menu-open')
    {{-- ================== Toast notifications =======================--}}
    @include('Backend.components.Toast')
    {{-- ======================= end of toast notifications ========================= --}}

            <div class="m-4 d-flex justify-content-between">
                {{-- ==================== begin button add new ========================--}}
                <x-create_modal dataTable="genre" title="Add New Genre">
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
{{--                    <th>Id</th>--}}
                   <th>Main Genre</th>
                    <th>Sub Genre</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Create_at</th>
                    <th>Update_at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($genres as $genre)

                    <tr class="text-center genre-row{{$genre->id}}">
{{--                        <td>{{$genre->id}}</td>--}}
                        <td>{{$genre->main_genre}}</td>
                        <td>{{$genre->sub_genre}}</td>
                        <td>{{$genre->description}}</td>
                        <td>{{$genre->status}}</td>
                        <td>{{ $genre->created_at->format("d/m/Y") }}</td>
                        <td>{{ $genre->updated_at->format("d/m/Y") }}</td>
                        <td class="d-flex gap-2">
                            <x-update-modal dataTable="genre" title="Edit Genre">
                                <button type="button" class="btn btn-success btn_update_genre" data-id="{{ $genre->id}}"
                                        data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                                </button>
                            </x-update-modal>

                            <x-delete-modal dataTable="inventory" title="Delete Genre ">
                                <button type="button" class="btn btn-danger btn_delete_genre" data-id="{{ $genre->id}}"
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
                    EditById($('.btn_update_genre'), 'genre');
                    DeleteById($('.btn_delete_genre'), 'genre');
                });
            </script>
        @endsection
