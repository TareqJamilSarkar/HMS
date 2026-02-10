<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintItem;

class ComplaintController extends Controller
{
    // Create complaint with items
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'room_type_id' => 'nullable|integer|exists:room_types,id',
            'remarks' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.title' => 'required_with:items|string',
            'items.*.details' => 'nullable|string',
        ]);

        $complaint = Complaint::create([
            'room_id' => $data['room_id'],
            'room_type_id' => $data['room_type_id'] ?? null,
            'created_by' => auth()->id() ?? null,
            'remarks' => $data['remarks'] ?? null,
            'status' => 'open',
        ]);

        if (!empty($data['items'])) {
            foreach ($data['items'] as $it) {
                $complaint->items()->create([
                    'title' => $it['title'],
                    'details' => $it['details'] ?? null,
                ]);
            }
        }

        // Return a little extra data for UI
        return response()->json([
            'success' => true,
            'complaint' => $complaint->load('items')
        ]);
    }

    // Get open complaints summary for dashboard
    public function indexSummary()
    {
        $complaintCount = Complaint::where('status', 'open')->count();
        $rooms = Complaint::where('status', 'open')->pluck('room_id')->toArray();

        return response()->json([
            'count' => $complaintCount,
            'rooms' => $rooms,
        ]);
    }

    // Get complaints for a room
    public function byRoom($roomId)
    {
        $complaints = Complaint::with('items')->where('room_id', $roomId)->orderBy('created_at','desc')->get();
        return response()->json($complaints);
    }

    // Resolve / clear complaint
    public function resolve(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->status = 'resolved';
        $complaint->save();

        return response()->json(['success' => true]);
    }
}