<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomStatusRequest;
use App\Models\RoomStatus;
use App\Repositories\Interface\RoomStatusRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomStatusController extends Controller
{
    public function __construct(
        private RoomStatusRepositoryInterface $roomStatusRepository
    ) {}

    // CRUD Methods
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->roomStatusRepository->getDatatable($request);
        }

        return view('roomstatus.index');
    }

    public function create()
    {
        return response()->json([
            'view' => view('roomstatus.create')->render(),
        ]);
    }

    public function store(StoreRoomStatusRequest $request)
    {
        $roomstatus = RoomStatus::create($request->all());

        return response()->json([
            'message' => 'success', "Room $roomstatus->name created",
        ]);
    }

    public function edit(RoomStatus $roomstatus)
    {
        $view = view('roomstatus.edit', [
            'roomstatus' => $roomstatus,
        ])->render();

        return response()->json([
            'view' => $view,
        ]);
    }

    public function update(StoreRoomStatusRequest $request, RoomStatus $roomstatus)
    {
        $roomstatus->update($request->all());

        return response()->json([
            'message' => 'success', "Room $roomstatus->name udpated",
        ]);
    }

    public function destroy(RoomStatus $roomstatus)
    {
        try {
            $roomstatus->delete();

            return response()->json([
                'message' => "Room $roomstatus->name deleted!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Type {$roomstatus->name} cannot be deleted! Error Code: {$e->errorInfo[1]}",
            ], 500);
        }
    }

    // API Methods for Dashboard
    /**
     * Get room statuses for a given date
     */
    public function getStatuses(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());

        $statuses = RoomStatus::where('date', $date)
            ->with('room')
            ->get()
            ->mapWithKeys(function ($status) {
                return [
                    $status->room_id => $status->status
                ];
            });

        return response()->json([
            'date' => $date,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update room status for a date
     */
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'status' => 'required|in:normal_checkout,early_checkin,early_checkout,late_checkout,booked',
            'booking_id' => 'nullable|exists:transactions,id',
        ]);

        $roomStatus = RoomStatus::updateOrCreate(
            [
                'room_id' => $validated['room_id'],
                'date' => $validated['date'],
            ],
            [
                'status' => $validated['status'],
                'booking_id' => $validated['booking_id'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Room status updated successfully',
            'data' => $roomStatus
        ], 201);
    }
}
