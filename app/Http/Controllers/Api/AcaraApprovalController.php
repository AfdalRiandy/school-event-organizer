<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcaraApprovalController extends Controller
{
    /**
     * Get all pending events that need approval
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendingEvents()
    {
        // Check if user is wakil kesiswaan
        if (auth()->user()->role !== 'wakil_kesiswaan') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Only Wakil Kesiswaan can access this endpoint.'
            ], 403);
        }

        // Get all pending events
        $pendingEvents = Acara::with('panitia.user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $pendingEvents->count(),
            'data' => $pendingEvents
        ]);
    }

    /**
     * Get all events (with optional status filter)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEvents(Request $request)
    {
        // Check if user is wakil kesiswaan
        if (auth()->user()->role !== 'wakil_kesiswaan') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Only Wakil Kesiswaan can access this endpoint.'
            ], 403);
        }

        $status = $request->input('status');
        
        $query = Acara::with('panitia.user');
        
        // Apply status filter if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        $events = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'count' => $events->count(),
            'data' => $events
        ]);
    }

    /**
     * Approve an event
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveEvent($id)
    {
        // Check if user is wakil kesiswaan
        if (auth()->user()->role !== 'wakil_kesiswaan') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Only Wakil Kesiswaan can approve events.'
            ], 403);
        }

        // Find the event
        $acara = Acara::find($id);
        
        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found'
            ], 404);
        }
        
        // Check if event is already approved or rejected
        if ($acara->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'This event has already been ' . ($acara->status === 'disetujui' ? 'approved' : 'rejected')
            ], 422);
        }
        
        // Update event status to approved
        $acara->update(['status' => 'disetujui']);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Event has been approved successfully',
            'data' => $acara
        ]);
    }

    /**
     * Reject an event
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectEvent(Request $request, $id)
    {
        // Check if user is wakil kesiswaan
        if (auth()->user()->role !== 'wakil_kesiswaan') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Only Wakil Kesiswaan can reject events.'
            ], 403);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'alasan_penolakan' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the event
        $acara = Acara::find($id);
        
        if (!$acara) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found'
            ], 404);
        }
        
        // Check if event is already approved or rejected
        if ($acara->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'This event has already been ' . ($acara->status === 'disetujui' ? 'approved' : 'rejected')
            ], 422);
        }
        
        // Update event status to rejected with reason
        $acara->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Event has been rejected successfully',
            'data' => $acara
        ]);
    }
}