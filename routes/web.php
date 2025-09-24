<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\WinnerController;
use App\Http\Controllers\KloterController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\HomeController;

// ========================================
// ADMIN ROUTES
// ========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Routes (tidak perlu middleware auth)
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    
    // Admin Routes yang perlu authentication
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/konfirmasi-pendaftaran', [AdminController::class, 'konfirmasiPendaftaran'])->name('konfirmasi-pendaftaran');
        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen-user');
        Route::get('/buat-kloter', [AdminController::class, 'buatKloter'])->name('buat-kloter');
        Route::get('/arisan-aktif', [AdminController::class, 'kelolaKloterAktif'])->name('arisan-aktif');
        Route::get('/konfirmasi-masuk-kloter', [AdminController::class, 'konfirmasiMasukKloter'])
         ->name('konfirmasi-masuk-kloter');
         
        // PERBAIKAN: Gunakan AdminController untuk konfirmasi masuk kloter
        Route::get('/konfirmasi_masuk_kloter', [AdminController::class, 'konfirmasiMasukKloter'])->name('konfirmasi-masuk-kloter');
        
        Route::get('/konfirmasi-pembayaran', [AdminController::class, 'konfirmasi'])->name('konfirmasi-pembayaran');
        Route::get('/jadwal-pembayaran', [AdminController::class, 'jadwalPembayaran'])->name('jadwal-pembayaran');
        
        // TESTIMONI ADMIN ROUTES
        Route::get('/testimoni', [AdminController::class, 'testimoniIndex'])->name('testimoni');
        Route::patch('/testimoni/{id}/approve', [AdminController::class, 'testimoniApprove'])->name('testimoni.approve');
        Route::delete('/testimoni/{id}', [AdminController::class, 'testimoniDestroy'])->name('testimoni.destroy');
        
        // Kloter store route
        Route::post('/buat-kloter/store', [KloterController::class, 'store'])->name('buat-kloter.store');
        
        // Registration management routes
        Route::post('/registrations/{id}/approve', [AdminController::class, 'approveRegistration'])->name('registrations.approve');
        Route::post('/registrations/{id}/reject', [AdminController::class, 'rejectRegistration'])->name('registrations.reject');
        Route::post('/registrations/bulk-approve', [AdminController::class, 'bulkApproveRegistrations'])->name('registrations.bulk-approve');
        Route::get('/registrations/{id}', [AdminController::class, 'getRegistrationDetail'])->name('registrations.detail');
        Route::post('/users/{id}/update-status', [AdminController::class, 'updateUserStatus'])->name('users.update-status');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // PERBAIKAN: Member Request Routes - gunakan AdminController yang sudah ada
        Route::post('/member-requests/{id}/approve', [AdminController::class, 'approveMemberRequest'])->name('member-requests.approve');
        Route::post('/member-requests/{id}/reject', [AdminController::class, 'rejectMemberRequest'])->name('member-requests.reject');
        Route::get('/member-requests/{id}/detail', [AdminController::class, 'getMemberRequestDetail'])->name('member-requests.detail');
        
        // Stats API - simple route untuk statistik
        Route::get('/member-requests/stats', function() {
            try {
                $pendingCount = \App\Models\KloterMemberRequest::where('status', 'pending')->count();
                $approvedCount = \App\Models\KloterMember::where('status', 'approved')->count();
                $rejectedCount = \App\Models\KloterMemberRequest::where('status', 'rejected')->count();
                $totalRequests = \App\Models\KloterMemberRequest::count() + \App\Models\KloterMember::count();

                return response()->json([
                    'success' => true,
                    'pendingCount' => $pendingCount,
                    'approvedCount' => $approvedCount,
                    'rejectedCount' => $rejectedCount,
                    'totalRequests' => $totalRequests
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Gagal memuat statistik: ' . $e->getMessage(),
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => basename($e->getFile())
                ], 500);
            }
        })->name('member-requests.stats');
        
        // Admin Logout
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});
Route::post('/admin/member-requests/{id}/approve', [KloterController::class, 'approveMemberRequest'])
    ->name('admin.member-requests.approve')
    ->middleware(['auth:admin']); // atau middleware yang sesuai

Route::post('/admin/member-requests/{id}/reject', [KloterController::class, 'rejectMemberRequest'])
    ->name('admin.member-requests.reject')
    ->middleware(['auth:admin']);
// ========================================
// USER AUTHENTICATION ROUTES
// ========================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Registration management routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/konfirmasi-pendaftaran', [AdminController::class, 'konfirmasiPendaftaran'])->name('konfirmasi-pendaftaran');
    Route::post('/registrations/{id}/approve', [AdminController::class, 'approveRegistration'])->name('registrations.approve');
    Route::post('/registrations/{id}/reject', [AdminController::class, 'rejectRegistration'])->name('registrations.reject');
    Route::post('/registrations/bulk-approve', [AdminController::class, 'bulkApproveRegistrations'])->name('registrations.bulk-approve');
    Route::get('/registrations/{id}', [AdminController::class, 'getRegistrationDetail'])->name('registrations.detail');
});

