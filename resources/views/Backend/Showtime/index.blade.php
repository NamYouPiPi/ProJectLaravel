@extends('Backend.layouts.app')
{{-- ============ add title and active =======================--}}
@section('title', 'showtime')
@section('showtime', 'active')
{{-- @section('menu-open', 'menu-open') --}}
@section('content')

    {{--================= end of add title and active ==============--}}



    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')
    <x-create_modal dataTable="showTimes" title="Add New showTimes">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle"></i> Add Showtimes
        </button>
    </x-create_modal>


    {{-- ================ Table for Suppliers detail all ===================== --}}
    <div class="table-responsive">

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Movie</th>
                    <th>Hall</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Base Price</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($showtimes as $index => $showtime)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $showtime->movie->title ?? 'N/A' }}</td>
                        <td>{{ $showtime->hall->cinema_name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d M Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($showtime->end_time)->format('d M Y H:i') }}</td>
                        <td>${{ number_format($showtime->base_price, 2) }}</td>
                        <td>
                             @php
                             if ($showtime->status == 'upcoming')
                                 $badge='info';
                             elseif ($showtime->status == 'ongoing')
                                $badge= 'success';
                             else
                                 $badge = 'secondary'

                            @endphp
                            <span class="badge bg-{{$badge}}">{{$showtime->status}}</span>
                        </td>


                        {{-- Active/Inactive (Admin Control) --}}
                        <td>
                            @if($showtime->is_active)
                                <span class="badge bg-primary">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        {{-- Actions --}}

                        <td class="d-flex gap-1">
                            <x-update-modal dataTable="showTimes" title="update showTimes">
                                <button type="button" class="btn btn-outline-primary btnEditInventory" data-id="{{$showtime->id}}"
                                    data-bs-toggle="modal" data-bs-target="#updateModal"><i class="bi bi-pencil"></i>
                                </button>
                            </x-update-modal>

                           <button type="button" class="btn btn-outline-danger"
                                    onclick="confirmDelete({{ $showtime->id }}, 'Showtime')">
                                    <i class="bi bi-trash3"></i>
                                </button>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No showtimes found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $showtimes->links() }}
        </div>
    </div>




    <Script src="{{ asset('js/ajax.js')}}"></Script>
    <script>
        $(document).ready(function () {
            // DeleteById($('.btnDelShowtime'), 'Showtime');
            EditById($('.btn_edit_showtime'), 'Showtime');
        });
    </script>


@endsection
