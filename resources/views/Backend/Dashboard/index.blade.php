@extends('Backend.Layouts.app')
@section('content')
@section('title', 'Dashboard')
@section('dashboard', 'active')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <!-- Bookings This Month -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Bookings (This Month)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $bookingsThisMonth ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bookings Last Month -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Bookings (Last Month)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $bookingsLastMonth ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar2-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking Growth -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Booking Growth
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $bookingGrowth ?? 0 }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-graph-up-arrow fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Processed Payments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Processed Payments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($processedPayments ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-stack fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Row -->
    <div class="row">
        <!-- Revenue This Month -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Revenue (This Month)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($revenueThisMonth ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Revenue Last Month -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Revenue (Last Month)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($revenueLastMonth ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-exchange fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Growth -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Revenue Growth
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $revenueGrowth ?? 0 }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-bar-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 {{-- filepath: resources/views/Backend/Dashboard/index.blade.php --}}
<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>#</th>
            <th>Booking Reference</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Paid At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($payments ?? [] as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <a href="{{ route('bookings.show', $payment->id) }}">
                        {{ $payment->booking_reference }}
                    </a>
                </td>
                <td>{{ $payment->customer->name ?? '-' }}</td>
                <td>${{ number_format($payment->total_price, 2) }}</td>
                <td>
                    @if($payment->status === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                    @endif
                </td>
                <td>{{ $payment->updated_at ? $payment->updated_at->format('Y-m-d H:i') : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No payment records found</td>
            </tr>
        @endforelse
    </tbody>
</table>
    {{-- ... (rest of your dashboard content: charts, tables, etc.) ... --}}
</div>
@endsection
