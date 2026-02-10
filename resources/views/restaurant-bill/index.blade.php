@extends('template.master')
@section('title', 'Restaurant Bills')
@section('content')
    <div id="restaurant-bills" class="fade-in">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 text-gradient mb-1">Restaurant Bills</h1>
                        <p class="text-muted mb-0">Manage restaurant bills for guests</p>
                    </div>
                    <a href="{{ route('restaurant-bill.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Bill
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-lh">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-utensils text-primary me-2"></i>
                        All Bills
                    </h5>
                    <small class="text-muted">Total: {{ $bills->total() }} bills</small>
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
                <div class="table-responsive">
                    <table class="table table-lh mb-0">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bills as $bill)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $bill->transaction->customer->user->getAvatar() }}"
                                                class="rounded-circle me-3" width="40" height="40" alt="">
                                            <div>
                                                <div class="fw-medium">
                                                    {{ $bill->transaction->customer->name }}
                                                </div>
                                                <div class="text-muted small">Room {{ $bill->transaction->room->number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $bill->item_name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-center d-inline-block" style="min-width: 40px;">
                                            {{ $bill->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ Helper::convertToRupiah($bill->unit_price) }}
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ Helper::convertToRupiah($bill->total_price) }}</strong>
                                    </td>
                                    <td>
                                        @if($bill->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($bill->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $bill->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('restaurant-bill.show', $bill) }}"
                                               class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('restaurant-bill.edit', $bill) }}"
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('restaurant-bill.destroy', $bill) }}" method="POST"
                                                  style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-utensils mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mb-0">No restaurant bills found</p>
                                            <small>Start by <a href="{{ route('restaurant-bill.create') }}">adding a new bill</a></small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($bills->hasPages())
                <div class="card-footer-padding">
                    {{ $bills->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
