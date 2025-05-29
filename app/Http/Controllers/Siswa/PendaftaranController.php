<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    // Show history of all registrations for current student
    public function index()
    {
        $pendaftarans = Auth::user()->siswa->pendaftarans()
            ->with('acara')
            ->latest()
            ->get();
        
        return view('siswa.pendaftaran.index', compact('pendaftarans'));
    }

    // Store a new registration
    public function store(Request $request)
    {
        $request->validate([
            'acara_id' => 'required|exists:acaras,id',
        ]);

        $acara = Acara::findOrFail($request->acara_id);
        $siswa = Auth::user()->siswa;
        
        // Check if registration deadline has passed
        $today = Carbon::now()->startOfDay();
        $batasPendaftaran = Carbon::parse($acara->batas_pendaftaran)->endOfDay();
        
        if ($today->gt($batasPendaftaran)) {
            return redirect()->back()->with('error', 'Maaf, batas waktu pendaftaran sudah berakhir.');
        }
        
        // Check if already registered
        $existingRegistration = Pendaftaran::where('siswa_id', $siswa->id)
            ->where('acara_id', $acara->id)
            ->first();
            
        if ($existingRegistration) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar untuk acara ini.');
        }
        
        // Create new registration
        Pendaftaran::create([
            'siswa_id' => $siswa->id,
            'acara_id' => $acara->id,
            'status' => 'pending'
        ]);
        
        return redirect()->back()->with('success', 'Berhasil mendaftar! Pendaftaran Anda sedang menunggu persetujuan.');
    }

    // Cancel a registration
    public function destroy(Pendaftaran $pendaftaran)
    {
        // Security check - only cancel own registrations that are still pending
        if ($pendaftaran->siswa_id != Auth::user()->siswa->id) {
            return abort(403);
        }
        
        if ($pendaftaran->status != 'pending') {
            return redirect()->back()->with('error', 'Hanya pendaftaran dengan status menunggu yang dapat dibatalkan.');
        }
        
        // Check if registration deadline has passed
        $today = Carbon::now()->startOfDay();
        $batasPendaftaran = Carbon::parse($pendaftaran->acara->batas_pendaftaran)->endOfDay();
        
        if ($today->gt($batasPendaftaran)) {
            return redirect()->back()->with('error', 'Maaf, batas waktu pembatalan sudah berakhir.');
        }
        
        $pendaftaran->delete();
        
        return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}