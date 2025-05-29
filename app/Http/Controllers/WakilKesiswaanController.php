<?php

namespace App\Http\Controllers;
use App\Models\Acara;
use App\Models\Pendaftaran;   

class WakilKesiswaanController extends Controller
{
    public function dashboard()
    {
        return view('wakil_kesiswaan.dashboard');
    }

    public function histori()
{
    // Get all registrations with relationships
    $pendaftarans = Pendaftaran::with(['acara.panitia.user', 'siswa.user'])
        ->latest()
        ->get();
    
    // Get all events for filtering
    $acaras = Acara::orderBy('judul')->get();
    
    return view('wakil_kesiswaan.histori.index', compact('pendaftarans', 'acaras'));
}
}