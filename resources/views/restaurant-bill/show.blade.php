@extends('template.master')
@section('title', 'Bill Details')
@section('content')
    <div class="fade-in">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-gradient mb-1">Bill Details</h1>
                        <p class="text-muted mb-0">View and manage bill information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('restaurant-bill.edit', $restaurantBill) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('restaurant-bill.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-lh mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-receipt text-primary me-2"></i>
                            Bill Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Bill ID</label>
                                    <div class="fw-medium text-dark">#{{ $restaurantBill->id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Guest Name</label>
                                    <div class="fw-medium text-dark">
                                        {{ $restaurantBill->transaction->customer->name }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Room</label>
                                    <div class="fw-medium text-dark">
                                        Room {{ $restaurantBill->transaction->room->number }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Status</label>
                                    <div>
                                        @if($restaurantBill->status === 'pending')
                                            <span class="badge bg-warning p-2">Pending</span>
                                        @elseif($restaurantBill->status === 'completed')
                                            <span class="badge bg-success p-2">Completed</span>
                                        @else
                                            <span class="badge bg-danger p-2">Cancelled</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Ordered At</label>
                                    <div class="fw-medium text-dark">
                                        {{ $restaurantBill->ordered_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                @if($restaurantBill->completed_at)
                                    <div class="mb-3">
                                        <label class="text-muted small">Completed At</label>
                                        <div class="fw-medium text-dark">
                                            {{ $restaurantBill->completed_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Item Name</label>
                                    <div class="fw-medium text-dark">{{ $restaurantBill->item_name }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Quantity</label>
                                    <div class="fw-medium text-dark">{{ $restaurantBill->quantity }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Unit Price</label>
                                    <div class="fw-medium text-dark">
                                        {{ Helper::convertToRupiah($restaurantBill->unit_price) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-muted small">Total Price</label>
                                    <div class="fw-bold text-primary" style="font-size: 1.25rem;">
                                        {{ Helper::convertToRupiah($restaurantBill->total_price) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($restaurantBill->notes)
                            <div class="mb-3">
                                <label class="text-muted small">Notes</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $restaurantBill->notes }}
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="text-muted small">Created By</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ $restaurantBill->user->getAvatar() }}"
                                    class="rounded-circle me-2" width="30" height="30" alt="">
                                <div class="fw-medium">{{ $restaurantBill->user->name }}</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Created At</label>
                            <div class="fw-medium text-dark">
                                {{ $restaurantBill->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="col-lg-4">
                <div class="card card-lh bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">Bill Summary</h6>

                        <div class="row mb-3">
                            <div class="col-6 text-white-70">Quantity:</div>
                            <div class="col-6 fw-bold text-end">{{ $restaurantBill->quantity }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6 text-white-70">Unit Price:</div>
                            <div class="col-6 fw-bold text-end">
                                {{ Helper::convertToRupiah($restaurantBill->unit_price) }}
                            </div>
                        </div>

                        <hr class="bg-white-50">

                        <div class="row mb-3">
                            <div class="col-6 text-white-70">Total:</div>
                            <div class="col-6 fw-bold text-end" style="font-size: 1.5rem;">
                                {{ Helper::convertToRupiah($restaurantBill->total_price) }}
                            </div>
                        </div>

                        <hr class="bg-white-50 mb-3">

                        <div class="alert alert-light mb-0 text-dark small">
                            <i class="fas fa-info-circle me-2"></i>
                            Status: <strong>{{ ucfirst($restaurantBill->status) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="card card-lh mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Quick Actions</h6>

                        <div class="d-grid gap-2">
                            @if($restaurantBill->status !== 'completed')
                                <form action="{{ route('restaurant-bill.update', $restaurantBill) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="transaction_id" value="{{ $restaurantBill->transaction_id }}">
                                    <input type="hidden" name="item_name" value="{{ $restaurantBill->item_name }}">
                                    <input type="hidden" name="quantity" value="{{ $restaurantBill->quantity }}">
                                    <input type="hidden" name="unit_price" value="{{ $restaurantBill->unit_price }}">
                                    <input type="hidden" name="status" value="completed">
                                    <input type="hidden" name="notes" value="{{ $restaurantBill->notes }}">

                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check me-2"></i>Mark as Completed
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('restaurant-bill.edit', $restaurantBill) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit Bill
                            </a>

                            <form action="{{ route('restaurant-bill.destroy', $restaurantBill) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this bill?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-trash me-2"></i>Delete Bill
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