// Logout Routes
Route::get('/logout', function () {
    return view('auth.logout-confirm');
});
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('status', 'Berhasil logout.');
})->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'checkUser'])->name('forgot.check');
Route::get('/reset-password/{name}', [ResetPasswordController::class, 'showResetForm'])->name('reset.password');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.update');

// Email Verification Routes
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// ========================================
// KLOTER PUBLIC ROUTES (BISA DIAKSES TANPA LOGIN)
// ========================================
Route::get('/kloterAktif', [KloterController::class, 'index'])->name('kloter.aktif');
Route::get('/kloterAktif/detail/{id}', [KloterController::class, 'detail'])->name('kloter.detail');

// ========================================
// KLOTER PROTECTED ROUTES (PERLU LOGIN)
// ========================================
Route::middleware(['auth'])->group(function () {
    // Route bergabung kloter (GET & POST) - untuk user biasa
    Route::get('/kloter/{id}/bergabung', [KloterController::class, 'showJoinKloter'])->name('kloter.join.show');
    Route::post('/kloter/{id}/join', [KloterController::class, 'joinKloter'])->name('kloter.join');
    
    // Halaman kloter user - perlu login
    Route::get('/kloterAktif/user', [KloterController::class, 'userKloters'])->name('kloter.user');
    
    // Halaman pembayaran kloter - perlu login
    Route::get('/kloterAktif/bayar', function () {
        return view('layouts.app', [
            'page' => 'kloter-bayar',
            'title' => 'Bayar Kloter',
        ]);
    })->name('kloter.bayar');
});

// ========================================
// USER PROTECTED ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('layouts.app', ['page' => 'dashboard']);
    })->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // TESTIMONI USER ROUTES
    Route::get('/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni/store', [TestimoniController::class, 'store'])->name('testimoni.store');
});
// TEMPORARY DEBUG ROUTE
Route::get('/debug-kloter/{id}', [KloterController::class, 'debugJoinKloter'])->name('debug.kloter');
Route::middleware(['auth'])->group(function () {
    Route::get('/test-kloter/{id}/bergabung', [KloterController::class, 'showJoinKloter'])->name('test.kloter.join');
});
// DEBUG ROUTES - HAPUS SETELAH MASALAH TERATASI
Route::get('/test-admin', function() {
    return response()->json([
        'message' => 'Test route works!',
        'timestamp' => now(),
        'admin_auth' => Auth::guard('admin')->check(),
        'user_auth' => Auth::check()
    ]);
});

Route::get('/test-kloter', function() {
    try {
        $controller = new App\Http\Controllers\KloterController;
        return $controller->showConfirmationPage(request());
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ]);
    }
});
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // ... existing routes ...

    // Kloter CRUD Routes
    Route::get('/kelola-kloter-aktif', [AdminController::class, 'kelolaKloterAktif'])->name('kelola-kloter-aktif');
    Route::get('/kloters/{id}/detail', [AdminController::class, 'showKloterDetail'])->name('kloters.detail');
    Route::put('/kloters/{id}', [AdminController::class, 'updateKloter'])->name('kloters.update');
    Route::delete('/kloters/{id}', [AdminController::class, 'deleteKloter'])->name('kloters.delete');
    Route::post('/kloters/{id}/duplicate', [AdminController::class, 'duplicateKloter'])->name('kloters.duplicate');
    Route::patch('/kloters/{id}/status', [AdminController::class, 'changeKloterStatus'])->name('kloters.status');
    Route::get('/kloters/export', [AdminController::class, 'exportKloters'])->name('kloters.export');

    // ... rest of existing routes ...
});
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // ... existing routes ...
    
    // Edit Kloter - halaman terpisah
    Route::get('/kloters/{id}/edit-page', function($id) {
        return view('pages.admin.edit_kloter', compact('id'));
    })->name('kloters.edit-page');
    
    // API endpoint untuk mengambil data kloter (TAMBAHKAN INI)
    Route::get('/kloters/{id}/edit', [AdminController::class, 'editKloter'])->name('kloters.edit');
    
    // API endpoint untuk update kloter (TAMBAHKAN INI JUGA)
    Route::put('/kloters/{id}', [AdminController::class, 'updateKloter'])->name('kloters.update');
});
// ========================================
// PEMENANG ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/pemenang', [WinnerController::class, 'index'])->name('pemenang.index');
    Route::get('/pemenang/{id}', [WinnerController::class, 'show'])->name('pemenang.show');
});

// ========================================
// PENDAPATAN ROUTES
// ========================================
Route::get('/pendapatan', [PendapatanController::class, 'index'])->name('pendapatan.index');

// ========================================
// PUBLIC ROUTES
// ========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('layouts.app', [
        'page' => 'about',
        'title' => 'Tentang Kami'
    ]);
})->name('about');

Route::get('/contact', function () {
    return view('layouts.app', [
        'page' => 'contact',
        'title' => 'Kontak'
    ]);
})->name('contact');

Route::get('/informasi', function () {
    return view('layouts.app', [
        'page' => 'informasi',
        'title' => 'Informasi'
    ]);
})->name('informasi');

Route::get('/kamus', function () {
    return view('layouts.app', [
        'page' => 'kamus',
        'title' => 'Kamus Istilah'
    ]);
})->name('kamus');