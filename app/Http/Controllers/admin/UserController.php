<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\WakilKesiswaan;
use App\Models\Panitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }
    
    public function create()
    {
        return view('admin.user.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,siswa,panitia,wakil_kesiswaan',
        ]);
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
            
            // Buat data tambahan berdasarkan role
            if ($request->role === 'siswa') {
                $request->validate([
                    'nis' => 'required|string|unique:siswa',
                    'jurusan' => 'required|string',
                    'kelas' => 'required|string',
                ]);
                
                Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $request->nis,
                    'jurusan' => $request->jurusan,
                    'kelas' => $request->kelas,
                ]);
            } elseif ($request->role === 'wakil_kesiswaan') {
                $request->validate([
                    'nip' => 'required|string|unique:wakil_kesiswaan',
                ]);
                
                WakilKesiswaan::create([
                    'user_id' => $user->id,
                    'nip' => $request->nip,
                ]);
            } elseif ($request->role === 'panitia') {
                // Tambahkan validasi jika ada field khusus untuk panitia
                Panitia::create([
                    'user_id' => $user->id,
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,siswa,panitia,wakil_kesiswaan',
        ]);
        
        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
        }
        
        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            
            // Jika role berubah, kita perlu menangani data role lama dan baru
            if ($user->role !== $request->role) {
                // Hapus data role lama jika ada
                if ($user->role === 'siswa' && $user->siswa) {
                    $user->siswa->delete();
                } elseif ($user->role === 'wakil_kesiswaan' && $user->wakilKesiswaan) {
                    $user->wakilKesiswaan->delete();
                } elseif ($user->role === 'panitia' && $user->panitia) {
                    $user->panitia->delete();
                }
                
                // Buat data role baru
                if ($request->role === 'siswa') {
                    $request->validate([
                        'nis' => 'required|string|unique:siswa',
                        'jurusan' => 'required|string',
                        'kelas' => 'required|string',
                    ]);
                    
                    Siswa::create([
                        'user_id' => $user->id,
                        'nis' => $request->nis,
                        'jurusan' => $request->jurusan,
                        'kelas' => $request->kelas,
                    ]);
                } elseif ($request->role === 'wakil_kesiswaan') {
                    $request->validate([
                        'nip' => 'required|string|unique:wakil_kesiswaan',
                    ]);
                    
                    WakilKesiswaan::create([
                        'user_id' => $user->id,
                        'nip' => $request->nip,
                    ]);
                } elseif ($request->role === 'panitia') {
                    Panitia::create([
                        'user_id' => $user->id,
                    ]);
                }
            } else {
                // Update data role yang sudah ada
                if ($request->role === 'siswa' && $user->siswa) {
                    $request->validate([
                        'nis' => 'required|string|unique:siswa,nis,'.$user->siswa->id,
                        'jurusan' => 'required|string',
                        'kelas' => 'required|string',
                    ]);
                    
                    $user->siswa->update([
                        'nis' => $request->nis,
                        'jurusan' => $request->jurusan,
                        'kelas' => $request->kelas,
                    ]);
                } elseif ($request->role === 'wakil_kesiswaan' && $user->wakilKesiswaan) {
                    $request->validate([
                        'nip' => 'required|string|unique:wakil_kesiswaan,nip,'.$user->wakilKesiswaan->id,
                    ]);
                    
                    $user->wakilKesiswaan->update([
                        'nip' => $request->nip,
                    ]);
                }
            }
            
            $user->role = $request->role;
            $user->save();
            
            DB::commit();
            return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['msg' => 'Anda tidak dapat menghapus akun yang sedang digunakan!']);
        }
        
        try {
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}