<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    // Show all registrations with optional filtering
    public function all(Request $request)
    {
        $panitiaId = Auth::user()->panitia->id;
        
        // Get all acara created by this panitia for the filter dropdown
        $acaras = Acara::where('panitia_id', $panitiaId)->get();
        
        // If acara_id is provided in request, filter by that acara
        $selectedAcaraId = $request->acara_id;
        
        $query = Pendaftaran::with(['acara', 'siswa.user'])
                    ->whereHas('acara', function($query) use ($panitiaId) {
                        $query->where('panitia_id', $panitiaId);
                    });
                    
        // Apply filter if selected
        if ($selectedAcaraId) {
            $query->where('acara_id', $selectedAcaraId);
        }
        
        // Get pendaftaran data
        $pendaftarans = $query->latest()->get();
        
        return view('panitia.pendaftar.all', compact('pendaftarans', 'acaras', 'selectedAcaraId'));
    }

    // List all registrations for a specific event
    public function index(Acara $acara)
    {
        // Security check - only show registrations for own events
        if ($acara->panitia_id != Auth::user()->panitia->id) {
            return abort(403);
        }
        
        $pendaftarans = $acara->pendaftarans()->with('siswa.user')->get();
        
        return view('panitia.pendaftar.index', compact('acara', 'pendaftarans'));
    }

    // Update status of registration (approve/reject)
    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        // Security check - only update registrations for own events
        if ($pendaftaran->acara->panitia_id != Auth::user()->panitia->id) {
            return abort(403);
        }
        
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak',
        ]);
        
        $pendaftaran->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->status == 'ditolak' ? $request->alasan_penolakan : null,
        ]);
        
        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}