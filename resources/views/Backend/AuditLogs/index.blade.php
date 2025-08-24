<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Your custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>
    <!-- Layout content -->
 <div class="container-fluid px-4">
        <h1 class="mt-4">Audit Logs</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Audit Logs</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-history me-1"></i>
                    System Activity Logs
                </div>
                <div>
                    <a href="{{ route('audit-logs.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-filter me-1"></i> Filters
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('audit-logs.index') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="table" class="form-label">Table</label>
                                        <select name="table" id="table" class="form-select">
                                            <option value="">All Tables</option>
                                            @foreach($tables as $table)
                                                <option value="{{ $table }}" {{ request('table') == $table ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $table)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="action" class="form-label">Action</label>
                                        <select name="action" id="action" class="form-select">
                                            <option value="">All Actions</option>
                                            @foreach($actions as $action)
                                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                                    {{ ucfirst(strtolower($action)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="date_from" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="date_from" name="date_from"
                                            value="{{ request('date_from') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="date_to" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="date_to" name="date_to"
                                            value="{{ request('date_to') }}">
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                                        <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logs Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Table</th>
                                <th>Action</th>
                                <th>Record ID</th>
                                <th>Timestamp</th>
                                <th>IP Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auditLogs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>
                                        @if($log->user)
                                            {{ $log->user->name }}
                                        @else
                                            <span class="text-muted">Unknown User</span>
                                        @endif
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $log->table_name)) }}</td>
                                    <td>
                                        @if($log->action == 'CREATE')
                                            <span class="badge bg-success">{{ $log->formatted_action }}</span>
                                        @elseif($log->action == 'UPDATE')
                                            <span class="badge bg-warning">{{ $log->formatted_action }}</span>
                                        @elseif($log->action == 'DELETE')
                                            <span class="badge bg-danger">{{ $log->formatted_action }}</span>
                                        @else
                                            <span class="badge bg-info">{{ $log->formatted_action }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $log->record_id }}</td>
                                    <td>{{ $log->timestamp->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td>
                                        <a href="{{ route('audit-logs.show', $log->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No audit logs found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $auditLogs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
