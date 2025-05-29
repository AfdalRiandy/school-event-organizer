<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    public function index()
    {
        // Hanya tampilkan acara yang statusnya disetujui
        $acaras = Acara::where('status', 'disetujui')->latest()->get();
        return view('siswa.acara.index', compact('acaras'));
    }

    public function show(Acara $acara)
    {
        // Pastikan hanya acara yang disetujui yang bisa dilihat
        if ($acara->status != 'disetujui') {
            return abort(404);
        }
        return view('siswa.acara.show', compact('acara'));
    }
}