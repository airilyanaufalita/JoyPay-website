@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kloter yang Saya Ikuti</h2>

    @if($kloters->isEmpty())
        <p>Belum ada kloter yang kamu ikuti.</p>
    @else
        <ul>
            @foreach($kloters as $kloter)
                <li>{{ $kloter->nama }} - {{ $kloter->deskripsi }}</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
