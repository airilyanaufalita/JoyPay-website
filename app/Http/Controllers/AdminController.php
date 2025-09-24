<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;
use App\Models\User;
use App\Models\KloterMember;
use App\Models\Testimoni;
use App\Models\Kloter;
use Illuminate\Support\Facades\Log;
use App\Models\KloterMemberRequest;
use App\models\KloterRule;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;

class AdminController extends Controller
{
    /**
     * Show admin login form
     * Menampilkan form login untuk admin
     */
    public function showLoginForm()
    {
        return view('pages.admin.loginadmin');
    }

    /**
     * Handle admin login
     * Memproses login admin dengan autentikasi
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                Log::info('Admin login successful', ['email' => $request->email]);
                return redirect()->route('admin.dashboard');
            }

            Log::warning('Admin login failed', ['email' => $request->email]);
            return back()->withErrors([
                'email' => 'Email atau password salah!',
            ])->withInput($request->only('email'));
        } catch (ValidationException $e) {
            Log::error('Admin login validation error', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput($request->only('email'));
        }
    }

    /**
     * Handle admin logout
     * Memproses logout admin dan reset session
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info('Admin logged out');
        return redirect()->route('admin.login');
    }

    /**
     * Show admin dashboard
     * Menampilkan dashboard admin dengan statistik user
     */
    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access to admin dashboard');
            return redirect()->route('admin.login');
        }

        try {
            // Calculate dashboard statistics
            $totalUsers = User::count();
            $pendingRegistrations = User::where('status', 'pending')->count();
            $approvedUsers = User::where('status', 'approved')->count();
            $rejectedUsers = User::where('status', 'rejected')->count();

            // Recent registrations
            $recentRegistrations = User::orderBy('created_at', 'desc')->limit(5)->get();

            return view('pages.admin.dashboard', compact(
                'totalUsers',
                'pendingRegistrations',
                'approvedUsers',
                'rejectedUsers',
                'recentRegistrations'
            ));
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return view('pages.admin.dashboard', [
                'totalUsers' => 0,
                'pendingRegistrations' => 0,
                'approvedUsers' => 0,
                'rejectedUsers' => 0,
                'recentRegistrations' => collect([])
            ])->with('error', 'Gagal memuat dashboard');
        }
    }

    /**
     * Show registration confirmation page
     * Menampilkan halaman konfirmasi pendaftaran user
     */
    public function konfirmasiPendaftaran(Request $request)
    {
        // Debug: Cek apakah ada data user dengan status pending
        Log::info('Menampilkan halaman konfirmasi pendaftaran');
        Log::info('Total user: ' . User::count());
        Log::info('User pending: ' . User::where('status', 'pending')->count());
        
        $query = User::where('status', 'pending');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tipe
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date_filter') && $request->date_filter != '') {
            if ($request->date_filter == 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->date_filter == 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->date_filter == 'month') {
                $query->whereMonth('created_at', now()->month);
            }
        }
        
        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        
        // Debug: Cek hasil query
        Log::info('Jumlah user yang ditemukan: ' . $users->count());
        foreach ($users as $user) {
            Log::info('User: ' . $user->name . ' - ' . $user->email . ' - ' . $user->status);
        }
        
        // Hitung statistik
        $stats = [
            'total' => User::count(),
            'pending' => User::where('status', 'pending')->count(),
            'approved' => User::where('status', 'approved')->count(),
            'rejected' => User::where('status', 'rejected')->count(),
        ];
        
        // Perbaikan path view
        return view('pages.admin.konfirmasi_pendaftaran', compact('users', 'stats'));
    }

    /**
     * Approve a single registration
     * Menyetujui pendaftaran user tertentu
     */
    public function approveRegistration($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if ($user->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah dalam status ' . $user->status
                ]);
            }

            $user->update([
                'status' => 'approved',
                'approved_by' => auth('admin')->id(),
                'approved_at' => now()
            ]);

            // Kirim email notifikasi ke user
            Mail::to($user->email)->send(new RegistrationApproved($user));

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil disetujui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Reject a single registration
     * Menolak pendaftaran user tertentu
     */
    public function rejectRegistration(Request $request, $id)
    {
        try {
            $request->validate([
                'rejection_reason' => 'required|string',
                'improvement_suggestion' => 'nullable|string'
            ]);

            $user = User::findOrFail($id);
            
            if ($user->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah dalam status ' . $user->status
                ]);
            }

            $user->update([
                'status' => 'rejected',
                'rejected_by' => auth('admin')->id(),
                'rejected_at' => now(),
                'rejection_reason' => $request->rejection_reason,
                'improvement_suggestion' => $request->improvement_suggestion
            ]);

            // Kirim email notifikasi ke user
            Mail::to($user->email)->send(new RegistrationRejected(
                $user, 
                $request->rejection_reason, 
                $request->improvement_suggestion
            ));

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil ditolak'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Bulk approve multiple registrations
     * Menyetujui beberapa pendaftaran sekaligus
     */
    public function bulkApproveRegistrations(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:users,id'
            ]);

            $users = User::whereIn('id', $request->ids)
                        ->where('status', 'pending')
                        ->get();

            foreach ($users as $user) {
                $user->update([
                    'status' => 'approved',
                    'approved_by' => auth('admin')->id(),
                    'approved_at' => now()
                ]);

                // Kirim email notifikasi
                Mail::to($user->email)->send(new RegistrationApproved($user));
            }

            return response()->json([
                'success' => true,
                'message' => count($users) . ' pendaftaran berhasil disetujui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    public function getRegistrationsData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            // Get query parameters for filtering
            $status = $request->get('status');
            $type = $request->get('type');
            $search = $request->get('search');
            $date_filter = $request->get('date_filter');

            // Build query
            $query = User::with(['approvedBy', 'rejectedBy']);

            // Apply filters
            if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }

            if ($type && in_array($type, ['regular', 'premium', 'vip'])) {
                $query->where('type', $type);
            }

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('username', 'LIKE', "%{$search}%");
                });
            }

            if ($date_filter) {
                switch($date_filter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'week':
                        $query->where('created_at', '>=', now()->subWeek());
                        break;
                    case 'month':
                        $query->where('created_at', '>=', now()->subMonth());
                        break;
                }
            }

            // Get results
            $registrations = $query->orderBy('created_at', 'desc')->get();

            // Calculate statistics
            $stats = [
                'total' => User::count(),
                'pending' => User::where('status', 'pending')->count(),
                'approved' => User::where('status', 'approved')->count(),
                'rejected' => User::where('status', 'rejected')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $registrations,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Get registrations data error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data registrasi'
            ], 500);
        }
    }
    /**
     * Get registration detail
     * Mengambil detail pendaftaran user untuk modal
     */
    public function getRegistrationDetail($id)
    {
        try {
            $user = User::with(['approvedBy', 'rejectedBy'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
    }


    /**
     * Show payment confirmation page
     * Menampilkan halaman konfirmasi pembayaran (placeholder)
     */
    public function konfirmasi()
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access to konfirmasi pembayaran');
            return redirect()->route('admin.login');
        }

        try {
            // TODO: Implement actual payment logic with Payment model
            $users = User::with('kloterMembers')->paginate(10);
            
            return view('pages.admin.konfirmasi_pembayaran', compact('users'));
        } catch (\Exception $e) {
            Log::error('Konfirmasi pembayaran error: ' . $e->getMessage());
            return view('pages.admin.konfirmasi_pembayaran', ['users' => collect([])])
                ->with('error', 'Gagal memuat data pembayaran');
        }
    }

    /**
     * Show user management page
     * Menampilkan halaman manajemen user dengan filter
     */
    public function manajemenUser(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access to manajemen user');
            return redirect()->route('admin.login');
        }

        try {
            // Get query parameters for filtering
            $status = $request->get('status');
            $role = $request->get('role');
            $search = $request->get('search');

            // Build query
            $query = User::with(['role']);

            // Apply filters
            if ($status && in_array($status, ['active', 'inactive', 'suspended', 'pending'])) {
                $query->where('status', $status);
            }

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('username', 'LIKE', "%{$search}%");
                });
            }

            // Get paginated results
            $users = $query->orderBy('created_at', 'desc')->paginate(15);

            // Calculate statistics
            $totalUsers = User::count();
            $activeUsers = User::where('status', 'approved')->count();
            $pendingUsers = User::where('status', 'pending')->count();
            $suspendedUsers = User::where('status', 'suspended')->count();

            return view('pages.admin.manajemen_user', compact(
                'users',
                'totalUsers',
                'activeUsers',
                'pendingUsers',
                'suspendedUsers'
            ));
        } catch (\Exception $e) {
            Log::error('Manajemen user error: ' . $e->getMessage());
            return view('pages.admin.manajemen_user', [
                'users' => collect([]),
                'totalUsers' => 0,
                'activeUsers' => 0,
                'pendingUsers' => 0,
                'suspendedUsers' => 0
            ])->with('error', 'Gagal memuat data user');
        }
    }

    /**
     * Show schedule and payment page
     * Menampilkan halaman jadwal pembayaran
     */
    public function jadwalPembayaran()
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access to jadwal pembayaran');
            return redirect()->route('admin.login');
        }

        try {
            // Ambil data dari database alih-alih dummy
            $pendingPayments = KloterMember::where('status', 'approved')
                ->whereDoesntHave('payments') // Asumsi ada relasi payments
                ->count();
            $overduePayments = KloterMember::where('status', 'approved')
                ->whereHas('payments', function($q) {
                    $q->where('due_date', '<', now())->where('status', 'pending');
                })->count();
            $paidToday = KloterMember::whereHas('payments', function($q) {
                $q->whereDate('paid_at', today())->where('status', 'paid');
            })->count();
            $upcomingLotteries = Kloter::where('status', 'running')
                ->where('draw_schedule', '>=', now())
                ->count();

            // Ambil daftar pembayaran
            $pendingPaymentsList = KloterMember::where('status', 'approved')
                ->whereDoesntHave('payments')
                ->with(['user', 'kloter'])
                ->limit(10)
                ->get();
            $overduePaymentsList = KloterMember::where('status', 'approved')
                ->whereHas('payments', function($q) {
                    $q->where('due_date', '<', now())->where('status', 'pending');
                })
                ->with(['user', 'kloter'])
                ->limit(10)
                ->get();
            $paidPayments = KloterMember::whereHas('payments', function($q) {
                $q->where('status', 'paid');
            })
                ->with(['user', 'kloter'])
                ->limit(10)
                ->get();
            $activeArisans = Kloter::whereIn('status', ['open', 'running', 'full'])
                ->with('members')
                ->limit(10)
                ->get();

            return view('pages.admin.jadwal_pembayaran', compact(
                'pendingPayments',
                'overduePayments',
                'paidToday',
                'upcomingLotteries',
                'pendingPaymentsList',
                'overduePaymentsList',
                'paidPayments',
                'activeArisans'
            ));
        } catch (\Exception $e) {
            Log::error('Jadwal pembayaran error: ' . $e->getMessage());
            return view('pages.admin.jadwal_pembayaran', [
                'pendingPayments' => 0,
                'overduePayments' => 0,
                'paidToday' => 0,
                'upcomingLotteries' => 0,
                'pendingPaymentsList' => collect([]),
                'overduePaymentsList' => collect([]),
                'paidPayments' => collect([]),
                'activeArisans' => collect([])
            ])->with('error', 'Gagal memuat data jadwal pembayaran');
        }
    }

    /**
     * Show active arisan page
     * Menampilkan halaman arisan aktif dengan data dari database
     */
