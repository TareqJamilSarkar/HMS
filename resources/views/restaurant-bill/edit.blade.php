@extends('template.master')
@section('title', 'Edit Restaurant Bill')
@section('content')
    <div class="fade-in">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-gradient mb-1">Edit Restaurant Bill</h1>
                        <p class="text-muted mb-0">Update bill information</p>
                    </div>
                    <a href="{{ route('restaurant-bill.show', $restaurantBill) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-lh">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-utensils text-primary me-2"></i>
                            Bill Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('restaurant-bill.update', $restaurantBill) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Guest Selection -->
                            <div class="mb-3">
                                <label for="transaction_id" class="form-label fw-medium">
                                    Guest <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('transaction_id') is-invalid @enderror"
                                        id="transaction_id" name="transaction_id" required>
                                    <option value="">-- Select a guest --</option>
                                    @forelse($transactions as $transaction)
                                        @php
                                            $isCheckedIn = $transaction->check_in <= now() && $transaction->check_out >= now();
                                            $status = $isCheckedIn ? '✓ Checked In' : 'Not Checked In';
                                        @endphp
                                        <option value="{{ $transaction->id }}"
                                            {{ old('transaction_id', $restaurantBill->transaction_id) == $transaction->id ? 'selected' : '' }}>
                                            {{ $transaction->customer->name }} - Room {{ $transaction->room->number }} ({{ $status }})
                                        </option>
                                    @empty
                                        <option value="" disabled>No guests available</option>
                                    @endforelse
                                </select>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Shows all customers - both checked in and past/future bookings
                                </small>
                                @error('transaction_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Item Name -->
                            <div class="mb-3">
                                <label for="item_name" class="form-label fw-medium">
                                    Item Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('item_name') is-invalid @enderror"
                                       id="item_name" name="item_name"
                                       value="{{ old('item_name', $restaurantBill->item_name) }}"
                                       placeholder="e.g., Grilled Chicken, Coffee, etc." required>
                                @error('item_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Quantity -->
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label fw-medium">
                                        Quantity <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                           id="quantity" name="quantity"
                                           value="{{ old('quantity', $restaurantBill->quantity) }}"
                                           min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Unit Price -->
                                <div class="col-md-6 mb-3">
                                    <label for="unit_price" class="form-label fw-medium">
                                        Unit Price <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" class="form-control @error('unit_price') is-invalid @enderror"
                                               id="unit_price" name="unit_price"
                                               value="{{ old('unit_price', $restaurantBill->unit_price) }}"
                                               step="1" min="1" required>
                                    </div>
                                    @error('unit_price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Total Price Display -->
                            <div class="mb-3">
                                <label class="form-label fw-medium">Total Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="text" class="form-control" id="total_price"
                                           value="{{ number_format($restaurantBill->total_price, 0, ',', '.') }}" readonly>
                                </div>
                                <small class="text-muted">Calculated automatically</small>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label fw-medium">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="pending" {{ old('status', $restaurantBill->status) == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="completed" {{ old('status', $restaurantBill->status) == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="cancelled" {{ old('status', $restaurantBill->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label fw-medium">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes" name="notes" rows="4"
                                          placeholder="Add any special instructions or notes...">{{ old('notes', $restaurantBill->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Update Bill
                                </button>
                                <a href="{{ route('restaurant-bill.show', $restaurantBill) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="col-lg-4">
                <div class="card card-lh bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-circle-info text-info me-2"></i>Bill Information
                        </h6>
                        <div class="mb-3">
                            <small class="text-muted">Bill ID</small>
                            <div class="fw-medium">#{{ $restaurantBill->id }}</div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <div class="fw-medium">{{ $restaurantBill->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created By</small>
                            <div class="fw-medium">{{ $restaurantBill->user->name }}</div>
                        </div>

                        @if($restaurantBill->completed_at)
                            <div class="mb-3">
                                <small class="text-muted">Completed</small>
                                <div class="fw-medium">{{ $restaurantBill->completed_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endif

                        <hr>

                        <div class="alert alert-info small mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Total bill amount: <strong>{{ Helper::convertToRupiah($restaurantBill->total_price) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unit_price');
        const totalPriceDisplay = document.getElementById('total_price');

        function calculateTotal() {
            const quantity = parseInt(quantityInput.value) || 0;
            const unitPrice = parseInt(unitPriceInput.value) || 0;
            const total = quantity * unitPrice;

            // Format as currency (no decimals, no commas)
            totalPriceDisplay.value = total.toString();
        }

        quantityInput.addEventListener('change', calculateTotal);
        unitPriceInput.addEventListener('input', calculateTotal);
    </script>
@endsection
