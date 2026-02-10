<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\RestaurantBill;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics and reports page
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // Revenue Data
        $totalRevenue = Payment::sum('price');
        $todayRevenue = Payment::whereDate('created_at', $today)->sum('price');
        $monthRevenue = Payment::whereBetween('created_at', [$thisMonth, Carbon::now()])->sum('price');
        $yearRevenue = Payment::whereBetween('created_at', [$thisYear, Carbon::now()])->sum('price');

        // Transaction Data
        $totalTransactions = Transaction::count();
        $todayTransactions = Transaction::whereDate('created_at', $today)->count();
        $monthTransactions = Transaction::whereBetween('created_at', [$thisMonth, Carbon::now()])->count();
        $completedTransactions = Transaction::whereNotNull('check_out')->count();

        // Restaurant Bills Data
        $totalBills = RestaurantBill::count();
        $paidBills = RestaurantBill::where('status', 'completed')->count();
        $pendingBills = RestaurantBill::where('status', 'pending')->count();
        $totalBillAmount = RestaurantBill::sum('total_price');

        // Average Data
        $avgTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
        $avgBillValue = $totalBills > 0 ? $totalBillAmount / $totalBills : 0;

        // Daily Revenue for Chart (Last 7 days)
        $dailyRevenue = Payment::selectRaw('DATE(created_at) as date, SUM(price) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly Revenue for Chart (Last 12 months)
        $monthlyRevenue = Payment::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(price) as total')
            ->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()])
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Top Rooms by Bookings
        $topRooms = Transaction::selectRaw('room_id, COUNT(*) as bookings')
            ->with('room')
            ->groupBy('room_id')
            ->orderByDesc('bookings')
            ->limit(5)
            ->get();

        return view('analytics.index', [
            'totalRevenue' => $totalRevenue,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'yearRevenue' => $yearRevenue,
            'totalTransactions' => $totalTransactions,
            'todayTransactions' => $todayTransactions,
            'monthTransactions' => $monthTransactions,
            'completedTransactions' => $completedTransactions,
            'totalBills' => $totalBills,
            'paidBills' => $paidBills,
            'pendingBills' => $pendingBills,
            'totalBillAmount' => $totalBillAmount,
            'avgTransactionValue' => $avgTransactionValue,
            'avgBillValue' => $avgBillValue,
            'dailyRevenue' => $dailyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'topRooms' => $topRooms,
        ]);
    }
}