public function arisanAktif()
{
    if (!Auth::guard('admin')->check()) {
        Log::warning('Unauthorized access to arisan aktif');
        return redirect()->route('admin.login');
    }

    try {
        // Calculate statistics for the new view
        $totalKloters = Kloter::count();
        $activeKloters = Kloter::where('status', 'open')->count();
        $fullKloters = Kloter::where('status', 'full')->count();
        $runningKloters = Kloter::where('status', 'running')->count();
        $completedKloters = Kloter::where('status', 'completed')->count();
        $totalValue = Kloter::whereIn('status', ['open', 'full', 'running'])->sum('nominal') / 1000000;
        $needAttention = Kloter::where('status', 'running')
            ->where('current_period', '>', 0)
            ->whereHas('members', function($q) {
                $q->where('payment_status', 'overdue');
            })->count();

        // Get kloters with pagination and filters
        $query = Kloter::with(['members.user']);
        
        // Apply filters if provided
        if (request('status')) {
            $query->where('status', request('status'));
        }
        if (request('category')) {
            $query->where('category', request('category'));
        }
        if (request('search')) {
            $query->where(function($q) {
                $search = request('search');
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $kloters = $query->orderBy('created_at', 'desc')->paginate(10);

        // Use the new view
        return view('pages.admin.arisan_aktif', compact(
            'kloters',
            'totalKloters',
            'activeKloters',
            'fullKloters',
            'runningKloters',
            'completedKloters',
            'totalValue',
            'needAttention'
        ));

    } catch (\Exception $e) {
        Log::error('Arisan aktif error: ' . $e->getMessage());
        return view('pages.admin.arisan_aktif', [
            'kloters' => collect([]),
            'totalKloters' => 0,
            'activeKloters' => 0,
            'fullKloters' => 0,
            'runningKloters' => 0,
            'completedKloters' => 0,
            'totalValue' => 0,
            'needAttention' => 0
        ])->with('error', 'Gagal memuat data kloter');
    }
}

    /**
     * Show create kloter page
     * Menampilkan halaman untuk membuat kloter baru
     */
    public function buatKloter()
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access to buat kloter');
            return redirect()->route('admin.login');
        }

        return view('pages.admin.buat_kloter');
    }

    /**
     * Show kloter entry confirmation page
     * Menampilkan halaman konfirmasi masuk kloter
     */

// Di AdminController.php, GANTI bagian return view nya:

public function konfirmasiMasukKloter(Request $request)
{
    if (!Auth::guard('admin')->check()) {
        Log::warning('Unauthorized access to konfirmasi masuk kloter');
        return redirect()->route('admin.login');
    }

    try {
        Log::info('AdminController konfirmasiMasukKloter called');
        
        // Get query parameters for filtering
        $status = $request->get('status');
        $kloter_id = $request->get('kloter_id');
        $search = $request->get('search');

        // Build query for pending kloter member requests
        $query = KloterMemberRequest::with(['user', 'kloter']);

        // Apply filters
        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($kloter_id) {
            $query->where('kloter_id', $kloter_id);
        }

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        // Get paginated results
        $pendingJoins = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate statistics
        $totalRequests = KloterMemberRequest::count();
        $pendingCount = KloterMemberRequest::where('status', 'pending')->count();
        $approvedCount = KloterMemberRequest::where('status', 'approved')->count();
        $rejectedCount = KloterMemberRequest::where('status', 'rejected')->count();

        // Get all kloters for filter dropdown
        $kloters = Kloter::select('id', 'name')->orderBy('name')->get();

        Log::info('Data loaded successfully in AdminController', [
            'pendingJoins' => $pendingJoins->count(),
            'kloters' => $kloters->count()
        ]);

        // PERBAIKAN: Gunakan nama view yang sebenarnya ada (dengan underscore)
        return view('pages.admin.konfirmasi_masuk_kloter', compact(
            'pendingJoins',
            'totalRequests',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'kloters'
        ));
        
    } catch (\Exception $e) {
        Log::error('AdminController konfirmasi masuk kloter error: ' . $e->getMessage());
        
        // Return dengan data kosong jika error - dengan nama view yang benar
        return view('pages.admin.konfirmasi_masuk_kloter', [
            'pendingJoins' => collect([]),
            'totalRequests' => 0,
            'pendingCount' => 0,
            'approvedCount' => 0,
            'rejectedCount' => 0,
            'kloters' => collect([])
        ])->with('error', 'Gagal memuat data konfirmasi masuk kloter: ' . $e->getMessage());
    }
}

    /**
     * Approve kloter member request
     * Menyetujui permintaan masuk kloter
     */
public function approveMemberRequest(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        DB::beginTransaction();
        try {
            $memberRequest = KloterMemberRequest::with('kloter')->findOrFail($id);
            
            // Check if still pending
            if ($memberRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan sudah diproses sebelumnya'
                ], 400);
            }

            $kloter = $memberRequest->kloter;
            // Check if kloter is full
            if ($kloter->filled_slots >= $kloter->total_slots) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kloter sudah penuh'
                ], 400);
            }

            // Create KloterMember record
            $member = KloterMember::create([
                'kloter_id' => $memberRequest->kloter_id,
                'user_id' => $memberRequest->user_id,
                'slot_number' => $memberRequest->slot_number,
                'monthly_payment' => $memberRequest->monthly_payment,
                'status' => 'approved',
                'payment_status' => 'pending',
                'total_paid' => 0,
                'joined_at' => $memberRequest->joined_at,
                'verified_at' => now(),
                'verified_by' => Auth::guard('admin')->id(),
            ]);

            // Update request status
            $memberRequest->update([
                'status' => 'approved',
                'verified_at' => now(),
                'verified_by' => Auth::guard('admin')->id(),
            ]);

            // Increment filled_slots in kloter
            $kloter->increment('filled_slots');

            // Update kloter status if full
            if ($kloter->filled_slots >= $kloter->total_slots) {
                $kloter->update(['status' => 'full']);
            }

            DB::commit();
            Log::info('Member request approved', ['request_id' => $id, 'kloter_id' => $kloter->id, 'member_id' => $member->id]);
            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil disetujui',
                'data' => [
                    'request_id' => $memberRequest->id,
                    'member_id' => $member->id,
                    'status' => $member->status,
                    'kloter_filled_slots' => $kloter->filled_slots,
                    'kloter_status' => $kloter->status
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Approve member request error: Request not found', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Approve member request error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui permintaan'
            ], 500);
        }
    }

    /**
     * Reject kloter member request
     * Menolak permintaan masuk kloter
     */
