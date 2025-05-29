<?php

namespace App\Http\Controllers\WakilKesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;

class AcaraApprovalController extends Controller
{
    public function index()
    {
        $acaras = Acara::latest()->get();
        return view('wakil_kesiswaan.acara.index', compact('acaras'));
    }

    public function show(Acara $acara)
    {
        return view('wakil_kesiswaan.acara.show', compact('acara'));
    }

    public function approve(Acara $acara)
    {
        $acara->update(['status' => 'disetujui']);
        return redirect()->route('wakil_kesiswaan.acara.index')->with('success', 'Acara berhasil disetujui.');
    }

    public function reject(Request $request, Acara $acara)
    {
        $acara->update(['status' => 'ditolak']);
        return redirect()->route('wakil_kesiswaan.acara.index')->with('success', 'Acara berhasil ditolak.');
    }
}