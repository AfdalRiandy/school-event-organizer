<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    /**
     * Get all available events (approved only)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents()
    {
        // Only show events that are approved and registration is still open
        $today = Carbon::now();
        $events = Acara::where('status', 'disetujui')
            ->where('batas_pendaftaran', '>=', $today->format('Y-m-d'))
            ->with(['panitia.user' => function($query) {
                $query->select('id', 'name');
            }])
            ->latest()
            ->get();
            
        return response()->json([
            'status' => 'success',
            'count' => $events->count(),
            'data' => $events
        ]);
    }
    
    /**
     * Get a single event with detailed information
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvent($id)
    {
        $event = Acara::where('status', 'disetujui')
            ->with(['panitia.user' => function($query) {
                $query->select('id', 'name');
            }])
            ->findOrFail($id);
        
        // Check if student is already registered
        $isRegistered = false;
        $registration = null;
        
        if (Auth::user()->role === 'siswa') {
            $pendaftaran = Pendaftaran::where('siswa_id', Auth::user()->siswa->id)
                ->where('acara_id', $event->id)
                ->first();
                
            if ($pendaftaran) {
                $isRegistered = true;
                $registration = $pendaftaran;
            }
        }
        
        // Check if registration is still open
        $isOpen = Carbon::now()->lte(Carbon::parse($event->batas_pendaftaran));
        
        return response()->json([
            'status' => 'success',
            'data' => $event,
            'meta' => [
                'is_registered' => $isRegistered,
                'registration' => $registration,
                'is_registration_open' => $isOpen
            ]
        ]);
    }
    
    /**
     * Get all registrations for the current student
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyRegistrations()
    {
        // Check if user is a student
        if (Auth::user()->role !== 'siswa') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only students can view their registrations'
            ], 403);
        }
        
        $registrations = Pendaftaran::where('siswa_id', Auth::user()->siswa->id)
            ->with(['acara' => function($query) {
                $query->select('id', 'judul', 'tanggal_acara', 'batas_pendaftaran', 'image');
            }])
            ->latest()
            ->get();
            
        return response()->json([
            'status' => 'success',
            'count' => $registrations->count(),
            'data' => $registrations
        ]);
    }
    
    /**
     * Register for an event
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate request
        $request->validate([
            'acara_id' => 'required|exists:acaras,id',
        ]);
        
        // Check if user is a student
        if (Auth::user()->role !== 'siswa') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only students can register for events'
            ], 403);
        }
        
        $acara = Acara::findOrFail($request->acara_id);
        $siswa = Auth::user()->siswa;
        
        // Check if event is approved
        if ($acara->status !== 'disetujui') {
            return response()->json([
                'status' => 'error',
                'message' => 'This event is not available for registration'
            ], 422);
        }
        
        // Check if registration deadline has passed
        $today = Carbon::now();
        $batasPendaftaran = Carbon::parse($acara->batas_pendaftaran)->endOfDay();
        
        if ($today->gt($batasPendaftaran)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration deadline has passed'
            ], 422);
        }
        
        // Check if already registered
        $existingRegistration = Pendaftaran::where('siswa_id', $siswa->id)
            ->where('acara_id', $acara->id)
            ->first();
            
        if ($existingRegistration) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already registered for this event'
            ], 422);
        }
        
        // Create new registration
        $pendaftaran = Pendaftaran::create([
            'siswa_id' => $siswa->id,
            'acara_id' => $acara->id,
            'status' => 'pending'
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully registered! Your registration is awaiting approval.',
            'data' => $pendaftaran
        ], 201);
    }
    
    /**
     * Cancel a registration
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelRegistration($id)
    {
        // Check if user is a student
        if (Auth::user()->role !== 'siswa') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only students can cancel registrations'
            ], 403);
        }
        
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        // Security check - only cancel own registrations
        if ($pendaftaran->siswa_id != Auth::user()->siswa->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action'
            ], 403);
        }
        
        // Check if registration is still pending
        if ($pendaftaran->status != 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only pending registrations can be cancelled'
            ], 422);
        }
        
        // Check if registration deadline has passed
        $today = Carbon::now();
        $batasPendaftaran = Carbon::parse($pendaftaran->acara->batas_pendaftaran)->endOfDay();
        
        if ($today->gt($batasPendaftaran)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration deadline has passed, cannot cancel'
            ], 422);
        }
        
        // Delete registration
        $pendaftaran->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Registration cancelled successfully'
        ]);
    }
}