public function rejectMemberRequest(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $request->validate([
                'rejection_note' => 'nullable|string|max:500'
            ]);

            $memberRequest = KloterMemberRequest::findOrFail($id);
            
            // Check if still pending
            if ($memberRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan sudah diproses sebelumnya'
                ], 400);
            }

            // Update request status
            $memberRequest->update([
                'status' => 'rejected',
                'verified_at' => now(),
                'verified_by' => Auth::guard('admin')->id(),
                'rejection_note' => $request->rejection_note
            ]);

            Log::info('Member request rejected', ['request_id' => $id]);
            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil ditolak',
                'data' => [
                    'request_id' => $memberRequest->id,
                    'status' => $memberRequest->status
                ]
            ]);

        } catch (ValidationException $e) {
            Log::error('Reject member request validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Reject member request error: Request not found', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Reject member request error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak permintaan'
            ], 500);
        }
    }

    /**
     * Get member request detail
     * Mengambil detail permintaan masuk kloter untuk modal
     */
public function getMemberRequestDetail($id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $memberRequest = KloterMemberRequest::with(['user', 'kloter', 'verifiedBy'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $memberRequest->id,
                    'user' => [
                        'name' => $memberRequest->user->name,
                        'email' => $memberRequest->user->email,
                        'username' => $memberRequest->user->username,
                        'phone' => $memberRequest->user->phone ?? '-',
                    ],
                    'kloter' => [
                        'name' => $memberRequest->kloter->name,
                        'nominal' => $memberRequest->kloter->nominal,
                        'duration_value' => $memberRequest->kloter->duration_value,
                        'duration_unit' => $memberRequest->kloter->duration_unit,
                        'total_slots' => $memberRequest->kloter->total_slots,
                        'filled_slots' => $memberRequest->kloter->filled_slots,
                    ],
                    'slot_number' => $memberRequest->slot_number,
                    'monthly_payment' => $memberRequest->monthly_payment,
                    'status' => $memberRequest->status,
                    'joined_at' => $memberRequest->joined_at,
                    'verified_at' => $memberRequest->verified_at,
                    'rejection_note' => $memberRequest->rejection_note,
                    'verified_by' => $memberRequest->verifiedBy ? $memberRequest->verifiedBy->name : null,
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Get member request detail error: Request not found', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Get member request detail error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data'
            ], 500);
        }
    }

    /**
     * Show testimonial management page
     * Menampilkan halaman manajemen testimoni
     */
    public function testimoniIndex(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access to testimoni index');
            return redirect()->route('admin.login');
        }

        try {
            $query = Testimoni::with('user');
            
            // Filter berdasarkan status
            if ($request->has('status') && $request->status != '') {
                if ($request->status == 'approved') {
                    $query->where('is_approved', true);
                } elseif ($request->status == 'pending') {
                    $query->where('is_approved', false);
                }
            }
            
            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('pekerjaan', 'like', "%{$search}%")
                      ->orWhere('testimoni', 'like', "%{$search}%");
                });
            }
            
            $testimonis = $query->orderBy('created_at', 'desc')->paginate(10);
            
            // Statistik
            $statistics = [
                'approved' => Testimoni::where('is_approved', true)->count(),
                'pending' => Testimoni::where('is_approved', false)->count(),
                'total' => Testimoni::count(),
            ];
            
            return view('pages.admin.testimoni', compact('testimonis', 'statistics'));
        } catch (\Exception $e) {
            Log::error('Testimoni index error: ' . $e->getMessage());
            return view('pages.admin.testimoni', [
                'testimonis' => collect([]),
                'statistics' => ['approved' => 0, 'pending' => 0, 'total' => 0]
            ])->with('error', 'Gagal memuat data testimoni');
        }
    }

    /**
     * Update user status (activate, suspend, etc.)
     * Mengubah status user (approved, suspended, dll.)
     */
    public function updateUserStatus(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $request->validate([
                'status' => 'required|in:approved,suspended,rejected,pending'
            ]);

            $user = User::findOrFail($id);
            
            $oldStatus = $user->status;
            $user->update([
                'status' => $request->status
            ]);
            
            Log::info('User status updated', ['user_id' => $id, 'from' => $oldStatus, 'to' => $request->status]);
            return response()->json([
                'success' => true,
                'message' => "Status user berhasil diubah dari {$oldStatus} ke {$request->status}"
            ]);

        } catch (ValidationException $e) {
            Log::error('Update user status validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Update user status error: User not found', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Update user status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status user'
            ], 500);
        }
    }

    /**
     * Delete user (soft delete)
     * Menghapus user dengan soft delete
     */
    public function deleteUser($id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting approved users with active kloters
            $activeKloters = KloterMember::where('user_id', $id)
                ->whereIn('status', ['approved', 'active'])
                ->exists();
            if ($activeKloters) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak dapat dihapus karena memiliki kloter aktif'
                ], 400);
            }
            
            $user->delete();
            
            DB::commit();
            Log::info('User deleted', ['user_id' => $id]);
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Delete user error: User not found', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Delete user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user'
            ], 500);
        }
    }
    // Di AdminController.php, tambahkan method ini setelah method testimoniIndex()

