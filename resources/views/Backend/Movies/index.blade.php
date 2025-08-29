@extends('Backend.layouts.app')
@section('content')
@section('title', 'Movies')
@section('movies', 'active')
@section('movies-menu-open', 'menu-open')

    {{-- ================== check message add and update if succeed =======================--}}
    @include('Backend.components.Toast')

    {{-- ======================= end of check message ========================= --}}


    <div class="m-4">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">


                {{-- Filters Section --}}
                <form action="{{ route('movies.index') }}" method="GET" id="filterForm"
                    class="d-flex align-items-center gap-3 ">
                    <div class="flex-grow-1">
                        <input type="text" name="search" class="form-control" placeholder="Search by title..." --}}
                            value="{{ request('search') }}">
                    </div>

                    {{-- Status Filter --}}
                    <div style="width: 150px;">
                        <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Genre Filter --}}
                    <div style="width: 150px;">
                        <select name="genre_id" class="form-select"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->main_genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Supplier Filter --}}
                    <div style="width: 150px;">
                        <select name="supplier_id" class="form-select"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : ''
                                                                                }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    {{-- {{-- Clear Filters --}}
                    <div>
                        <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='{{ route('movies.index') }}'">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </form>
                <div class="float-end">
                    <x-create_modal dataTable="movies" title="Add New Movie">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="fas fa-plus"></i> Add New Movie
                        </button>
                    </x-create_modal>
                </div>

            </div>

        </div>
    </div>


    {{-- ===================== display data on table ===========================--}}
    {{-- Movies Title and Count --}}

    {{-- Table --}}
    <table id="example" class="table table-striped  align-middle text-center table-hover" style="width:100%">
        <thead class="table-dark">
            <tr>
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
                {{-- <th>Updated At</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr id="movie{{$movie->id}}">
                    <td class="text-muted">{{$movie->title}}</td>
                    <td class="text-muted">{{$movie->duration_minutes}}(mn)</td>
                    <td class="text-muted">{{$movie->director}}</td>
                    <td class="text-muted">{{Str::limit($movie->description, 50)}}</td>
                    <td class="text-muted">{{$movie->language}}</td>
                    <td class="text-muted">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" class="img-fluid"
                                style="width: 40px; height: 40px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @if($movie->trailer)
                            <a href="{{$movie->trailer}}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-play"></i> Watch
                            </a>
                        @else
                            No Trailer
                        @endif
                    </td>
                    <td>
                        <span class="badge {{$movie->status == 'active' ? 'bg-primary' : 'bg-danger'}}">
                            {{ucfirst($movie->status)}}
                        </span>
                    </td>
                    <td>{{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y/m/d') : 'N/A' }}</td>
                    <td><span class="badge text-bg-success">{{$movie->genre->main_genre ?? 'N/A'}}</span></td>
                    <td><span class="badge text-bg-warning"> {{$movie->classification->code ?? 'N/A'}}</span></td>

                    <td class="text-info-emphasis">{{$movie->supplier->name ?? 'N/A'}}</td>
                    <td>{{ $movie->created_at->format("Y/m/d") }}</td>
                    {{-- <td>{{ $movie->updated_at->format("Y/m/d") }}</td> --}}
                    <td class="d-flex gap-2">
                        <x-update-modal dataTable="movies" title=" movies">
                            <button type="button" dataTable="movies" class="btn-outline-primary btn btnEditMovie btn-sm"
                                data-id="{{$movie->id}}" data-modal-title="UPDATE MOVIES" data-bs-toggle="modal"
                                data-bs-target="#updateModal">Edit
                            </button>
                        </x-update-modal>
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            onclick="confirmDelete({{ $movie->id }}, 'movies')">
                            del
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Optional: Custom Table Style --}}
    <style>
        #example th,
        #example td {
            vertical-align: middle;
        }

        #example img {
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
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
            EditById($('.btnEditMovie'), 'movies');
        });
    </script>
    </div>
@endsection
