@extends('layouts.app')

@section('content')
    <h1>Daftar Kloter</h1>

    @forelse ($kloters as $kloter)
        {{-- PENTING: pass variabel ke partial --}}
        @include('kloters._card', ['kloter' => $kloter])
    @empty
        <p>Belum ada kloter.</p>
    @endforelse
@endsection