/**
 * Approve a testimonial
 */
public function testimoniApprove($id)
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login');
    }

    try {
        $testimoni = Testimoni::findOrFail($id);
        
        // Check if already approved
        if ($testimoni->is_approved) {
            return redirect()->back()->with('error', 'Testimoni sudah disetujui sebelumnya.');
        }
        
        $testimoni->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Testimoni berhasil disetujui dan akan ditampilkan di halaman utama.');
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Testimoni tidak ditemukan.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui testimoni: ' . $e->getMessage());
    }
}

/**
 * Delete a testimonial
 */
public function testimoniDestroy($id)
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login');
    }

    try {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();
        
        return redirect()->back()->with('success', 'Testimoni berhasil dihapus.');
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Testimoni tidak ditemukan.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus testimoni: ' . $e->getMessage());
    }
}
public function kelolaKloterAktif(Request $request)
{
    if (!Auth::guard('admin')->check()) {
        Log::warning('Unauthorized access to kelola kloter aktif');
        return redirect()->route('admin.login');
    }

    try {
        // Get query parameters for filtering
        $status = $request->get('status');
        $category = $request->get('category');
        $search = $request->get('search');
        $sort = $request->get('sort', 'created_desc');

        // Build query
        $query = Kloter::with(['members.user']);

        // Apply filters
        if ($status && in_array($status, ['open', 'full', 'running', 'completed', 'cancelled', 'draft'])) {
            $query->where('status', $status);
        }

        if ($category && in_array($category, ['bulanan', 'mingguan', 'harian'])) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Apply sorting
        switch($sort) {
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'amount_desc':
                $query->orderBy('nominal', 'desc');
                break;
            case 'amount_asc':
                $query->orderBy('nominal', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Get paginated results
        $kloters = $query->paginate(10);

        // Calculate statistics
        $totalKloters = Kloter::count();
        $activeKloters = Kloter::where('status', 'open')->count();
        $fullKloters = Kloter::where('status', 'full')->count();
        $runningKloters = Kloter::where('status', 'running')->count();
        $completedKloters = Kloter::where('status', 'completed')->count();
        $totalValue = Kloter::whereIn('status', ['open', 'full', 'running'])->sum('nominal') / 1000000;
        $needAttention = Kloter::where('status', 'running')
            ->where('current_period', '>', 0)
            ->whereHas('members', function($q) {
                $q->where('payment_status', 'overdue');
            })->count();

        return view('pages.admin.arisan_aktif', compact(
            'kloters',
            'totalKloters',
            'activeKloters',
            'fullKloters',
            'runningKloters',
            'completedKloters',
            'totalValue',
            'needAttention'
        ));

    } catch (\Exception $e) {
        Log::error('Kelola kloter aktif error: ' . $e->getMessage());
        return view('pages.admin.arisan_aktif', [
            'kloters' => collect([]),
            'totalKloters' => 0,
            'activeKloters' => 0,
            'fullKloters' => 0,
            'runningKloters' => 0,
            'completedKloters' => 0,
            'totalValue' => 0,
            'needAttention' => 0
        ])->with('error', 'Gagal memuat data kloter');
    }
}

/**
 * Show kloter detail for admin
 * Menampilkan detail kloter untuk admin
 */
public function showKloterDetail($id)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    try {
        $kloter = Kloter::with(['members.user', 'rules'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $kloter->id,
                'name' => $kloter->name,
                'description' => $kloter->description,
                'category' => $kloter->category,
                'nominal' => $kloter->nominal,
                'total_slots' => $kloter->total_slots,
                'filled_slots' => $kloter->filled_slots,
                'status' => $kloter->status,
                'duration_value' => $kloter->duration_value,
                'duration_unit' => $kloter->duration_unit,
                'current_period' => $kloter->current_period,
                'payment_method' => $kloter->payment_method,
                'admin_fee_amount' => $kloter->admin_fee_amount,
                'created_at' => $kloter->created_at,
                'progress_percentage' => $kloter->progress_percentage,
                'members' => $kloter->members->map(function($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->user->name,
                        'email' => $member->user->email,
                        'slot_number' => $member->slot_number,
                        'status' => $member->status,
                        'payment_status' => $member->payment_status ?? 'pending',
                        'joined_at' => $member->joined_at
                    ];
                }),
                'last_winner' => $kloter->members->where('is_winner', true)->last() 
                    ? $kloter->members->where('is_winner', true)->last()->user->name 
                    : null
            ]
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Kloter detail not found', ['id' => $id]);
        return response()->json([
            'success' => false,
            'message' => 'Kloter tidak ditemukan'
        ], 404);
    } catch (\Exception $e) {
        Log::error('Show kloter detail error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat detail kloter'
        ], 500);
    }
}

