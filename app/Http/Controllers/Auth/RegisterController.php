<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'emergency_phone' => 'nullable|string|max:20',
            'social_media' => 'nullable|string|max:255',
            'bank' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'emergency_phone' => $request->emergency_phone,
            'social_media' => $request->social_media,
            'bank' => $request->bank,
            'account_number' => $request->account_number,
            'password' => Hash::make($request->password),
            'role_id' => 2, // default user
            'status' => 'pending', // status pending menunggu verifikasi
            'type' => 'regular',
        ]);

        // Kirim notifikasi ke admin (opsional)
        $this->notifyAdmins($user);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Menunggu verifikasi admin. Anda akan menerima notifikasi di email setelah disetujui.');
    }

    // Method untuk notifikasi admin (opsional)
    protected function notifyAdmins(User $user)
    {
        $admins = Admin::all();
        foreach ($admins as $admin) {
            // Kirim email notifikasi ke admin
            // Mail::to($admin->email)->send(new NewRegistrationNotification($user));
        }
    }
}