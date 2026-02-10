@extends('template.master')
@section('title', 'Dashboard')
@section('content')
    <div id="dashboard" class="fade-in">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-gradient mb-1">Welcome back, {{ auth()->user()->name }}!</h1>
                        <p class="text-muted mb-0">Here's what's happening at your hotel today</p>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">{{ now()->format('l, F j, Y') }}</div>
                        <div class="fw-bold">{{ now()->format('g:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats h-100">
                    <div class="card-body text-center">
                        <div class="stats-number">{{ count($transactions) }}</div>
                        <div class="stats-label">
                            <i class="fas fa-users me-2"></i>
                            Guests Today
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-success h-100">
                    <div class="card-body text-center">
                        <div class="stats-number">
                            {{-- TODO: get completed today bookings --}} 0
                        </div>
                        <div class="stats-label">
                            <i class="fas fa-check-circle me-2"></i>
                            Completed Bookings
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-warning h-100">
                    <div class="card-body text-center">
                        <div class="stats-number">
                            {{ $transactions->filter(function($t) { return $t->getTotalPrice() - $t->getTotalPayment() > 0; })->count() }}
                        </div>
                        <div class="stats-label">
                            <i class="fas fa-clock me-2"></i>
                            Pending Payments
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats card-stats-danger h-100">
                    <div class="card-body text-center">
                        <div class="stats-number">
                            {{ $transactions->filter(function($t) {
                                return Helper::getDateDifference(now(), $t->check_out) < 1 &&
                                       $t->getTotalPrice() - $t->getTotalPayment() > 0;
                            })->count() }}
                        </div>
                        <div class="stats-label">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Urgent Payments
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <a href="{{ route('restaurant-bill.index') }}" class="text-decoration-none">
                    <div class="card card-stats card-stats-info h-100">
                        <div class="card-body text-center">
                            <div class="stats-number">{{ $pendingBills }}</div>
                            <div class="stats-label">
                                <i class="fas fa-utensils me-2"></i>
                                Pending Bills
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Actions (moved above Today's Guests) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Quick Actions
                        </h5>
                        <small class="text-muted">Common tasks and shortcuts</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('transaction.reservation.createIdentity') }}"
                                   class="btn btn-hotel-primary btn-lh w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                   style="min-height: 80px;">
                                    <i class="fas fa-plus-circle mb-2" style="font-size: 1.5rem;"></i>
                                    <span>New Reservation</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('customer.index') }}"
                                   class="btn btn-hotel-success btn-lh w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                   style="min-height: 80px;">
                                    <i class="fas fa-users mb-2" style="font-size: 1.5rem;"></i>
                                    <span>Manage Customers</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('restaurant-bill.create') }}"
                                   class="btn btn-hotel-info btn-lh w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                   style="min-height: 80px;">
                                    <i class="fas fa-utensils mb-2" style="font-size: 1.5rem;"></i>
                                    <span>Restaurant Bill Add</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('room.index') }}"
                                   class="btn btn-outline-primary btn-lh w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                   style="min-height: 80px;">
                                    <i class="fas fa-bed mb-2" style="font-size: 1.5rem;"></i>
                                    <span>Room Management</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Calendar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-lh">

                    <div class="card-header">

                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-door-open text-primary me-2"></i>
                            Quick Room Status
                        </h5>
                        <small class="text-muted">Room availability at a glance</small>
                    </div>

                    <div class="card-footer bg-light border-top">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 fw-bold">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Status Legend
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #28a745; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Normal CheckOut</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #ffc107; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Early CheckIn</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #17a2b8; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Early CheckOut</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #dc3545; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Late CheckOut</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #e91e63; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Booked</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search and Filter Bar -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           id="room-search-input"
                                           placeholder="Search by room number (e.g., 101, 102)..."
                                           autocomplete="off">
                                    <button class="btn btn-primary"
                                            type="button"
                                            id="room-search-btn">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                    <button class="btn btn-secondary"
                                            type="button"
                                            id="room-clear-btn">
                                        <i class="fas fa-times me-2"></i>Clear
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <select id="room-category-filter" class="form-select" aria-label="Filter by room type">
                                    <option value="">All Categories</option>
                                    @php
                                        $uniqueTypes = ($allRooms ?? [])
                                            ->map(fn($room) => optional($room->type)->name ?? 'Standard')
                                            ->unique()
                                            ->sort()
                                            ->values();
                                    @endphp
                                    @foreach($uniqueTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Room Status Container -->
                        <div class="row" id="room-status-container">
                            @forelse($allRooms ?? [] as $room)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                                    <button class="room-btn btn w-100 py-3"
                                            data-room-id="{{ $room->id }}"
                                            data-room-number="{{ $room->number }}"
                                            data-room-type="{{ $room->type->name ?? 'Standard' }}"
                                            title="Room {{ $room->number }}">
                                        <div class="fw-bold">{{ $room->number }}</div>
                                        <small>{{ $room->type->name ?? 'Standard' }}</small>
                                    </button>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">
                                    <p>No rooms available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Calendar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            Booking Calendar
                        </h5>
                        <small class="text-muted">Visual overview of all room bookings and their status</small>
                    </div>
                    <div class="card-body p-0">
                        <div id="calendar" style="padding: 20px;"></div>
                    </div>
                    <div class="card-footer bg-light border-top">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-3 fw-bold">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Status Legend
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #28a745; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Normal CheckOut</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #ffc107; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Early CheckIn</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #17a2b8; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Early CheckOut</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #dc3545; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Late CheckOut</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 18px; height: 18px; background-color: #e91e63; border-radius: 3px; margin-right: 10px; flex-shrink: 0;"></div>
                                            <small>Booked</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Today's Guests Table -->
            <div class="col-lg-8 mb-4">
                <div class="card card-lh h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-calendar-day text-primary me-2"></i>
                                Today's Guests
                            </h5>
                            <small class="text-muted">Current hotel occupancy - {{ now()->format('l, F j, Y') }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Export">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-width: calc(100vw - 100px)">
                            <table class="table table-lh mb-0">
                                <thead>
                                    <tr>
                                        <th>Guest</th>
                                        <th>Room</th>
                                        <th>Check-in/Out</th>
                                        <th>Days Left</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $transaction->customer->user->getAvatar() }}"
                                                        class="rounded-circle me-3" width="40" height="40" alt="">
                                                    <div>
                                                        <div class="fw-medium">
                                                            <a href="{{ route('customer.show', ['customer' => $transaction->customer->id]) }}"
                                                               class="text-decoration-none">
                                                                {{ $transaction->customer->name }}
                                                            </a>
                                                        </div>
                                                        <div class="text-muted small">ID: {{ $transaction->customer->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-medium">
                                                    <a href="{{ route('room.show', ['room' => $transaction->room->id]) }}"
                                                       class="text-decoration-none">
                                                        Room {{ $transaction->room->number }}
                                                    </a>
                                                </div>
                                                <div class="text-muted small">{{ $transaction->room->type->name ?? 'Standard' }}</div>
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <div><strong>In:</strong> {{ Helper::dateFormat($transaction->check_in) }}</div>
                                                    <div><strong>Out:</strong> {{ Helper::dateFormat($transaction->check_out) }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $daysLeft = Helper::getDateDifference(now(), $transaction->check_out);
                                                @endphp
                                                <span class="badge {{ $daysLeft <= 0 ? 'bg-danger' : ($daysLeft <= 1 ? 'bg-warning' : 'bg-success') }} badge-lh">
                                                    {{ $daysLeft == 0 ? 'Last Day' : $daysLeft . ' ' . Helper::plural('Day', $daysLeft) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $balance = $transaction->getTotalPrice() - $transaction->getTotalPayment();
                                                @endphp
                                                @if($balance <= 0)
                                                    <span class="text-success fw-medium">Paid</span>
                                                @else
                                                    <span class="text-danger fw-medium">{{ Helper::convertToRupiah($balance) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="badge {{ $transaction->getTotalPrice() - $transaction->getTotalPayment() == 0 ? 'bg-success' : 'bg-warning' }} badge-lh">
                                                        {{ $transaction->getTotalPrice() - $transaction->getTotalPayment() == 0 ? 'Completed' : 'In Progress' }}
                                                    </span>
                                                    @if (Helper::getDateDifference(now(), $transaction->check_out) < 1 && $transaction->getTotalPrice() - $transaction->getTotalPayment() > 0)
                                                        <span class="badge bg-danger badge-lh">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Urgent
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-bed mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                                    <p class="mb-0">No guests checked in today</p>
                                                    <small>Your hotel is ready for new bookings!</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Chart -->
            <div class="col-lg-4 mb-4">
                <div class="card card-lh h-100">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Monthly Guests
                        </h5>
                        <small class="text-muted">Guest statistics for {{ Helper::thisMonth() }}/{{ Helper::thisYear() }}</small>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    <div class="h2 text-primary mb-0">{{ count($transactions) }}</div>
                                    <small class="text-muted">Total Guests This Month</small>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative mb-4">
                            <canvas this-year="{{ Helper::thisYear() }}" this-month="{{ Helper::thisMonth() }}"
                                    id="visitors-chart" height="200" width="100%" class="chartjs-render-monitor"></canvas>
                        </div>

                        <div class="d-flex justify-content-between text-center">
                            <div class="flex-fill">
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <div class="bg-primary rounded me-2" style="width: 12px; height: 12px;"></div>
                                    <small class="text-muted">This Month</small>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <div class="bg-secondary rounded me-2" style="width: 12px; height: 12px;"></div>
                                    <small class="text-muted">Last Month</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

        <!-- Booking Update Section -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-edit text-primary me-2"></i>
                            Update Booking Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label fw-medium">Checkout Status</label>
                            <select name="checkout_status" class="form-control">
                                <option value="normal">Normal CheckOut</option>
                                <option value="early_checkin">Early CheckIn</option>
                                <option value="early_checkout">Early CheckOut</option>
                                <option value="late_checkout">Late CheckOut</option>
                            </select>
                            <small class="text-muted">Select checkout status for guest reservations</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complaint Modal - Hidden by default -->
        @include('partials.complaint_modal')

    </div>
@endsection

@section('footer')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<style>
    #calendar {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: white;
        border-radius: 8px;
    }
    .fc {
        font-size: 1rem;
    }
    .fc .fc-daygrid-day-frame {
        min-height: 120px !important;
    }
    .fc .fc-daygrid-day {
        border: 1px solid #dee2e6 !important;
    }
    .fc .fc-daygrid-day.fc-day-other {
        background-color: #f8f9fa;
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: #fff3cd;
    }
    .fc .fc-col-header-cell {
        background-color: #f8f9fa;
        padding: 12px 4px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    .fc .fc-daygrid-day-number {
        padding: 8px 6px;
        font-weight: 500;
        color: #333;
    }
    .fc-event {
        background-color: #007bff !important;
        border: none !important;
        cursor: pointer;
        padding: 2px 4px;
        font-size: 0.85rem;
    }
    .fc-event-title {
        font-weight: 500;
        white-space: normal;
        color: white !important;
    }
    .fc .fc-button-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 6px 12px;
        font-size: 0.95rem;
    }
    .fc .fc-button-primary:hover,
    .fc .fc-button-primary:focus,
    .fc .fc-button-primary.fc-button-active {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .fc .fc-button-primary:disabled {
        opacity: 0.5;
    }
    .fc .fc-toolbar {
        padding: 0 0 15px 0;
        margin: 0;
    }
    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing FullCalendar...');

        var calendarEl = document.getElementById('calendar');
        console.log('Calendar element found:', !!calendarEl);

        // Parse events data
        var eventsData = {!! $calendarEvents !!};
        console.log('Events data:', eventsData);
        console.log('Number of events:', eventsData.length);

        // Create calendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            height: 'auto',
            contentHeight: 'auto',
            showNonCurrentDates: true,
            fixedWeekCount: true,
            dayMaxEventRows: 3,
            weekends: true,
            events: eventsData,
            eventDisplay: 'block',
            eventClick: function(info) {
                var event = info.event;
                if (event.extendedProps && event.extendedProps.customer) {
                    alert('Room: ' + event.extendedProps.room + '\nCustomer: ' + event.extendedProps.customer + '\nStatus: ' + event.extendedProps.status.replace(/_/g, ' ').toUpperCase());
                }
            },
            eventDidMount: function(info) {
                info.el.style.cursor = 'pointer';
            }
        });

        console.log('Rendering calendar...');
        calendar.render();
        console.log('Calendar rendered successfully');
    });
</script>
@endsection
