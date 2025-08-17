@extends('Backend.layouts.app')
@section('content')
    @section('title', 'genre')
    @section('inventory', 'active')
    @section('menu-open', 'menu-open')
    {{-- ================== Toast notifications =======================--}}
    @include('Backend.components.Toast')
    {{-- ======================= end of toast notifications ========================= --}}

    <style>
        .stats-card {
            transition: transform 0.2s;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
        }
        .filter-section {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn-gradient {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
        }
        .btn-gradient:hover {
            background: linear-gradient(45deg, #764ba2, #667eea);
            color: white;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .status-active {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        .status-inactive {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
        }
    </style>

    {{-- Dashboard Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Genres</h5>
                    <div class="stats-number">{{ $totalGenres }}</div>
                    <p class="card-text">All registered genres</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">Active Genres</h5>
                    <div class="stats-number">{{ $activeGenres }}</div>
                    <p class="card-text">Currently active</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">Inactive Genres</h5>
                    <div class="stats-number">{{ $inactiveGenres }}</div>
                    <p class="card-text">Currently inactive</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="filter-section">
             {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="genre" title="Add New Genre">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                ➕ Add New Genre
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}


            <div>



                <form method="GET" action="{{ route('genre.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search by Name</label>
                            <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Search main or sub genre...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Filter by Category</label>
                            <select class="form-select" name="category" id="category">
                                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Sub Genre </option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Filter by Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">

                            <a href="{{ route('genre.index') }}" class="btn">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



            <div class="card shadow">
                <div class="card-body">
                    <table id="example" class="display table table-responsive table-hover" style="width:100%">
                        <thead class="table-dark">
                        <tr class="text-center">
                           <th>Main Genre</th>
                            <th>Sub Genre</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($genres as $genre)
                            <tr class="text-center genre-row{{$genre->id}}">
                                <td><strong>{{$genre->main_genre}}</strong></td>
                                <td>{{$genre->sub_genre}}</td>
                                <td>{{$genre->description ?? 'No description'}}</td>
                                <td>
                                    @if($genre->status == 'active')
                                        <span class="status-badge status-active">✓ Active</span>
                                    @else
                                        <span class="status-badge status-inactive">✗ Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $genre->created_at->format("d/m/Y") }}</td>
                                <td>{{ $genre->updated_at->format("d/m/Y") }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <x-update-modal dataTable="genre" title="Edit Genre">
                                        <button type="button" class="btn btn-sm btn-success btn_update_genre" data-id="{{ $genre->id}}"
                                                data-bs-toggle="modal" data-bs-target="#updateModal">
                                            ✏️ Edit
                                        </button>
                                    </x-update-modal>

                                    <x-delete-modal dataTable="genre" title="Delete Genre">
                                        <button type="button" class="btn btn-sm btn-danger btn_delete_genre" data-id="{{ $genre->id}}"
                                                data-bs-toggle="modal" data-bs-target="#deletemodal">
                                            🗑️ Delete
                                        </button>
                                    </x-delete-modal>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>No genres found</h5>
                                        <p>Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- --------------- end of display data --------------------------}}




            {{-- ========== paginate ----------------}}
<div class="d-flex justify-content-between align-items-center m-4">
    {{-- Results info --}}
        <div class="text-muted">
            Showing {{ $genres->firstItem() ?? 0 }} to {{ $genres->lastItem() ?? 0 }} of {{ $genres->total() }} results
        </div>

            {{ $genres->appends(request()->query())->links() }}

    </div>
            {{-- ---------- end of paginate ------------}}

            {{-- ------------ add file ajax ---------------}}
            <script src="{{ asset('js/ajax.js')}}"></script>

            <script>
                $(document).ready(function() {
                    EditById($('.btn_update_genre'), 'genre');
                    DeleteById($('.btn_delete_genre'), 'genre');

                    // Debounced search functionality
                    let searchTimeout;
                    $('#search').on('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(function() {
                            $('#filterForm').submit();
                        }, 500);
                    });

                    // Auto-submit on filter change
                    $('#category, #status').on('change', function() {
                        $('#filterForm').submit();
                    });

                    // Initialize DataTable if needed
                    if (typeof $('#example').DataTable === 'function') {
                        $('#example').DataTable({
                            "paging": false,
                            "searching": false,
                            "info": false,
                            "ordering": true,
                            "order": [[ 4, "desc" ]]
                        });
                    }
                });
            </script>
        @endsection
