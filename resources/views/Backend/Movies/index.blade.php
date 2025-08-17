@extends('Backend.layouts.app')
@section('content')
@section('title', 'Movies')
@section('movies', 'active')
@section('menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    {{-- ======================= end of check message ========================= --}}

    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="movies" title="Add New Movie">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                Add New Movie
            </button>
        </x-create_modal>

        <input type="text" name="search" id="search" placeholder="Search Movies...">


        {{--================================= end of button add new ==========================--}}
    </div>

    {{-- ===================== display data on table ===========================--}}
    <table id="example" class="display table table-responsive table-hover" style="width:100%">
        <thead>
            <tr class="text-center">
                {{-- <th>Id</th> --}}
                <th>Title</th>
                <th>Duration(min)</th>
                <th>Director</th>
                <th>Description</th>
                <th>Language</th>
                <th>Poster</th>
                <th>Trailer</th>
                <th>Status</th>
                <th>Release</th>
                <th>Genre</th>
                <th>Classification</th>
                <th>Supplier</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($movies as $movie)
                <tr class="text-center" id="movie{{$movie->id}}">
                    {{-- <td>{{$movie->id}}</td> --}}
                    <td>{{$movie->title}}</td>
                    <td>{{$movie->duration_minutes}}(mn)</td>
                    <td>{{$movie->director}}</td>
                    <td>{{Str::limit($movie->description, 50)}}</td>
                    <td>{{$movie->language}}</td>
                    <td>
                        @if($movie->poster)
                            <img src="{{config('app.image_base_url')}}{{$movie->poster}}" alt="Poster" class="rounded img-fluid"
                                style="width: 40px; height: 40px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @if($movie->trailer)
                            <a href="{{Storage::url($movie->trailer)}}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-play"></i> Watch
                            </a>
                        @else
                            No Trailer
                        @endif
                    </td>
                    <td>
                        <span class="badge {{$movie->status == 'active' ? ' text-bg-primary' : 'text-bg-danger'}}">
                            {{ucfirst($movie->status)}}
                        </span>
                    </td>
                    <td>{{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y/m/d') : 'N/A' }}</td>
                    <td>{{$movie->genre->main_genre ?? 'N/A'}}</td>
                    <td>{{$movie->classification->code ?? 'N/A'}}</td>
                    <td>{{$movie->supplier->name ?? 'N/A'}}</td>
                    <td>{{ $movie->created_at->format("Y/m/d") }}</td>
                    <td>{{ $movie->updated_at->format("Y/m/d") }}</td>
                    <td class="d-flex gap-1">
                        <x-update-modal dataTable="movies" title="Update movies">
                            <button type="button" class="btn btn-success btnEditMovie" data-id="{{$movie->id}}"
                                data-bs-toggle="modal" data-bs-target="#updateModal">UPDATE
                            </button>
                        </x-update-modal>

                        <x-delete-modal dataTable="movies" title="Delete Movie">
                            <button type="button" class="btn btn-danger btnDeleteMovie" data-id="{{ $movie->id}}"
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
        {{ $movies->links() }}
    </div>
    {{-- ---------- end of paginate ------------}}

    {{-- ------------ add file ajax ---------------}}

    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>
        $(document).ready(function () {
            DeleteById($('.btnDeleteMovie'), 'movies')
            // EditById($('.btnEditMovie'), 'movies')
            EditById($('.btnEditMovie'), 'movies');
        });
    </script>

@endsection
