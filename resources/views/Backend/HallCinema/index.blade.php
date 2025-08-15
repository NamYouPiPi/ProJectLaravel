@extends('Backend.layouts.app')
@section('content')
@section('title', 'hallLocation')


    {{-- ================== Toast notifications =======================--}}
       @include('Backend.components.Toast')
    {{-- ======================= end of toast notifications ========================= --}}

    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="hall_location" title="Add New hall_location">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New Inventroy
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}


        {{-- ===================== display data on table ===========================--}}
    </div>

    <table id="example" class="display table table-responsive table-hover  " style="width:100%">
        <thead>
            <tr class="text-center ">
                <th>Id</th>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Country</th>
                <th>Postal Code</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Create_at</th>
                <th>Update_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hallocation as $hall)

                <tr class="text-center genre-row{{$hall->id}}">
                    <td>{{ $hall->id}}</td>
                    <td>{{$hall->name}}</td>
                    <td>{{$hall->address}}</td>
                    <td>{{$hall->city}}</td>
                    <td>{{$hall->state}}</td>
                    <td>{{$hall->country}}</td>
                    <td>{{$hall->postal_code}}</td>
                    <td>{{$hall->phone}}</td>
                    <td>{{$hall->status}}</td>
                    <td>{{ $hall->created_at->format("d/m/Y") }}</td>
                    <td>{{ $hall->updated_at->format("d/m/Y") }}</td>
                    <td class="d-flex gap-2">
                        <x-update-modal dataTable="hall_location" title="Edit hall_location">
                            <button type="button" class="btn btn-success btn_update_hall" data-id="{{ $hall->id}}"
                                data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                            </button>
                        </x-update-modal>

                        <x-delete-modal dataTable="hall_location" title="Delete hall_location">
                            <button type="button" class="btn btn-danger btn_del_hall" data-id="{{ $hall->id}}"
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
        {{-- {{ $inventories->links() }}--}}
    </div>
    {{-- ---------- end of paginate ------------}}

    {{-- ------------ add file ajax ---------------}}

    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>
        $(document).ready(function () {
            EditById($('.btn_update_hall'), 'hall_locations');
            DeleteById($('.btn_del_hall'), 'hall_locations');
        });
    </script>


    <script>
        $(document).ready(function () {
            // Initialize and show toasts
            $('.toast').each(function () {
                var toast = new bootstrap.Toast(this, {
                    autohide: true,
                    delay: 1000 // Auto hide after 5 seconds
                });
                toast.show();
            });
        });
    </script>
@endsection
