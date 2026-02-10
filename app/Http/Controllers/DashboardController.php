<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBill;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'room', 'customer')
            ->where([['check_in', '<=', Carbon::now()], ['check_out', '>=', Carbon::now()]])
            ->orderBy('check_out', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();

        $pendingBills = RestaurantBill::where('status', 'pending')->count();
        $totalBillsAmount = RestaurantBill::where('status', 'pending')->sum('total_price');

        return view('dashboard.index', [
            'transactions' => $transactions,
            'pendingBills' => $pendingBills,
            'totalBillsAmount' => $totalBillsAmount,
        ]);
    }
}
