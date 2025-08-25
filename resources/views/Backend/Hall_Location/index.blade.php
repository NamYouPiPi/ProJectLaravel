@extends('Backend.layouts.app')
@section('content')
@section('title', 'Hall Locations')

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

        /* .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        } */

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
        }

        /* .filter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        } */



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

        /* Make entire card clickable */
        .location-card {
            transition: transform 0.2s;
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .location-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Table row hover effect */
        /* #tableContainer tbody tr {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #tableContainer tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
        } */

        /* Add ripple effect for better click feedback */
        /* .ripple {
            position: relative;
            overflow: hidden;
            transform: translate3d(0, 0, 0);
        }

        .ripple:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }

        .ripple:active:after {
            transform: scale(0, 0);
            opacity: .3;
            transition: 0s;
        }

        Prevent action buttons from triggering card click */
        /* .card-footer .btn {
            position: relative;
            z-index: 10;
        } */
    </style>

    {{-- Dashboard Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">📍 Total Locations</h5>
                    <div class="stats-number">{{ $totalLocations }}</div>
                    <p class="card-text">All registered locations</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">✅ Active Locations</h5>
                    <div class="stats-number">{{ $activeLocations }}</div>
                    <p class="card-text">Currently operational</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">❌ Inactive Locations</h5>
                    <div class="stats-number">{{ $inactiveLocations }}</div>
                    <p class="card-text">Temporarily closed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-white" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
                <div class="card-body text-center">
                    <h5 class="card-title">🎬 Total Cinemas</h5>
                    <div class="stats-number">{{ $totalCinemas }}</div>
                    <p class="card-text">Cinema halls across locations</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="filter-section">

        <form method="GET" action="{{ route('hall_locations.index') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search by Name/Address</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Search location name, address...">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status">
                        <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="city" class="form-label">City</label>
                    <select class="form-select" name="city" id="city">
                        <option value="all" {{ request('city') === 'all' ? 'selected' : '' }}>All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="state" class="form-label">State</label>
                    <select class="form-select" name="state" id="state">
                        <option value="all" {{ request('state') === 'all' ? 'selected' : '' }}>All States</option>
                        @foreach($states as $state)
                            <option value="{{ $state }}" {{ request('state') === $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" name="country" id="country">
                        <option value="all" {{ request('country') === 'all' ? 'selected' : '' }}>All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('country') === $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-light">
                            🔍
                        </button>
                        <a href="{{ route('hall_locations.index') }}" class="btn btn-outline-light">
                            🔄
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="m-4 d-flex justify-content-between">
        {{-- ==================== begin button add new ========================--}}
        <x-create_modal dataTable="hall_location" title="Add New Location">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                📍 Add New Location
            </button>
        </x-create_modal>
        {{--================================= end of button add new ==========================--}}

        {{-- Quick Actions --}}
        <div class="d-flex gap-2">
            <button class="btn btn-info btn-sm" id="analyticsBtn">📊 Analytics</button>
            <button class="btn btn-success btn-sm" id="exportBtn">📥 Export</button>
            <div class="text-muted align-self-center">
                Showing {{ $hallocation->firstItem() ?? 0 }} to {{ $hallocation->lastItem() ?? 0 }} of
                {{ $hallocation->total() }} results
            </div>
        </div>
    </div>

    {{-- Card-based layout for better visual presentation --}}
    <div class="row" id="cardViewContainer">
        @forelse($hallocation as $hall)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card location-card h-100 ripple" data-id="{{ $hall->id }}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">{{ $hall->name }}</h6>
                        @if($hall->status === 'active')
                            <span class="status-badge status-active">✓ Active</span>
                        @else
                            <span class="status-badge status-inactive">✗ Inactive</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">📍 Address:</small><br>
                            <strong>{{ $hall->address }}</strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">🏙️ Location:</small><br>
                            {{ $hall->city }}{{ $hall->state ? ', ' . $hall->state : '' }}{{ $hall->country ? ', ' . $hall->country : '' }}
                        </div>
                        @if($hall->postal_code)
                            <div class="mb-2">
                                <small class="text-muted">📮 Postal Code:</small>
                                <span class="badge bg-secondary">{{ $hall->postal_code }}</span>
                            </div>
                        @endif
                        <div class="mb-2">
                            <small class="text-muted">📞 Phone:</small><br>
                            <a href="tel:{{ $hall->phone }}" class="text-decoration-none">{{ $hall->phone }}</a>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">🎬 Cinema Halls:</small>
                            <span class="halls-count-badge">{{ $hall->hall_cinema_count ?? 0 }} halls</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">📅 Created:</small>
                            <span class="badge bg-light text-dark">{{ $hall->created_at->format("d/m/Y") }}</span>
                        </div>
                    </div>
                    <div class="card-footer d-flex gap-2 justify-content-center">
                        <button class="btn btn-sm btn-outline-info location-details-btn"
                            data-id="{{ $hall->id }}">detail</button>
                        <x-update-modal dataTable="hall_location" title="Edit Location">
                            <button type="button" class="btn btn-sm btn-outline-primary btn_update_hall"
                                data-id="{{ $hall->id}}" data-bs-toggle="modal" data-bs-target="#updateModal">edit</button>
                        </x-update-modal>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="event.stopPropagation(); confirmDelete({{ $hall->id }}, 'hall_locations')">
                            del
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                            <h5>No locations found</h5>
                            <p>Try adjusting your search or filter criteria, or add a new location.</p>
                            <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#createModal">
                                📍 Add First Location
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Alternative Table View Toggle --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" id="cardView">📱 Card View</button>
            <button type="button" class="btn btn-outline-primary" id="tableView">📋 Table View</button>
        </div>
    </div>

    {{-- Traditional Table View (initially hidden) --}}
    <div class="card shadow d-none" id="tableContainer">
        <div class="card-body">
            <table class="table table-responsive table-hover">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Phone</th>
                        <th>Halls</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hallocation as $hall)
                        <tr class="text-center location-row" data-id="{{ $hall->id }}">
                            <td><strong>{{ $hall->name }}</strong></td>
                            <td>{{ $hall->address }}</td>
                            <td>{{ $hall->city }}</td>
                            <td>{{ $hall->state ?? 'N/A' }}</td>
                            <td>{{ $hall->country ?? 'N/A' }}</td>
                            <td>{{ $hall->phone }}</td>
                            <td><span class="halls-count-badge">{{ $hall->hall_cinema_count ?? 0 }}</span></td>
                            <td>
                                @if($hall->status == 'active')
                                    <span class="status-badge status-active">✓ Active</span>
                                @else
                                    <span class="status-badge status-inactive">✗ Inactive</span>
                                @endif
                            </td>
                            <td>{{ $hall->created_at->format("d/m/Y") }}</td>
                            <td class="d-flex gap-1 justify-content-center">
                                <button class="btn btn-sm btn-outline-info location-details-btn"
                                    data-id="{{ $hall->id }}">detail</button>
                                <x-update-modal dataTable="hall_location" title="Edit Location">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn_update_hall"
                                        data-id="{{ $hall->id}}" data-bs-toggle="modal"
                                        data-bs-target="#updateModal">edit</button>
                                </x-update-modal>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="event.stopPropagation(); confirmDelete({{ $hall->id }}, 'hall_locations')">
                                    del
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    {{-- ========== paginate ----------------}}
    <div class="d-flex justify-content-between align-items-center m-4">
        <div class="text-muted">
            Showing {{ $hallocation->firstItem() ?? 0 }} to {{ $hallocation->lastItem() ?? 0 }} of
            {{ $hallocation->total() }} results
        </div>
        {{ $hallocation->appends(request()->query())->links() }}
    </div>
    {{-- ---------- end of paginate ------------}}



    {{-- ------------ add file ajax ---------------}}
    <script src="{{ asset('js/ajax.js')}}"></script>

    <script >
      $(document).ready(function() {
                    EditById($('.btn_update_hall'), 'hall_locations');
      });
    </script>

@endsection
