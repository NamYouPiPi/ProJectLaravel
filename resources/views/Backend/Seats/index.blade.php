@extends('Backend.layouts.app')
@section('title', 'seats')
@section('seat', 'active')
@section('seats-menu-open', 'menu-open')
@section('content')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('backend.components.toast')

    {{-- ======================= end of check messange ========================= --}}
    <div class="d-flex justify-content-between align-items-center p-2">
        <h4 class="m-3">Seats List</h4>
        <x-create_modal dataTable="seats" title="Add New Seats">
            <button type="button" class="btn btn-outline-success m-3 float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Add Seat
            </button>
        </x-create_modal>
    </div>

    {{-- Table Section --}}
    <div class="card p-2">
        <div class="card-body m-2">
            <table id="example" class="display table table-responsive table-hover" style="width:100% ">
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
                        {{-- <th>Update_at</th> --}}
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach($Seats as $seat)
                        <tr class="text-center">
                            <td>{{$seat->hall->cinema_name}} {{$seat->hall->total_seats}} </td>
                            <td>{{$seat->seatType->name}}</td>
                            <td>{{$seat->seatType->price}}$</td>
                            <td>{{$seat->seat_number}}</td>
                            <td>{{$seat->seat_row}}</td>
                            <td>
                                <span class="badge
                                        @if($seat->status == 'available') bg-primary
                                        @elseif($seat->status == 'booked') bg-success
                                        @elseif($seat->status == 'cancelled') bg-warning text-dark
                                        @elseif($seat->status == 'blocked') bg-danger
                                        @elseif($seat->status == 'broken') bg-secondary
                                        @else bg-light text-dark
                                        @endif
                                    ">
                                    {{ ucfirst($seat->status) }}
                                </span>
                            <td>
                                @if($seat->created_at)
                                    {{ $seat->created_at->format('Y-m-d H:i:s') }}
                                @else
                                    N/A
                                @endif

                            </td>
                            {{-- <td>
                                @if($seat->updated_at)
                                {{ $seat->updated_at->format('Y-m-d H:i:s') }}`

                                @else
                                N/A
                                @endif

                            </td> --}}
                            <td class="d-flex gap-2 justify-content-center">
                                <x-update-modal dataTable="seats" title="Update Seats">
                                    <button type="button" class="btn btn-outline-primary btn-sm btn_update_seat"
                                        data-id="{{ $seat->id }}">
                                        Edit
                                    </button>
                                </x-update-modal>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    onclick="confirmDelete({{ $seat->id }}, 'seats')">
                                    {{-- <i class="bi bi-trash3"></i> --}}
                                    del
                                </button>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-muted">
                Showing {{ $Seats->firstItem() ?? 0 }} to {{ $Seats->lastItem() ?? 0 }} of {{ $Seats->total() }} results
            </div>
            {{ $Seats->appends(request()->query())->links() }}
        </div>
    </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('js/ajax.js')}}"></script>
    <script>
        EditById($(".btn_update_seat"), "seats");
    </script>
@endsection
