@extends('layouts.app')

@section('content')
    <h1>Edit Profil</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
        <input type="password" name="password" placeholder="Password baru">
        <input type="password" name="password_confirmation" placeholder="Konfirmasi password">
        <button type="submit">Simpan</button>
    </form>
@endsection
