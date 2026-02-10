<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBill;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Type;
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
        $roomTypes = Type::all();
        $allRooms = Room::with('type')->get();

        // Fetch all transactions for calendar (no date filter)
        $allTransactions = Transaction::with('room', 'customer')->get();

        // Build calendar events
        $calendarEvents = [];
        foreach ($allTransactions as $transaction) {
            try {
                $checkoutStatus = $transaction->checkout_status ?? 'booked';

                // Color mapping
                $colorMap = [
                    'booked' => '#e91e63',         // Pink (default/unspecified)
                    'normal' => '#28a745',        // Green
                    'early_checkin' => '#ffc107', // Yellow
                    'early_checkout' => '#17a2b8', // Light Blue
                    'late_checkout' => '#dc3545',  // Red
                ];

                $color = $colorMap[$checkoutStatus] ?? '#e91e63';

                // Convert dates properly - handle both string and Carbon instances
                $checkIn = $transaction->check_in;
                if (is_string($checkIn)) {
                    $checkIn = Carbon::createFromFormat('Y-m-d H:i:s', $checkIn);
                } elseif (!($checkIn instanceof Carbon)) {
                    $checkIn = Carbon::parse($checkIn);
                }

                $checkOut = $transaction->check_out;
                if (is_string($checkOut)) {
                    $checkOut = Carbon::createFromFormat('Y-m-d H:i:s', $checkOut);
                } elseif (!($checkOut instanceof Carbon)) {
                    $checkOut = Carbon::parse($checkOut);
                }

                // Add one day for end date (FullCalendar excludes end date)
                $endDate = $checkOut->copy()->addDay();

                $calendarEvents[] = [
                    'title' => 'Room ' . $transaction->room->number . ' - ' . ucfirst(str_replace('_', ' ', $checkoutStatus)),
                    'start' => $checkIn->format('Y-m-d'),
                    'end' => $endDate->format('Y-m-d'),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'extendedProps' => [
                        'customer' => $transaction->customer->name,
                        'room' => $transaction->room->number,
                        'status' => $checkoutStatus,
                    ],
                ];
            } catch (\Exception $e) {
                // Skip transactions with invalid dates
                \Log::warning('Invalid date in transaction ID ' . $transaction->id);
                continue;
            }
        }

        return view('dashboard.index', [
            'transactions' => $transactions,
            'pendingBills' => $pendingBills,
            'totalBillsAmount' => $totalBillsAmount,
            'roomTypes' => $roomTypes,
            'allRooms' => $allRooms,
            'calendarEvents' => json_encode($calendarEvents),
        ]);
    }
}
