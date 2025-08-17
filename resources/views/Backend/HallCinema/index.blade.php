@extends('Backend.layouts.app')
@section('content')
@section('title', 'hallLocation')


    {{-- ================== Toast notifications =======================--}}
    @include('Backend.components.Toast')
    {{-- ======================= end of toast notifications ========================= --}}

    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="hallcinema" title="Add New HallCinema" :hall_location="$hall_location">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New Inventroy
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}


       <form action="{{route('hallCinema.index')}}" method="GET">
        <select name="status" id="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
       </form>
       <script>
        $(document).ready(function () {
            $('#status').change(function () {
                $(this).closest('form').submit();
            });
        });
       </script>



        {{-- ===================== display data on table ===========================--}}
    </div>

    <table id="example" class="display table table-responsive table-hover  " style="width:100%">
        <thead>
            <tr class="text-center ">
                {{-- <th>Name</th>--}}
                <th>Cinema Hall Name</th>
                <th>Total Seats</th>
                <th>Hall Type</th>
                <th>Status</th>
                <th>Create_at</th>
                <th>Update_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hall_cinema as $hall_cinemas)

                <tr class="text-center ">
                    {{-- <td>{{ $hall->id}}</td>--}}
{{--                     <td>{{$hall_cinemas->name}}</td>/--}}
                    <td>{{$hall_cinemas->cinema_name}}</td>
                    <td>{{$hall_cinemas->total_seats}}</td>
                    <td>{{$hall_cinemas->hall_type}}</td>
                    <td>{{$hall_cinemas->status}}</td>
                    <td>{{ $hall_cinemas->created_at->format("d/m/Y") }}</td>
                    <td>{{ $hall_cinemas->updated_at->format("d/m/Y") }}</td>
                    <td class="d-flex gap-2">
                        <x-update-modal dataTable="hallCinema" title="Edit Hall Cinema ">
                            <button type="button" class="btn btn-success btn_edit_cinema " data-id="{{ $hall_cinemas->id}}"
                                data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                            </button>
                        </x-update-modal>

                        <x-delete-modal dataTable="hallCinema" title="Delete Cinema Hall ">
                            <button type="button" class="btn btn-danger btn_del_cinema" data-id="{{ $hall_cinemas->id}}"
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
        {{ $hall_cinema->links() }}
    </div>
    {{-- ---------- end of paginate ------------}}

    {{-- ------------ add file ajax ---------------}}

    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>
        $(document).ready(function () {
            EditById($('.btn_edit_cinema'), 'hallCinema');
            DeleteById($('.btn_del_cinema'), 'hallCinema');
        });
    </script>


@endsection
