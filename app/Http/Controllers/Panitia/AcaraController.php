<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AcaraController extends Controller
{
    public function index()
    {
        $acaras = Acara::where('panitia_id', Auth::user()->panitia->id)->latest()->get();
        return view('panitia.acara.index', compact('acaras'));
    }

    public function create()
    {
        return view('panitia.acara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'batas_pendaftaran' => 'required|date|before_or_equal:tanggal_acara',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/acara', $imageName);
            $data['image'] = $imageName;
        }

        // Set panitia_id berdasarkan user yang login
        $data['panitia_id'] = Auth::user()->panitia->id;
        $data['status'] = 'pending';

        $acara = Acara::create($data);

        return redirect()->route('panitia.acara.index')->with('success', 'Acara berhasil dibuat dan menunggu persetujuan.');
    }

    public function show(Acara $acara)
    {
        // Pastikan hanya panitia yang membuat acara yang bisa melihat
        if ($acara->panitia_id != Auth::user()->panitia->id) {
            return abort(403);
        }

        return view('panitia.acara.show', compact('acara'));
    }

    public function edit(Acara $acara)
    {
        // Pastikan hanya panitia yang membuat acara yang bisa mengedit
        if ($acara->panitia_id != Auth::user()->panitia->id) {
            return abort(403);
        }

        // Acara yang sudah disetujui atau ditolak tidak bisa diedit
        if ($acara->status != 'pending') {
            return redirect()->route('panitia.acara.index')->with('error', 'Acara yang sudah disetujui atau ditolak tidak dapat diedit.');
        }

        return view('panitia.acara.edit', compact('acara'));
    }

    public function update(Request $request, Acara $acara)
    {
        // Pastikan hanya panitia yang membuat acara yang bisa mengupdate
        if ($acara->panitia_id != Auth::user()->panitia->id) {
            return abort(403);
        }

        // Acara yang sudah disetujui atau ditolak tidak bisa diupdate
        if ($acara->status != 'pending') {
            return redirect()->route('panitia.acara.index')->with('error', 'Acara yang sudah disetujui atau ditolak tidak dapat diubah.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_acara' => 'required|date',
            'batas_pendaftaran' => 'required|date|before_or_equal:tanggal_acara',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('_token', '_method', 'image');

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($acara->image) {
                Storage::delete('public/acara/' . $acara->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/acara', $imageName);
            $data['image'] = $imageName;
        }

        $acara->update($data);

        return redirect()->route('panitia.acara.index')->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(Acara $acara)
    {
        // Pastikan hanya panitia yang membuat acara yang bisa menghapus
        if ($acara->panitia_id != Auth::user()->panitia->id) {
            return abort(403);
        }

        // Acara yang sudah disetujui tidak bisa dihapus
        if ($acara->status == 'disetujui') {
            return redirect()->route('panitia.acara.index')->with('error', 'Acara yang sudah disetujui tidak dapat dihapus.');
        }

        // Hapus gambar jika ada
        if ($acara->image) {
            Storage::delete('public/acara/' . $acara->image);
        }

        $acara->delete();

        return redirect()->route('panitia.acara.index')->with('success', 'Acara berhasil dihapus.');
    }
}