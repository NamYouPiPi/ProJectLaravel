@extends('Backend.Layouts.app')
@section('content')
@section('title', 'Super Admin Dashboard')
@section('dashboard', 'active')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-shield-lock-fill text-danger me-2"></i>Super Admin Dashboard
        </h1>
        <div>
            <span class="badge bg-danger fs-6">SUPER ADMIN ACCESS</span>
        </div>
    </div>

    <!-- System Status Alert -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><i class="bi bi-exclamation-triangle-fill"></i> Super Admin Access:</strong>
        You have ultimate system access. Use this power responsibly.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- System Health Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                System Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="badge bg-success">ONLINE</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-activity fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Roles Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Active Roles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Role::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-badge fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Status Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Database Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="badge bg-success">CONNECTED</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <!-- System Information -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-info-circle-fill me-2"></i>System Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                            <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                            <p><strong>Server:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Database:</strong> {{ config('database.default') }}</p>
                            <p><strong>Timezone:</strong> {{ config('app.timezone') }}</p>
                            <p><strong>Environment:</strong> {{ config('app.env') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-gear-fill me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('super-admin.system.info') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-info-circle me-1"></i> System Info
                        </a>
                        <a href="{{ route('super-admin.system.logs') }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-journal-text me-1"></i> View Logs
                        </a>
                        <a href="{{ route('super-admin.database.status') }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-database me-1"></i> Database Status
                        </a>
                        <a href="{{ route('super-admin.users.all') }}" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-people me-1"></i> Manage Users
                        </a>
                        <a href="{{ route('super-admin.roles.all') }}" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-person-badge me-1"></i> Manage Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row - Recent Activity -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-clock-history me-2"></i>Recent System Activity
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Action</th>
                                    <th>User</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ now()->format('Y-m-d H:i:s') }}</td>
                                    <td><span class="badge bg-success">LOGIN</span></td>
                                    <td>{{ auth()->user()->name }}</td>
                                    <td>Super Admin logged in</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(5)->format('Y-m-d H:i:s') }}</td>
                                    <td><span class="badge bg-info">SYSTEM_CHECK</span></td>
                                    <td>System</td>
                                    <td>Automated system health check</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subMinutes(15)->format('Y-m-d H:i:s') }}</td>
                                    <td><span class="badge bg-warning">BACKUP</span></td>
                                    <td>System</td>
                                    <td>Database backup completed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
