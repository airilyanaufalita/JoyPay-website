<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role_id', 2); // Hanya user biasa

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_filter')) {
            if ($request->date_filter == 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->date_filter == 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->date_filter == 'month') {
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
            }
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $pendingUsers = $query->latest()->paginate(10);

        $stats = [
            'total' => User::where('role_id', 2)->count(),
            'pending' => User::where('role_id', 2)->where('status', 'pending')->count(),
            'approved' => User::where('role_id', 2)->where('status', 'approved')->count(),
            'rejected' => User::where('role_id', 2)->where('status', 'rejected')->count(),
        ];

        return view('admin.konfirmasi-pendaftaran', compact('pendingUsers', 'stats'));
    }

    public function getData(Request $request)
    {
        try {
            $query = User::where('role_id', 2);

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->has('type') && $request->type != '') {
                $query->where('type', $request->type);
            }

            if ($request->has('date_filter') && $request->date_filter != '') {
                switch ($request->date_filter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year);
                        break;
                }
            }

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $registrations = $query->orderBy('created_at', 'desc')->get();

            $stats = [
                'total' => User::where('role_id', 2)->count(),
                'pending' => User::where('role_id', 2)->where('status', 'pending')->count(),
                'approved' => User::where('role_id', 2)->where('status', 'approved')->count(),
                'rejected' => User::where('role_id', 2)->where('status', 'rejected')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $registrations,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting registration data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::where('role_id', 2)->findOrFail($id);
            return response()->json(['success' => true, 'data' => $user]);
        } catch (\Exception $e) {
            Log::error('Error showing user: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $user = User::where('role_id', 2)->findOrFail($id);

            if ($user->status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Pendaftaran sudah diproses']);
            }

            $user->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // Sementara nonaktifkan email dulu
            // try {
            //     Mail::to($user->email)->send(new RegistrationApproved($user));
            // } catch (\Exception $e) {
            //     Log::error('Gagal mengirim email persetujuan: ' . $e->getMessage());
            // }

            return response()->json(['success' => true, 'message' => 'Pendaftaran disetujui']);

        } catch (\Exception $e) {
            Log::error('Error approving registration: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'rejection_reason' => ['required', 'string'],
                'improvement_suggestion' => ['nullable', 'string'],
            ]);

            $user = User::where('role_id', 2)->findOrFail($id);

            if ($user->status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Pendaftaran sudah diproses']);
            }

            $user->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'improvement_suggestion' => $request->improvement_suggestion,
                'rejected_by' => Auth::id(),
                'rejected_at' => now(),
            ]);

            // Sementara nonaktifkan email dulu
            // try {
            //     Mail::to($user->email)->send(new RegistrationRejected($user));
            // } catch (\Exception $e) {
            //     Log::error('Gagal mengirim email penolakan: ' . $e->getMessage());
            // }

            return response()->json(['success' => true, 'message' => 'Pendaftaran ditolak']);

        } catch (\Exception $e) {
            Log::error('Error rejecting registration: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function bulkApprove(Request $request)
    {
        try {
            $request->validate([
                'ids' => ['required', 'array'],
                'ids.*' => ['exists:users,id'],
            ]);

            $count = 0;
            foreach ($request->ids as $id) {
                $user = User::where('role_id', 2)->find($id);
                if ($user && $user->status === 'pending') {
                    $user->update([
                        'status' => 'approved',
                        'approved_by' => Auth::id(),
                        'approved_at' => now(),
                    ]);

                    $count++;
                }
            }

            return response()->json(['success' => true, 'message' => "$count pendaftaran disetujui"]);

        } catch (\Exception $e) {
            Log::error('Error bulk approving: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }
}