<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all events with their relationships
        $acaras = Acara::with(['panitia.user', 'pendaftarans'])->latest()->get();
        
        return view('admin.acara.index', compact('acaras'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Acara $acara)
    {
        // Load relationships
        $acara->load(['panitia.user', 'pendaftarans.siswa.user']);
        
        return view('admin.acara.show', compact('acara'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acara $acara)
    {
        // Delete the image if exists
        if ($acara->image) {
            Storage::delete('public/acara/' . $acara->image);
        }
        
        // Delete the event and all related registrations (cascade delete should be set up in the migration)
        $acara->delete();
        
        return redirect()->route('admin.acara.index')->with('success', 'Acara berhasil dihapus.');
    }
}