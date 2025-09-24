<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Kloter;
use App\Models\KloterMember;
use App\Models\KloterMemberRequest;
use App\Models\KloterRule;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KloterController extends Controller
{
    /**
     * Display list of active kloters (for users)
     * Menampilkan daftar kloter yang tersedia untuk user dengan filter
     */
    public function index(Request $request)
    {
        $kloters = collect([]);
        $totalKloters = 0;
        $openKloters = 0;

        try {
            $category = $request->get('category');
            $nominal = $request->get('nominal');
            $status = $request->get('status');
            $search = $request->get('search');

            $query = Kloter::query()->where('total_slots', '>', 0);

            if ($category && in_array($category, ['mingguan', 'bulanan'])) {
                $query->where('category', $category);
            }
            if ($nominal) {
                $query->where('nominal', '>=', $nominal);
            }
            if ($status && in_array($status, ['open', 'full', 'running', 'completed'])) {
                $query->where('status', $status);
            }
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            $query->whereIn('status', ['open', 'full', 'running']);

            $kloters = $query->orderBy('created_at', 'desc')->paginate(10);

            $totalKloters = Kloter::whereIn('status', ['open', 'full', 'running'])->count();
            $openKloters = Kloter::where('status', 'open')->count();

        } catch (Exception $e) {
            Log::error('KloterController index error: ' . $e->getMessage());
            return view('pages.kloteraktif', [
                'kloters' => collect([]),
                'totalKloters' => 0,
                'openKloters' => 0
            ])->with('error', 'Gagal memuat daftar kloter.');
        }

        return view('pages.kloteraktif', compact('kloters', 'totalKloters', 'openKloters'));
    }

    /**
     * Store new kloter from form (for admin)
     * Membuat kloter baru dengan validasi data
     */
    public function store(Request $request)
    {
        try {
            Log::info('Store method called', $request->all());

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
                'admin_fee_percentage' => 'nullable|numeric|min:0|max:100',
                'admin_fee_amount' => 'nullable|numeric|min:0',
                'admin_name' => 'nullable|string|max:255',
                'payment_method' => 'nullable|string|max:100',
                'filled_slots' => 'nullable|integer|min:0',
                'current_period' => 'nullable|integer|min:0',
                'status' => 'nullable|in:open,full,running,completed',
                'min_slots' => 'nullable|integer|min:2',
                'max_slots' => 'nullable|integer|min:2',
                'late_fee' => 'nullable|numeric|min:0',
                'grace_period' => 'nullable|integer|min:0|max:7',
            ]);

            $validated['filled_slots'] = $validated['filled_slots'] ?? 0;
            $validated['current_period'] = $validated['current_period'] ?? 0;
            $validated['status'] = $validated['status'] ?? 'open';
            $validated['payment_method'] = $validated['payment_method'] ?? 'Transfer Bank';
            $validated['admin_name'] = $validated['admin_name'] ?? 'Admin Kloter';

            if (isset($validated['admin_fee_percentage']) && $validated['admin_fee_percentage'] > 0) {
                $validated['admin_fee_amount'] = round($validated['nominal'] * $validated['admin_fee_percentage'] / 100);
            }

            Log::info('Validated data', $validated);

            $kloter = Kloter::create($validated);

            Log::info('Kloter created successfully', ['id' => $kloter->id]);

            return response()->json([
                'success' => true,
                'message' => 'Kloter berhasil dibuat',
                'kloter_id' => $kloter->id
            ]);

        } catch (ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            Log::error('Store kloter error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show detail kloter with rules and members
     * Menampilkan detail kloter termasuk aturan dan anggota
     */
public function detail($id)
{
    try {
        Log::info('=== ACCESSING KLOTER DETAIL ===', [
            'id' => $id,
            'timestamp' => now(),
            'user_id' => Auth::id(),
            'url' => request()->url()
        ]);
        
        // STEP 1: Cek ID valid
        if (!is_numeric($id) || $id <= 0) {
            Log::warning('Invalid kloter ID provided', ['id' => $id]);
            return redirect()->route('kloter.aktif')->with('error', 'ID kloter tidak valid');
        }

        // STEP 2: Cari kloter tanpa relasi dulu (untuk debugging)
        $kloter = Kloter::find($id);
        
        if (!$kloter) {
            Log::warning('Kloter not found', ['id' => $id]);
            return redirect()->route('kloter.aktif')->with('error', 'Kloter tidak ditemukan');
        }

        Log::info('Kloter found successfully', [
            'kloter_id' => $kloter->id,
            'name' => $kloter->name,
            'status' => $kloter->status
        ]);

        // STEP 3: Load relasi secara bertahap untuk debugging
        try {
            // Coba load members dulu
            $members = $kloter->members()->with('user')->get();
            Log::info('Members loaded', ['count' => $members->count()]);
        } catch (\Exception $e) {
            Log::error('Error loading members', ['error' => $e->getMessage()]);
            $members = collect([]); // Fallback ke collection kosong
        }

        try {
            // Coba load rules
            $rules = $kloter->rules ?? collect([]);
            Log::info('Rules loaded', ['count' => is_countable($rules) ? count($rules) : 0]);
        } catch (\Exception $e) {
            Log::error('Error loading rules', ['error' => $e->getMessage()]);
            $rules = collect([]); // Fallback ke collection kosong
        }

        // STEP 4: Hitung progress percentage jika belum ada
        if (!isset($kloter->progress_percentage)) {
            $kloter->progress_percentage = $kloter->total_slots > 0 
                ? round(($kloter->filled_slots / $kloter->total_slots) * 100) 
                : 0;
        }

        Log::info('About to render view', [
            'view' => 'pages.kloter-detail',
            'kloter_id' => $kloter->id,
            'members_count' => $members->count(),
            'rules_count' => is_countable($rules) ? count($rules) : 0
        ]);

        // STEP 5: Render view dengan data minimal dulu
        return view('pages.kloter-detail', [
            'kloter' => $kloter,
            'members' => $members,
            'rules' => $rules
        ]);

    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('Database query error in detail', [
            'id' => $id,
            'error' => $e->getMessage(),
            'sql' => $e->getSql(),
            'bindings' => $e->getBindings()
        ]);
        
        return redirect()->route('kloter.aktif')
            ->with('error', 'Terjadi kesalahan database saat memuat detail kloter');
            
    } catch (\Exception $e) {
        Log::error('General error in detail method', [
            'id' => $id,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile()),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->route('kloter.aktif')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
public function detailDebug($id)
{
    Log::info('=== DEBUG DETAIL METHOD ===', ['id' => $id]);
    
    try {
        $kloter = Kloter::find($id);
        
        if (!$kloter) {
            return response()->json(['error' => 'Kloter not found', 'id' => $id]);
        }
        
        // Test sederhana: return data JSON dulu
        return response()->json([
            'success' => true,
            'kloter' => [
                'id' => $kloter->id,
                'name' => $kloter->name,
                'status' => $kloter->status,
                'nominal' => $kloter->nominal,
                'total_slots' => $kloter->total_slots,
                'filled_slots' => $kloter->filled_slots
            ],
            'message' => 'Data loaded successfully'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ], 500);
    }
}
    /**
     * Show join kloter page (select slot)
     * Menampilkan halaman untuk user memilih slot dan bergabung
     */

public function showJoinKloter($id)
{
    Log::info('=== SHOW JOIN KLOTER START ===', ['kloter_id' => $id]);

    try {
        // STEP 1: Auth check
        if (!Auth::check()) {
            Log::warning('User not authenticated');
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // STEP 2: Load kloter with relations
        $kloter = Kloter::with(['members', 'requests'])->find($id);
        if (!$kloter) {
            Log::error('Kloter not found');
            return redirect()->route('kloter.aktif')->with('error', 'Kloter tidak ditemukan');
        }

        Log::info('Kloter found', ['name' => $kloter->name, 'status' => $kloter->status]);

        // STEP 3: Validasi status kloter
        if ($kloter->status !== 'open') {
            return redirect()->route('kloter.aktif')->with('error', 'Kloter ini tidak menerima pendaftaran baru.');
        }

        // STEP 4: Get taken slots
        $takenSlots = $kloter->members->whereIn('status', ['active', 'approved'])->pluck('slot_number')
            ->merge($kloter->requests->where('status', 'pending')->pluck('slot_number'))
            ->unique()
            ->toArray();

        // STEP 5: Generate slots dynamically
        $slots = [];
        $baseAmount = $kloter->nominal / $kloter->total_slots;

        for ($number = 1; $number <= $kloter->total_slots; $number++) {
            // Hitung monthly_payment (sama seperti di joinKloter)
            $adjustment = ($kloter->total_slots - $number) * ($baseAmount * 0.05);
            $monthlyPayment = round($baseAmount + $adjustment);

            // Period label menggunakan helper
            $periodLabel = $this->getPeriodLabel($number, $kloter);

            $slots[] = [
                'number' => $number,
                'monthly_payment' => $monthlyPayment,
                'is_taken' => in_array($number, $takenSlots),
                'period_label' => $periodLabel
            ];
        }

        // STEP 6: Period (mingguan/bulanan dari category atau duration_unit)
        $period = $kloter->duration_unit === 'bulan' ? 'bulan' : 'minggu'; // Sesuaikan jika perlu

        // STEP 7: Render view with real data
        return view('pages.kloter-bergabung', [
            'kloter' => $kloter,
            'slots' => $slots,
            'takenSlots' => $takenSlots,
            'period' => $period
        ]);

    } catch (\Exception $e) {
        Log::error('GENERAL EXCEPTION', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ]);
        return redirect()->route('kloter.aktif')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
public function showConfirmationPage(Request $request)
{
    try {
        logger('showConfirmationPage started');
        
        // Aktifkan kembali auth check
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login sebagai admin');
        }
        
        logger('Admin authenticated, loading data...');
        
        // Ambil data yang diperlukan
        $kloters = Kloter::whereIn('status', ['open', 'full', 'running'])->get();
        
        $pendingJoinsQuery = KloterMemberRequest::with(['user', 'kloter']);
        
        // Apply filters jika ada
        if ($request->search) {
            $pendingJoinsQuery->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%")
                      ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        
        if ($request->status) {
            $pendingJoinsQuery->where('status', $request->status);
        }
        
        if ($request->kloter_id) {
            $pendingJoinsQuery->where('kloter_id', $request->kloter_id);
        }
        
        $pendingJoins = $pendingJoinsQuery->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistik
        $pendingCount = KloterMemberRequest::where('status', 'pending')->count();
        $approvedCount = KloterMember::where('status', 'approved')->count();
        $rejectedCount = KloterMemberRequest::where('status', 'rejected')->count();
        $totalRequests = KloterMemberRequest::count() + KloterMember::count();
        
        logger('Data loaded successfully', [
            'kloters' => $kloters->count(),
            'pendingJoins' => $pendingJoins->count(),
            'pendingCount' => $pendingCount
        ]);
        
        // Return dengan data lengkap
        return view('pages.admin.konfirmasi-masuk-kloter', [
            'pendingJoins' => $pendingJoins,
            'kloters' => $kloters,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalRequests' => $totalRequests,
        ]);
        
    } catch (\Exception $e) {
        logger('showConfirmationPage error: ' . $e->getMessage());
        
        return redirect()->route('admin.dashboard')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
public function approveMemberRequest($id)
{
    try {
        // Cari member request
        $memberRequest = KloterMemberRequest::findOrFail($id);
        
        // Cek status
        if ($memberRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan sudah diproses sebelumnya.'
            ], 400);
        }

        DB::beginTransaction();

        // Update status request
        $memberRequest->status = 'approved';
        $memberRequest->verified_at = now();
        $memberRequest->save();

        // Buat record di kloter_members TANPA monthly_payment
        $member = new KloterMember();
        $member->kloter_id = $memberRequest->kloter_id;
        $member->user_id = $memberRequest->user_id;
        $member->slot_number = $memberRequest->slot_number;
        // HAPUS baris monthly_payment
        $member->status = 'active';
        $member->joined_at = $memberRequest->joined_at ?? now();
        $member->verified_at = now();
        $member->save();

        // Update filled slots di kloter
        $kloter = Kloter::find($memberRequest->kloter_id);
        if ($kloter) {
            $activeCount = KloterMember::where('kloter_id', $kloter->id)
                ->whereIn('status', ['active', 'approved'])
                ->count();
            
            $kloter->filled_slots = $activeCount;
            
            if ($activeCount >= $kloter->total_slots) {
                $kloter->status = 'full';
            }
            
            $kloter->save();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil disetujui!'
        ]);

    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Approve member request failed', [
            'id' => $id,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Gagal menyetujui permintaan: ' . $e->getMessage()
        ], 500);
    }
}
public function rejectMemberRequest(Request $request, $id)
{
    try {
        Log::info('Reject member request received', [
            'id' => $id,
            'request_data' => $request->all(),
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'rejection_note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        // Ambil data permintaan
        $memberRequest = KloterMemberRequest::find($id);
        if (!$memberRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan.'
            ], 404);
        }

        // Periksa status
        if ($memberRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan ini tidak dapat ditolak karena bukan status pending.'
            ], 400);
        }

        // PERBAIKAN: Gunakan $request->input() bukan variable yang tidak ada
        $memberRequest->update([
            'status' => 'rejected',
            'rejection_note' => $request->input('rejection_note'),
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil ditolak.'
        ]);
    } catch (Exception $e) {
        Log::error('Reject member request error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
// Tambahkan ini ke KloterController
public function memberRequestStatsApi()
{
    try {
        $pendingCount = KloterMemberRequest::where('status', 'pending')->count();
        $approvedCount = KloterMember::where('status', 'approved')->count();
        $rejectedCount = KloterMemberRequest::where('status', 'rejected')->count();
        $totalRequests = KloterMemberRequest::count() + KloterMember::count();

        return response()->json([
            'success' => true,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalRequests' => $totalRequests
        ]);
    } catch (Exception $e) {
        logger('Member request stats API error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat statistik'
        ], 500);
    }
}
public function getMemberRequestDetail($id)
{
    try {
        $memberRequest = KloterMemberRequest::with(['user', 'kloter'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $memberRequest]);
    } catch (Exception $e) {
        Log::error('Get member request detail error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    }
}
/**
 * Process join kloter (pending admin verification)
 * Memproses permintaan user untuk bergabung ke kloter
 */
public function joinKloter(Request $request, $id)
{
    Log::info('JOIN KLOTER REQUEST START', [
        'kloter_id' => $id,
        'user_id' => Auth::id(),
        'input' => $request->all()
    ]);

    try {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'slot_number' => 'required|integer|min:1',
            'agree_terms' => 'required|accepted'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        $slotNumber = $request->slot_number;
        $kloter = Kloter::with(['requests', 'members'])->findOrFail($id);

        Log::info('Kloter retrieved', ['kloter_id' => $kloter->id, 'status' => $kloter->status]);

        // Validasi status kloter
        if ($kloter->status !== 'open') {
            Log::warning('Kloter not open', ['status' => $kloter->status]);
            return response()->json([
                'success' => false,
                'message' => 'Kloter tidak menerima member baru'
            ], 400);
        }

        // Validasi slot number
        if ($slotNumber < 1 || $slotNumber > $kloter->total_slots) {
            Log::warning('Invalid slot number', ['slot' => $slotNumber, 'total_slots' => $kloter->total_slots]);
            return response()->json([
                'success' => false,
                'message' => "Slot tidak valid (1-{$kloter->total_slots})"
            ], 400);
        }

        // Check slot availability using relationships
        $takenSlots = $kloter->members->whereIn('status', ['approved', 'active'])->pluck('slot_number')
            ->merge($kloter->requests->where('status', 'pending')->pluck('slot_number'))
            ->unique()
            ->values()
            ->toArray();

        if (in_array($slotNumber, $takenSlots)) {
            Log::warning('Slot already taken', ['slot' => $slotNumber, 'taken_slots' => $takenSlots]);
            return response()->json([
                'success' => false,
                'message' => 'Slot sudah diambil oleh member lain'
            ], 400);
        }

        // Check if user already requested or joined
        $userId = Auth::id();
        $existingRequest = $kloter->requests()->where('user_id', $userId)->where('status', 'pending')->first();
        if ($existingRequest) {
            Log::warning('User already requested', ['user_id' => $userId]);
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengajukan bergabung dalam kloter ini'
            ], 400);
        }

        $existingMember = $kloter->members->where('user_id', $userId)->whereIn('status', ['approved', 'active'])->first();
        if ($existingMember) {
            Log::warning('User already member', ['user_id' => $userId]);
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah bergabung dalam kloter ini'
            ], 400);
        }

        // Calculate monthly payment
        $baseAmount = $kloter->nominal / $kloter->total_slots;
        $adjustment = ($kloter->total_slots - $slotNumber) * ($baseAmount * 0.05);
        $monthlyPayment = round($baseAmount + $adjustment);

        // Start transaction
        DB::beginTransaction();

        // Create pending request using relationship
        $requestModel = $kloter->requests()->create([
            'user_id' => $userId,
            'slot_number' => $slotNumber,
            'monthly_payment' => $monthlyPayment,
            'status' => 'pending',
            'joined_at' => now()
        ]);

        Log::info('Member request created', ['request_id' => $requestModel->id]);
        
        // Update kloter filled_slots
        $filledSlots = $kloter->requests->where('status', 'pending')->count() + $kloter->members->whereIn('status', ['approved', 'active'])->count();
        $kloter->filled_slots = $filledSlots;
        if ($filledSlots >= $kloter->total_slots) {
            $kloter->status = 'full';
        }
        $kloter->save();

        Log::info('Kloter updated', ['filled_slots' => $filledSlots, 'status' => $kloter->status]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Permintaan bergabung berhasil dikirim! Menunggu verifikasi admin (1-2 hari kerja).',
            'data' => [
                'request_id' => $requestModel->id,
                'slot_number' => $slotNumber,
                'monthly_payment' => $monthlyPayment,
                'kloter_name' => $kloter->name,
                'period_label' => $this->getPeriodLabel($slotNumber, $kloter),
                'admin_fee' => $kloter->admin_fee_amount ?? 0
            ]
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollback();
        Log::error('Kloter not found', ['kloter_id' => $id, 'error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Kloter tidak ditemukan'
        ], 404);
    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollback();
        Log::error('Database error', ['error' => $e->getMessage(), 'sql' => $e->getSql(), 'bindings' => $e->getBindings()]);
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
        ], 500);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Unexpected error in joinKloter', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Helper to get period label
     */
private function getPeriodLabel($slotNumber, $kloter)
{
    try {
        $unit = $kloter->duration_unit === 'bulan' ? 'Bulan' : 'Minggu';
        $label = "{$unit} ke-{$slotNumber}";
        
        if ($slotNumber <= 3) {
            $benefit = 'Dapat duluan';
        } elseif ($slotNumber <= ($kloter->total_slots / 2)) {
            $benefit = 'Dapat tengah';
        } else {
            $benefit = 'Bayar ringan';
        }
        
        return $label . ' - ' . $benefit;
        
    } catch (Exception $e) {
        Log::error('Error in getPeriodLabel', ['slot' => $slotNumber, 'error' => $e->getMessage()]);
        return "Periode ke-{$slotNumber}";
    }
}
public function debugJoinKloter($id)
{
    Log::info('=== DEBUG JOIN KLOTER START ===', [
        'kloter_id' => $id,
        'user_id' => Auth::id(),
        'user_authenticated' => Auth::check(),
        'url' => request()->url(),
        'method' => request()->method(),
        'headers' => request()->headers->all(),
    ]);

    try {
        // Test basic data
        $kloter = Kloter::find($id);
        Log::info('Kloter data:', [
            'found' => $kloter ? true : false,
            'kloter' => $kloter ? $kloter->toArray() : null
        ]);

        if (!$kloter) {
            Log::error('KLOTER NOT FOUND - will redirect');
            return redirect()->route('kloter.aktif')->with('error', 'Debug: Kloter tidak ditemukan');
        }

        // Test view rendering
        Log::info('Attempting to render view...');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Debug method reached successfully',
            'kloter_id' => $kloter->id,
            'kloter_name' => $kloter->name,
            'user_id' => Auth::id(),
            'should_render_view' => true
        ]);

    } catch (\Exception $e) {
        Log::error('DEBUG JOIN KLOTER ERROR', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}

    /**
     * Show user's kloter memberships
     * Menampilkan daftar keanggotaan kloter user
     */
public function userKloters()
{
    try {
        $memberships = KloterMember::with(['kloter', 'kloter.rules'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'active']) // Hanya tampilkan yang sudah approved
            ->orderBy('created_at', 'desc')
            ->get();

        // Tambah info pending dari kloter_member_requests
        $pendingRequests = KloterMemberRequest::with('kloter')
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return view('pages.kloter-user', compact('memberships', 'pendingRequests'));

    } catch (Exception $e) {
        Log::error('User kloters error: ' . $e->getMessage());
        return view('pages.kloter-user', ['memberships' => collect([]), 'pendingRequests' => collect([])])
            ->with('error', 'Gagal memuat daftar keanggotaan.');
    }
}

    /**
     * Get statistics for member requests (for admin)
     * Mengambil statistik permintaan masuk kloter untuk halaman admin
     */
public function memberRequestStats()
{
    try {
        $pendingCount = KloterMemberRequest::where('status', 'pending')->count();
        $approvedCount = KloterMember::where('status', 'approved')->count();
        $rejectedCount = KloterMemberRequest::where('status', 'rejected')->count();
        $totalRequests = KloterMemberRequest::count() + KloterMember::count();

        return [
            'success' => true,
            'data' => [
                'pendingCount' => $pendingCount,
                'approvedCount' => $approvedCount,
                'rejectedCount' => $rejectedCount,
                'totalRequests' => $totalRequests
            ]
        ];
    } catch (Exception $e) {
        Log::error('Member request stats error: ' . $e->getMessage());
        return ['success' => false, 'message' => 'Terjadi kesalahan saat memuat statistik'];
    }
}

}