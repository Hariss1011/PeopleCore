@extends('layouts.app')

@section('title', $module)
@section('heading', $module)

@section('content')
    <div class="empty-panel">
        <span class="empty-icon">PC</span>
        <h2>{{ $module }}</h2>
        <p>
            Modul ini sudah terdaftar dalam struktur akses PeopleCore
            dan akan diimplementasikan pada tahap berikutnya.
        </p>

        <a href="{{ route('dashboard') }}" class="button-secondary">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
