@extends('Backend.layouts.app')
@section('title', 'inventory')
@section('inventory', 'active')
{{--@section('menu-open', 'menu-open')--}}
@section('content')

    {{-- ================== check message add and update if succeed =======================--}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            })
        </script>
    @endif

    @if(session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ session('warning') }}",
            })
        </script>
    @endif



    {{-- ======================= end of check messange ========================= --}}

    <x-create_modal dataTable="seats" title="Add New Seats">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus"></i> Add Supplier
        </button>
    </x-create_modal>

    {{-- Table Section --}}
    <div class="card">
        <div class="card-body">
            <table id="example" class="display table table-responsive table-hover" style="width:100%">
                <thead>
                    <tr class="text-center ">
                        {{-- <th>Id</th>--}}
                        <th>Hall Name</th>
                        <th>SeatsTpye</th>
                        <th>Price</th>
                        <th>Seat number</th>
                        <th>Seat row</th>
                        <th>Status</th>
                        <th>Create_at</th>
                        <th>Update_at</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach($Seats as $seat)
                        <tr>
                            <td>{{$seat->hall->cinema_name}}</td>
                            <td>{{$seat->seatType->name}}</td>
                            <td>{{$seat->seatType->price}}$</td>
                            <td>{{$seat->seat_number}}</td>
                            <td>{{$seat->seat_row}}</td>
                            <td>{{$seat->status}}</td>
                            <td>
                                @if($seat->created_at)
                                    {{ $seat->created_at->format('Y-m-d H:i:s') }}
                                @else
                                    N/A
                                @endif

                            </td>
                            <td>
                                @if($seat->updated_at)
                                    {{ $seat->updated_at->format('Y-m-d H:i:s') }}`

                                @else
                                    N/A
                                @endif

                            </td>
                            <td class="d-flex gap-2 justify-content-center">
                                <x-update-modal dataTable="seats" title="Update Seats">
                                    <button type="button" class="btn btn-warning btnupdateseat" data-id="{{ $seat->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </x-update-modal>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="confirmDelete({{ $seat->id }}, 'seats')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    </div>

    @include('Backend.components.alert')
    {{-- Scripts --}}
    <script src="{{ asset('js/ajax.js')}}"></script>
    {{--
    <script src="{{ asset('js/inventory-filter.js')}}"></script>--}}
    <script>
        // Run SweetAlert notifications after page loads


        function EditById(btnEdit, Base_url) {
            btnEdit.on("click", function () {
                let id = $(this).data("id");

                // Open modal
                $("#updateModal").modal("show");

                // Load form via AJAX
                $.ajax({
                    url: `/${Base_url}/` + id + "/edit",
                    type: "GET",
                    success: function (response) {
                        $("#updateModal .modal-body").html(response); // insert form
                    },
                    error: function () {
                        $("#updateModal .modal-body").html("<p class='text-danger'>Error loading form</p>");
                    }
                });
            });

            // Submit update form
            $(document).on("submit", "#updateForm", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                let id = $("input[name='id']").val();

                $.ajax({
                    url: `/${Base_url}/` + id,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        $("#updateModal").modal("hide");
                        toastr.success("Updated successfully!");
                        $("#example").load(location.href + " #example"); // reload table only
                    },
                    error: function () {
                        toastr.error("Update failed!");
                    }
                });
            });
        }
    </script>
@endsection