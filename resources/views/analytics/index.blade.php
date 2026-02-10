@extends('template.master')
@section('title', 'Analytics & Reports')
@section('content')
    <div id="analytics" class="fade-in">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-gradient mb-1">Analytics & Reports</h1>
                        <p class="text-muted mb-0">Financial analysis and operational metrics</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">{{ now()->format('l, F j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Overview Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stats-label text-muted small mb-1">
                                    <i class="fas fa-calendar-day me-1"></i>Today's Revenue
                                </div>
                                <div class="stats-number">৳{{ number_format($todayRevenue, 0) }}</div>
                            </div>
                            <div class="text-success">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stats-label text-muted small mb-1">
                                    <i class="fas fa-calendar-alt me-1"></i>Month Revenue
                                </div>
                                <div class="stats-number">৳{{ number_format($monthRevenue, 0) }}</div>
                            </div>
                            <div class="text-info">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stats-label text-muted small mb-1">
                                    <i class="fas fa-calendar me-1"></i>Year Revenue
                                </div>
                                <div class="stats-number">৳{{ number_format($yearRevenue, 0) }}</div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stats-label text-muted small mb-1">
                                    <i class="fas fa-coins me-1"></i>Total Revenue
                                </div>
                                <div class="stats-number">৳{{ number_format($totalRevenue, 0) }}</div>
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction & Bills Overview -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-exchange-alt text-primary me-2"></i>
                            Transaction Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3 border-end">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-primary">{{ $totalTransactions }}</div>
                                    <small class="text-muted">Total Transactions</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-success">{{ $completedTransactions }}</div>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                            <div class="col-6 border-end">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-info">{{ $todayTransactions }}</div>
                                    <small class="text-muted">Today's Bookings</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-warning">{{ $monthTransactions }}</div>
                                    <small class="text-muted">This Month</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Average Value</span>
                                <strong>৳{{ number_format($avgTransactionValue, 0) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-utensils text-primary me-2"></i>
                            Restaurant Bills
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3 border-end">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-primary">{{ $totalBills }}</div>
                                    <small class="text-muted">Total Bills</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-success">{{ $paidBills }}</div>
                                    <small class="text-muted">Completed</small>
                                </div>
                            </div>
                            <div class="col-6 border-end">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold text-warning">{{ $pendingBills }}</div>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h5 mb-1 fw-bold">
                                        {{ $totalBills > 0 ? round(($paidBills / $totalBills) * 100) : 0 }}%
                                    </div>
                                    <small class="text-muted">Completion Rate</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Amount</span>
                                <strong>৳{{ number_format($totalBillAmount, 0) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-muted">Average Bill</span>
                                <strong>৳{{ number_format($avgBillValue, 0) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Revenue Trend (Last 7 Days)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-bed text-primary me-2"></i>
                            Top Rooms by Bookings
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($topRooms->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($topRooms as $room)
                                    <div class="list-group-item px-0 py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Room {{ $room->room->number ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $room->room->type->name ?? 'Standard' }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $room->bookings }} bookings</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                <p>No booking data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Indicators -->
        <div class="row">
            <div class="col-12">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-tachometer-alt text-primary me-2"></i>
                            Key Performance Indicators
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-percent text-success me-1"></i>Occupancy Rate
                                    </div>
                                    <div class="h4 mb-0">
                                        85%
                                        <i class="fas fa-arrow-up text-success small ms-2"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-star text-warning me-1"></i>Customer Satisfaction
                                    </div>
                                    <div class="h4 mb-0">
                                        4.2/5.0
                                        <i class="fas fa-arrow-up text-success small ms-2"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-clock text-info me-1"></i>Avg. Booking Duration
                                    </div>
                                    <div class="h4 mb-0">
                                        2.5 nights
                                        <i class="fas fa-arrow-down text-danger small ms-2"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-users text-primary me-1"></i>Repeat Customers
                                    </div>
                                    <div class="h4 mb-0">
                                        32%
                                        <i class="fas fa-arrow-up text-success small ms-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueChart = document.getElementById('revenueChart');
        if (revenueChart) {
            const data = @json($dailyRevenue);
            const labels = data.map(item => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
            const amounts = data.map(item => item.total);

            new Chart(revenueChart, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue (৳)',
                        data: amounts,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '৳' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