/**
 * Get kloter data for editing
 * Mengambil data kloter untuk form edit
 */
public function editKloter($id)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    try {
        $kloter = Kloter::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $kloter->toArray()
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Edit kloter not found', ['id' => $id]);
        return response()->json([
            'success' => false,
            'message' => 'Kloter tidak ditemukan'
        ], 404);
    } catch (\Exception $e) {
        Log::error('Edit kloter error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat data kloter'
        ], 500);
    }
}

/**
 * Update existing kloter
 * Mengupdate kloter yang sudah ada
 */
public function updateKloter(Request $request, $id)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    DB::beginTransaction();
    try {
        $kloter = Kloter::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category' => 'required|in:harian,mingguan,bulanan',
            'nominal' => 'required|numeric|min:0',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:minggu,bulan',
            'total_slots' => 'required|integer|min:2|max:100',
            'payment_schedule' => 'nullable|string|max:100',
            'draw_schedule' => 'nullable|string|max:100',
            'admin_fee_percentage' => 'nullable|numeric|min:0|max:10',
            'payment_method' => 'nullable|string|max:100',
            'status' => 'nullable|in:open,full,running,completed,cancelled,draft',
            'late_fee' => 'nullable|numeric|min:0',
            'grace_period' => 'nullable|integer|min:0|max:7',
        ]);

        // Recalculate admin fee if percentage provided
        if (isset($validated['admin_fee_percentage']) && $validated['admin_fee_percentage'] > 0) {
            $validated['admin_fee_amount'] = round($validated['nominal'] * $validated['admin_fee_percentage'] / 100);
        }

        // Prevent reducing total_slots if already has more members
        if ($validated['total_slots'] < $kloter->filled_slots) {
            return response()->json([
                'success' => false,
                'message' => "Total slot tidak boleh kurang dari jumlah anggota yang sudah bergabung ({$kloter->filled_slots})"
            ], 400);
        }

        $kloter->update($validated);
        
        DB::commit();
        Log::info('Kloter updated successfully', ['id' => $id]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kloter berhasil diupdate',
            'data' => $kloter->fresh()
        ]);

    } catch (ValidationException $e) {
        DB::rollback();
        Log::error('Update kloter validation error', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Update kloter error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengupdate kloter: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Delete kloter
 * Menghapus kloter (dengan validasi)
 */
public function deleteKloter($id)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    DB::beginTransaction();
    try {
        $kloter = Kloter::with('members')->findOrFail($id);
        
        // Prevent deleting kloter with active members
        $activeMembers = $kloter->members->whereIn('status', ['active', 'approved'])->count();
        if ($activeMembers > 0) {
            return response()->json([
                'success' => false,
                'message' => "Kloter tidak dapat dihapus karena masih memiliki {$activeMembers} anggota aktif"
            ], 400);
        }

        // Prevent deleting running kloter
        if (in_array($kloter->status, ['running', 'full'])) {
            return response()->json([
                'success' => false,
                'message' => 'Kloter yang sedang berjalan atau penuh tidak dapat dihapus'
            ], 400);
        }

        // Delete related records first
        $kloter->members()->delete();
        $kloter->requests()->delete();
        $kloter->rules()->delete();
        
        // Delete the kloter
        $kloter->delete();
        
        DB::commit();
        Log::info('Kloter deleted successfully', ['id' => $id]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kloter berhasil dihapus'
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollback();
        Log::error('Delete kloter not found', ['id' => $id]);
        return response()->json([
            'success' => false,
            'message' => 'Kloter tidak ditemukan'
        ], 404);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Delete kloter error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus kloter: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Change kloter status
 * Mengubah status kloter
 */
public function changeKloterStatus(Request $request, $id)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    try {
        $request->validate([
            'status' => 'required|in:open,full,running,completed,cancelled,draft'
        ]);

        $kloter = Kloter::findOrFail($id);
        $oldStatus = $kloter->status;
        
        // Validation rules for status changes
        if ($request->status === 'running' && $kloter->filled_slots < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Kloter harus memiliki minimal 2 anggota untuk dijalankan'
            ], 400);
        }

        if ($request->status === 'completed' && $kloter->status !== 'running') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya kloter yang sedang berjalan yang dapat diselesaikan'
            ], 400);
        }

        $kloter->update(['status' => $request->status]);
        
        Log::info('Kloter status changed', [
            'id' => $id, 
            'from' => $oldStatus, 
            'to' => $request->status
        ]);
        
        return response()->json([
            'success' => true,
            'message' => "Status kloter berhasil diubah dari {$oldStatus} ke {$request->status}",
            'data' => ['status' => $kloter->status]
        ]);

    } catch (ValidationException $e) {
        Log::error('Change kloter status validation error', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Status tidak valid',
            'errors' => $e->errors()
        ], 422);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Change kloter status not found', ['id' => $id]);
        return response()->json([
            'success' => false,
            'message' => 'Kloter tidak ditemukan'
        ], 404);
    } catch (\Exception $e) {
        Log::error('Change kloter status error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengubah status kloter'
        ], 500);
    }
}

