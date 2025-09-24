@extends('layouts.app')

@section('content')
    <h1>Detail Kloter</h1>

    @include('kloters._card', ['kloter' => $kloter])
@endsection