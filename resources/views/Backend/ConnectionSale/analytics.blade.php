@extends('Backend.layouts.app')
@section('content')
@section('title', 'sale ')
@section('sale ', 'active')

    <style>
        body {
            background-color: #f8f9fa !important;
        }

        .content-wrapper {
            background-color: #f8f9fa !important;
        }

        .analytics-card {
            transition: transform 0.2s;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .analytics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .chart-container {
            position: relative;
            height: 350px;
            margin: 10px 0;
        }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 10px 0;
        }

        .trend-up {
            color: #ffffff;
        }

        .trend-down {
            color: #ffffff;
        }

        .comparison-text {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .analytics-main {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        canvas {
            background-color: white;
            border-radius: 10px;
        }
    </style>

    <div class="analytics-main">
        {{-- Header --}}
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0"><i class="fas fa-chart-line"></i> Sales Analytics Dashboard</h2>
                    <p class="mb-0 mt-2">Comprehensive sales performance overview</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('sale.index') }}" class="btn btn-light">
                        <i class="fas fa-list"></i> View Sales
                    </a>
                    <button class="btn btn-success" onclick="generateReport()">
                        <i class="fas fa-download"></i> Download Report
                    </button>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row mb-4">
            {{-- Current Month Sales --}}
            <div class="col-md-3">
                <div class="card analytics-card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-alt"></i> This Month
                        </h5>
                        <div class="stats-number">${{ number_format($currentMonthSales, 2) }}</div>
                        @php
                            $percentChange = $previousMonthSales > 0 ?
                                (($currentMonthSales - $previousMonthSales) / $previousMonthSales) * 100 : 0;
                        @endphp
                        <small class="comparison-text">
                            @if($percentChange >= 0)
                                <i class="fas fa-arrow-up trend-up"></i> {{ number_format($percentChange, 1) }}%
                            @else
                                <i class="fas fa-arrow-down trend-down"></i> {{ number_format(abs($percentChange), 1) }}%
                            @endif
                            vs last month
                        </small>
                    </div>
                </div>
            </div>

            {{-- Previous Month Sales --}}
            <div class="col-md-3">
                <div class="card analytics-card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-history"></i> Last Month
                        </h5>
                        <div class="stats-number">${{ number_format($previousMonthSales, 2) }}</div>
                        <small class="comparison-text">{{ $currentMonth->subMonth()->format('F Y') }}</small>
                    </div>
                </div>
            </div>

            {{-- Current Year Sales --}}
            <div class="col-md-3">
                <div class="card analytics-card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-chart-line"></i> This Year
                        </h5>
                        <div class="stats-number">${{ number_format($currentYearSales, 2) }}</div>
                        <small class="comparison-text">{{ date('Y') }} total sales</small>
                    </div>
                </div>
            </div>

            {{-- Average Daily Sales --}}
            <div class="col-md-3">
                <div class="card analytics-card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-day"></i> Daily Average
                        </h5>
                        @php
                            $daysInMonth = $currentMonth->daysInMonth;
                            $avgDaily = $daysInMonth > 0 ? $currentMonthSales / $daysInMonth : 0;
                        @endphp
                        <div class="stats-number">${{ number_format($avgDaily, 2) }}</div>
                        <small class="comparison-text">Average per day this month</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="row mb-4">
            {{-- Monthly Sales Chart --}}
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Monthly Sales Trend ({{ date('Y') }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daily Sales Chart --}}
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Daily Sales ({{ $currentMonth->format('F Y') }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Yearly Trend Chart --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-area"></i> Yearly Sales Trend</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="yearlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Selling Items --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Top Selling Items This Month</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Item Name</th>
                                        <th>Quantity Sold</th>
                                        <th>Total Revenue</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topSellingItems as $index => $item)
                                        @php
                                            $percentage = $currentMonthSales > 0 ? ($item->total_revenue / $currentMonthSales) * 100 : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    <i class="fas fa-trophy text-warning"></i> {{ $index + 1 }}
                                                @elseif($index == 1)
                                                    <i class="fas fa-medal text-secondary"></i> {{ $index + 1 }}
                                                @elseif($index == 2)
                                                    <i class="fas fa-medal text-warning"></i> {{ $index + 1 }}
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td><strong>{{ $item->item_name }}</strong></td>
                                            <td>{{ number_format($item->total_quantity) }}</td>
                                            <td>${{ number_format($item->total_revenue, 2) }}</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        {{ number_format($percentage, 1) }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                return;
            }

            // Default chart options
            const defaultOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            };

            // Monthly Sales Chart
            try {
                const monthlyCtx = document.getElementById('monthlyChart');
                if (monthlyCtx) {
                    const monthlyData = @json($monthlySales ?? []);
                    console.log('Monthly data:', monthlyData);

                    new Chart(monthlyCtx, {
                        type: 'line',
                        data: {
                            labels: monthlyData.map(item => {
                                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                return months[item.month - 1] || 'Unknown';
                            }),
                            datasets: [{
                                label: 'Monthly Sales ($)',
                                data: monthlyData.map(item => parseFloat(item.total) || 0),
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#4f46e5',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 5
                            }]
                        },
                        options: {
                            ...defaultOptions,
                            plugins: {
                                ...defaultOptions.plugins,
                                title: {
                                    display: true,
                                    text: 'Monthly Sales Performance'
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error creating monthly chart:', error);
            }

            // Daily Sales Chart
            try {
                const dailyCtx = document.getElementById('dailyChart');
                if (dailyCtx) {
                    const dailyData = @json($dailySales ?? []);
                    console.log('Daily data:', dailyData);

                    new Chart(dailyCtx, {
                        type: 'bar',
                        data: {
                            labels: dailyData.map(item => 'Day ' + item.day),
                            datasets: [{
                                label: 'Daily Sales ($)',
                                data: dailyData.map(item => parseFloat(item.total) || 0),
                                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                                borderColor: 'rgba(34, 197, 94, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            ...defaultOptions,
                            plugins: {
                                ...defaultOptions.plugins,
                                title: {
                                    display: true,
                                    text: 'Daily Sales This Month'
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error creating daily chart:', error);
            }

            // Yearly Sales Chart
            try {
                const yearlyCtx = document.getElementById('yearlyChart');
                if (yearlyCtx) {
                    const yearlyData = @json($yearlySales ?? []);
                    console.log('Yearly data:', yearlyData);

                    new Chart(yearlyCtx, {
                        type: 'bar',
                        data: {
                            labels: yearlyData.map(item => item.year.toString()),
                            datasets: [{
                                label: 'Yearly Sales ($)',
                                data: yearlyData.map(item => parseFloat(item.total) || 0),
                                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            ...defaultOptions,
                            plugins: {
                                ...defaultOptions.plugins,
                                title: {
                                    display: true,
                                    text: 'Yearly Sales Comparison'
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error creating yearly chart:', error);
            }
        });

        function generateReport() {
            try {
                window.open('{{ route("sale.report") }}', '_blank');
            } catch (error) {
                console.error('Error generating report:', error);
                alert('Error generating report. Please try again.');
            }
        }
    </script>

@endsection