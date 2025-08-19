@extends('Backend.layouts.app')
@section('content')
@section('title', 'Hall Cinema')

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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    .hall-type-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .type-standard { background-color: #e3f2fd; color: #1976d2; }
    .type-vip { background-color: #fce4ec; color: #c2185b; }
    .type-imax { background-color: #f3e5f5; color: #7b1fa2; }
    .type-4dx { background-color: #e8f5e8; color: #388e3c; }
    .type-3d { background-color: #fff3e0; color: #f57c00; }
    .type-dolby_atmos { background-color: #e1f5fe; color: #0277bd; }
    .type-premium { background-color: #ffeaa7; color: #d63031; }
    .type-outdoor { background-color: #d1ecf1; color: #17a2b8; }
    .type-private { background-color: #f8d7da; color: #721c24; }
</style>

{{-- Dashboard Cards --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-center">
                <h5 class="card-title">Total Halls</h5>
                <div class="stats-number">{{ $totalHalls }}</div>
                <p class="card-text">All cinema halls</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="card-body text-center">
                <h5 class="card-title">Active Halls</h5>
                <div class="stats-number">{{ $activeHalls }}</div>
                <p class="card-text">Currently active</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card text-white" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
            <div class="card-body text-center">
                <h5 class="card-title">Inactive Halls</h5>
                <div class="stats-number">{{ $inactiveHalls }}</div>
                <p class="card-text">Currently inactive</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card text-white" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
            <div class="card-body text-center">
                <h5 class="card-title">Total Seats</h5>
                <div class="stats-number">{{ number_format($totalSeats) }}</div>
                <p class="card-text">Available seats</p>
            </div>
        </div>
    </div>
</div>

{{-- Filter Section --}}
<div class="filter-section">
    <h5 class="mb-3">🎬 Search & Filter Cinema Halls</h5>
    <form method="GET" action="{{ route('hallCinema.index') }}" id="filterForm">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search by Name/Location</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Search cinema or location...">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' || !request('status') ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
{{--            <div class="col-md-2">--}}
{{--                <label for="hall_type" class="form-label">Hall Type</label>--}}
{{--                <select class="form-select" name="hall_type" id="hall_type">--}}
{{--                    <option value="all" {{ request('hall_type') == 'all' ? 'selected' : '' }}>All Types</option>--}}
{{--                    @foreach($hallTypes as $type)--}}
{{--                        <option value="{{ $type }}" {{ request('hall_type') == $type ? 'selected' : '' }}>--}}
{{--                            {{ ucfirst(str_replace('_', ' ', $type)) }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
            <div class="col-md-3">
                <label for="location" class="form-label">Location</label>
                <select class="form-select" name="location" id="location">
                    <option value="all" {{ request('location') == 'all' ? 'selected' : '' }}>All Locations</option>
                    @foreach($hall_location as $location)
                        <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="d-grid gap-2 w-100">

                    <a href="{{ route('hallCinema.index') }}" class="btn btn-dark">
                        🔄 Reset
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="hall_cinema" title="Add New Hall Cinema" :hall_location="$hall_location">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                🎬 Add New Cinema Hall
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}

        {{-- Results info --}}
        <div class="text-muted">
            Showing {{ $hall_cinema->firstItem() ?? 0 }} to {{ $hall_cinema->lastItem() ?? 0 }} of {{ $hall_cinema->total() }} results
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table id="example" class="display table table-responsive table-hover" style="width:100%">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Cinema Hall Name</th>
                        <th>Location</th>
                        <th>Hall Type</th>
                        <th>Total Seats</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hall_cinema as $hall_cinemas)
                        <tr class="text-center">
                            <td><strong>{{ $hall_cinemas->cinema_name }}</strong></td>
                            <td>
                                <div>
                                    <strong>{{ $hall_cinemas->hall_location->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $hall_cinemas->hall_location->city ?? '' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="hall-type-badge type-{{ $hall_cinemas->hall_type }}">
                                    {{ ucfirst(str_replace('_', ' ', $hall_cinemas->hall_type)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ number_format($hall_cinemas->total_seats) }} seats</span>
                            </td>
                            <td>
                                @if($hall_cinemas->status == 'active')
                                    <span class="status-badge status-active">✓ Active</span>
                                @else
                                    <span class="status-badge status-inactive">✗ Inactive</span>
                                @endif
                            </td>
                            <td>{{ $hall_cinemas->created_at->format("d/m/Y") }}</td>
                            <td>{{ $hall_cinemas->updated_at->format("d/m/Y") }}</td>
                            <td class="d-flex gap-2 justify-content-center">
                                <x-update-modal dataTable="hallCinema" title="Edit Hall Cinema">
                                    <button type="button" class="btn btn-sm btn-success btn_edit_cinema" data-id="{{ $hall_cinemas->id}}"
                                        data-bs-toggle="modal" data-bs-target="#updateModal">
                                        ✏️ Edit
                                    </button>
                                    </x-update-modal>
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="confirmDelete({{ $hall_cinemas->id }}, 'hallCinema')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-film fa-3x mb-3"></i>
                                    <h5>No cinema halls found</h5>
                                    <p>Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- ========== paginate ----------------}}
    <div class="d-flex justify-content-center mt-4">
        {{ $hall_cinema->appends(request()->query())->links() }}
    </div>
    {{-- ---------- end of paginate ------------}}

    {{-- ------------ add file ajax ---------------}}
    <script src="{{ asset('js/ajax.js')}}"></script>

    <script>
        $(document).ready(function () {
            EditById($('.btn_edit_cinema'), 'hallCinema');
            DeleteById($('.btn_del_cinema'), 'hallCinema');

            // Debounced search functionality
            let searchTimeout;
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    $('#filterForm').submit();
                }, 500);
            });

            // Auto-submit on filter change
            $('#status, #hall_type, #location').on('change', function() {
                $('#filterForm').submit();
            });

            // Initialize DataTable if needed (disable built-in features since we're using Laravel pagination)
            if (typeof $('#example').DataTable === 'function') {
                $('#example').DataTable({
                    "paging": false,
                    "searching": false,
                    "info": false,
                    "ordering": true,
                    "order": [[ 5, "desc" ]]
                });
            }

            // Quick search functionality via AJAX
            $('#search').on('keyup', function() {
                let query = $(this).val();
                if (query.length >= 3) {
                    $.ajax({
                        url: "{{ route('hallCinema.search') }}",
                        method: 'GET',
                        data: { search: query },
                        success: function(response) {
                            // You can implement a dropdown suggestion here if needed
                            console.log('Search results:', response.data);
                        }
                    });
                }
            });

            // Analytics button (if you want to add one)
            $('#analyticsBtn').on('click', function() {
                $.ajax({
                    url: "{{ route('hallCinema.analytics') }}",
                    method: 'GET',
                    success: function(response) {
                        console.log('Analytics data:', response);
                        // Display analytics in a modal or separate section
                    }
                });
            });
        });
    </script>

@endsection
