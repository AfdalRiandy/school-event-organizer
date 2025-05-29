<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\WakilKesiswaanController;
use App\Http\Controllers\Admin\AcaraController as AdminAcaraController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Siswa\AcaraController as SiswaAcaraController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // acara routes
    Route::get('/admin/acara', [App\Http\Controllers\Admin\AcaraController::class, 'index'])->name('admin.acara.index');
    Route::get('/admin/acara/{acara}', [App\Http\Controllers\Admin\AcaraController::class, 'show'])->name('admin.acara.show');
    Route::delete('/admin/acara/{acara}', [App\Http\Controllers\Admin\AcaraController::class, 'destroy'])->name('admin.acara.destroy');
    
    // user routes
    Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user.index');

    Route::get('/admin/user/create', [AdminUserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user', [AdminUserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/{user}', [AdminUserController::class, 'show'])->name('admin.user.show');
    Route::get('/admin/user/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/{user}', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/{user}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
});

// Siswa routes
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    
    //acara routes
    Route::get('/siswa/acara', [SiswaAcaraController::class, 'index'])->name('siswa.acara.index');
    Route::get('/siswa/acara/{acara}', [SiswaAcaraController::class, 'show'])->name('siswa.acara.show');
    
    // Pendaftaran routes
    Route::get('/siswa/pendaftaran', [\App\Http\Controllers\Siswa\PendaftaranController::class, 'index'])->name('siswa.pendaftaran.index');
    Route::post('/siswa/pendaftaran', [\App\Http\Controllers\Siswa\PendaftaranController::class, 'store'])->name('siswa.pendaftaran.store');
    Route::delete('/siswa/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Siswa\PendaftaranController::class, 'destroy'])->name('siswa.pendaftaran.delete');
});

// Panitia routes
Route::middleware(['auth', 'role:panitia'])->group(function () {
    Route::get('/panitia/dashboard', [PanitiaController::class, 'dashboard'])->name('panitia.dashboard');
    
    Route::get('/panitia/acara', [\App\Http\Controllers\Panitia\AcaraController::class, 'index'])->name('panitia.acara.index');
    Route::get('/panitia/acara/create', [\App\Http\Controllers\Panitia\AcaraController::class, 'create'])->name('panitia.acara.create');
    Route::post('/panitia/acara', [\App\Http\Controllers\Panitia\AcaraController::class, 'store'])->name('panitia.acara.store');
    Route::get('/panitia/acara/{acara}', [\App\Http\Controllers\Panitia\AcaraController::class, 'show'])->name('panitia.acara.show');
    Route::get('/panitia/acara/{acara}/edit', [\App\Http\Controllers\Panitia\AcaraController::class, 'edit'])->name('panitia.acara.edit');
    Route::put('/panitia/acara/{acara}', [\App\Http\Controllers\Panitia\AcaraController::class, 'update'])->name('panitia.acara.update');
    Route::delete('/panitia/acara/{acara}', [\App\Http\Controllers\Panitia\AcaraController::class, 'destroy'])->name('panitia.acara.destroy');   
    
    // Pendaftar routes
    Route::get('/panitia/pendaftar', [\App\Http\Controllers\Panitia\PendaftarController::class, 'all'])->name('panitia.pendaftar.all');
    Route::get('/panitia/pendaftar/{acara}', [\App\Http\Controllers\Panitia\PendaftarController::class, 'index'])->name('panitia.pendaftar.index');
    Route::post('/panitia/pendaftar/{pendaftaran}/update-status', [\App\Http\Controllers\Panitia\PendaftarController::class, 'updateStatus'])->name('panitia.pendaftar.update-status');
    Route::get('/panitia/pendaftar/status', function() {
        return view('panitia.pendaftar.status');
    })->name('panitia.pendaftar.status');
});


// Wakil Kesiswaan routes
Route::middleware(['auth', 'role:wakil_kesiswaan'])->group(function () {
    Route::get('/wakil-kesiswaan/dashboard', [WakilKesiswaanController::class, 'dashboard'])->name('wakil_kesiswaan.dashboard');

    // histori routes
    Route::get('/wakil-kesiswaan/histori', [WakilKesiswaanController::class, 'histori'])->name('wakil_kesiswaan.histori');
    
    // acara routes
    Route::get('/wakil_kesiswaan/acara', [\App\Http\Controllers\WakilKesiswaan\AcaraApprovalController::class, 'index'])->name('wakil_kesiswaan.acara.index');
    Route::get('/wakil_kesiswaan/acara/{acara}', [\App\Http\Controllers\WakilKesiswaan\AcaraApprovalController::class, 'show'])->name('wakil_kesiswaan.acara.show');
    Route::post('/wakil_kesiswaan/acara/{acara}/approve', [\App\Http\Controllers\WakilKesiswaan\AcaraApprovalController::class, 'approve'])->name('wakil_kesiswaan.acara.approve');
    Route::post('/wakil_kesiswaan/acara/{acara}/reject', [\App\Http\Controllers\WakilKesiswaan\AcaraApprovalController::class, 'reject'])->name('wakil_kesiswaan.acara.reject');
});


require __DIR__.'/auth.php';