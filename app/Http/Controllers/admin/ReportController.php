<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Acara;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    /**
     * Generate user reports
     */
    public function users(Request $request)
    {
        $role = $request->input('role');
        $period = $request->input('period');
        
        $query = User::query();
        
        // Apply role filter
        if ($role) {
            $query->where('role', $role);
        }
        
        // Apply period filter
        if ($period == 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($period == 'year') {
            $query->whereYear('created_at', now()->year);
        }
        
        $users = $query->get();
        
        $data = [
            'users' => $users,
            'title' => 'Laporan Pengguna',
            'date' => now()->format('d-m-Y'),
            'filters' => [
                'role' => $role,
                'period' => $period
            ]
        ];
        
        $pdf = PDF::loadView('admin.reports.users', $data);
        return $pdf->stream('laporan-pengguna-' . now()->format('d-m-Y') . '.pdf');
    }
    
    /**
     * Generate event reports
     */
    public function events(Request $request)
    {
        $status = $request->input('status');
        $period = $request->input('period');
        
        $query = Acara::with(['panitia.user', 'pendaftarans']);
        
        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }
        
        // Apply period filter
        if ($period == 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($period == 'upcoming') {
            $query->where('tanggal_acara', '>=', now()->format('Y-m-d'));
        } elseif ($period == 'past') {
            $query->where('tanggal_acara', '<', now()->format('Y-m-d'));
        }
        
        $acaras = $query->get();
        
        $data = [
            'acaras' => $acaras,
            'title' => 'Laporan Acara',
            'date' => now()->format('d-m-Y'),
            'filters' => [
                'status' => $status,
                'period' => $period
            ]
        ];
        
        $pdf = PDF::loadView('admin.reports.events', $data);
        return $pdf->stream('laporan-acara-' . now()->format('d-m-Y') . '.pdf');
    }
    
    /**
     * Generate registration reports
     */
    public function registrations(Request $request)
    {
        $status = $request->input('status');
        $period = $request->input('period');
        
        $query = Pendaftaran::with(['acara', 'siswa.user']);
        
        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }
        
        // Apply period filter
        if ($period == 'today') {
            $query->whereDate('created_at', now()->format('Y-m-d'));
        } elseif ($period == 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period == 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }
        
        $pendaftarans = $query->get();
        
        $data = [
            'pendaftarans' => $pendaftarans,
            'title' => 'Laporan Pendaftaran',
            'date' => now()->format('d-m-Y'),
            'filters' => [
                'status' => $status,
                'period' => $period
            ]
        ];
        
        $pdf = PDF::loadView('admin.reports.registrations', $data);
        return $pdf->stream('laporan-pendaftaran-' . now()->format('d-m-Y') . '.pdf');
    }
    
    /**
     * Generate summary report
     */
    public function summary(Request $request)
    {
        $period = $request->input('period', 'all');
        
        // Get user statistics
        $users = User::selectRaw('role, COUNT(*) as count')
                      ->groupBy('role')
                      ->get()
                      ->pluck('count', 'role')
                      ->toArray();
        
        // Get event statistics
        $acaras = Acara::selectRaw('status, COUNT(*) as count')
                        ->groupBy('status')
                        ->get()
                        ->pluck('count', 'status')
                        ->toArray();
        
        // Get registration statistics
        $pendaftarans = Pendaftaran::selectRaw('status, COUNT(*) as count')
                                   ->groupBy('status')
                                   ->get()
                                   ->pluck('count', 'status')
                                   ->toArray();
        
        $data = [
            'users' => $users,
            'acaras' => $acaras,
            'pendaftarans' => $pendaftarans,
            'title' => 'Laporan Ringkasan Sistem',
            'date' => now()->format('d-m-Y'),
            'period' => $period
        ];
        
        $pdf = PDF::loadView('admin.reports.summary', $data);
        return $pdf->stream('laporan-ringkasan-' . now()->format('d-m-Y') . '.pdf');
    }
    
    /**
     * Generate custom report
     */
    public function custom(Request $request)
    {
        $type = $request->input('type', 'all');
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');
        $sort = $request->input('sort', 'latest');
        
        // Data arrays
        $users = [];
        $acaras = [];
        $pendaftarans = [];
        
        // Process based on type
        if ($type == 'all' || $type == 'users') {
            $query = User::query();
            
            if ($dateStart && $dateEnd) {
                $query->whereBetween('created_at', [$dateStart, $dateEnd]);
            }
            
            if ($sort == 'latest') {
                $query->latest();
            } elseif ($sort == 'oldest') {
                $query->oldest();
            } elseif ($sort == 'name') {
                $query->orderBy('name');
            }
            
            $users = $query->get();
        }
        
        if ($type == 'all' || $type == 'events') {
            $query = Acara::with(['panitia.user', 'pendaftarans']);
            
            if ($dateStart && $dateEnd) {
                $query->whereBetween('created_at', [$dateStart, $dateEnd]);
            }
            
            if ($sort == 'latest') {
                $query->latest();
            } elseif ($sort == 'oldest') {
                $query->oldest();
            } elseif ($sort == 'name') {
                $query->orderBy('judul');
            }
            
            $acaras = $query->get();
        }
        
        if ($type == 'all' || $type == 'registrations') {
            $query = Pendaftaran::with(['acara', 'siswa.user']);
            
            if ($dateStart && $dateEnd) {
                $query->whereBetween('created_at', [$dateStart, $dateEnd]);
            }
            
            if ($sort == 'latest') {
                $query->latest();
            } elseif ($sort == 'oldest') {
                $query->oldest();
            }
            
            $pendaftarans = $query->get();
        }
        
        $data = [
            'users' => $users,
            'acaras' => $acaras,
            'pendaftarans' => $pendaftarans,
            'title' => 'Laporan Kustom',
            'date' => now()->format('d-m-Y'),
            'filters' => [
                'type' => $type,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'sort' => $sort
            ]
        ];
        
        $pdf = PDF::loadView('admin.reports.custom', $data);
        return $pdf->stream('laporan-kustom-' . now()->format('d-m-Y') . '.pdf');
    }
}