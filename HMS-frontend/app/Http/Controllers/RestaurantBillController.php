<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBill;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RestaurantBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = RestaurantBill::with('transaction', 'user')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('restaurant-bill.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactions = Transaction::with('customer', 'room')
            ->orderBy('check_in', 'DESC')
            ->get();

        return view('restaurant-bill.create', compact('transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['status'] = 'pending';
        $validated['ordered_at'] = now();

        RestaurantBill::create($validated);

        return redirect()->route('restaurant-bill.index')
            ->with('success', 'Restaurant bill added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RestaurantBill $restaurantBill)
    {
        $restaurantBill->load('transaction', 'user');
        return view('restaurant-bill.show', compact('restaurantBill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantBill $restaurantBill)
    {
        $transactions = Transaction::with('customer', 'room')
            ->orderBy('check_in', 'DESC')
            ->get();

        return view('restaurant-bill.edit', compact('restaurantBill', 'transactions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RestaurantBill $restaurantBill)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        if ($validated['status'] == 'completed') {
            $validated['completed_at'] = now();
        }

        $restaurantBill->update($validated);

        return redirect()->route('restaurant-bill.show', $restaurantBill)
            ->with('success', 'Restaurant bill updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantBill $restaurantBill)
    {
        $restaurantBill->delete();

        return redirect()->route('restaurant-bill.index')
            ->with('success', 'Restaurant bill deleted successfully!');
    }
}

