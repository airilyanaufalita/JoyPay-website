<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('profile.profil', compact('user'));
    }

    // Update profil
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'username'         => 'required|string|max:255|unique:users,username,' . $user->id,
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255|unique:users,email,' . $user->id,
            'address'          => 'nullable|string|max:255',
            'phone'            => 'nullable|string|max:20',
            'emergency_phone'  => 'nullable|string|max:20',
            'social_media'     => 'nullable|string|max:255',
            'account_number'   => 'nullable|string|max:50',
        ]);

        $user->update([
            'username'        => $request->username,
            'name'            => $request->name,
            'email'           => $request->email,
            'address'         => $request->address,
            'phone'           => $request->phone,
            'emergency_phone' => $request->emergency_phone,
            'social_media'    => $request->social_media,
            'account_number'  => $request->account_number,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