/**
 * Duplicate kloter
 * Menduplikasi kloter dengan data yang sama
 */
public function duplicateKloter($id)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    DB::beginTransaction();
    try {
        $originalKloter = Kloter::with('rules')->findOrFail($id);
        
        // Create duplicate with modified data
        $duplicateData = $originalKloter->toArray();
        unset($duplicateData['id']);
        unset($duplicateData['created_at']);
        unset($duplicateData['updated_at']);
        
        // Modify name and reset counters
        $duplicateData['name'] = $duplicateData['name'] . ' (Copy)';
        $duplicateData['filled_slots'] = 0;
        $duplicateData['current_period'] = 0;
        $duplicateData['status'] = 'draft';
        
        $newKloter = Kloter::create($duplicateData);
        
        // Copy rules if any
        foreach ($originalKloter->rules as $rule) {
            $ruleData = $rule->toArray();
            unset($ruleData['id']);
            unset($ruleData['created_at']);
            unset($ruleData['updated_at']);
            $ruleData['kloter_id'] = $newKloter->id;
            
            KloterRule::create($ruleData);
        }
        
        DB::commit();
        Log::info('Kloter duplicated successfully', ['original_id' => $id, 'new_id' => $newKloter->id]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kloter berhasil diduplikasi',
            'data' => $newKloter
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollback();
        Log::error('Duplicate kloter not found', ['id' => $id]);
        return response()->json([
            'success' => false,
            'message' => 'Kloter tidak ditemukan'
        ], 404);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Duplicate kloter error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal menduplikasi kloter: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Export kloters data
 * Mengeksport data kloter ke CSV
 */
public function exportKloters(Request $request)
{
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    try {
        $query = Kloter::with(['members.user']);
        
        // Apply same filters as index
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('description', 'LIKE', "%{$request->search}%");
            });
        }

        $kloters = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'kloters_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($kloters) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Nama Kloter', 'Kategori', 'Nominal', 'Total Slot', 
                'Slot Terisi', 'Status', 'Durasi', 'Periode Saat Ini', 
                'Biaya Admin', 'Metode Pembayaran', 'Dibuat'
            ]);
            
            // CSV data
            foreach ($kloters as $kloter) {
                fputcsv($file, [
                    $kloter->id,
                    $kloter->name,
                    $kloter->category,
                    'Rp ' . number_format($kloter->nominal, 0, ',', '.'),
                    $kloter->total_slots,
                    $kloter->filled_slots,
                    ucfirst($kloter->status),
                    $kloter->duration_value . ' ' . $kloter->duration_unit,
                    $kloter->current_period,
                    'Rp ' . number_format($kloter->admin_fee_amount ?? 0, 0, ',', '.'),
                    $kloter->payment_method,
                    $kloter->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        Log::info('Kloters exported', ['count' => $kloters->count()]);
        return response()->stream($callback, 200, $headers);

    } catch (\Exception $e) {
        Log::error('Export kloters error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengeksport data'
        ], 500);
    }
}
}