@extends('layouts.app')

@section('title', 'Jabatan')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-stone-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Struktur Organisasi
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl">
                    Manajemen Jabatan
                </h1>
                <p class="mt-2 text-sm text-stone-500">
                    Kelola jabatan dan hubungannya dengan departemen perusahaan.
                </p>
            </div>

            <a href="{{ route('positions.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                </svg>
                Tambah Jabatan
            </a>
        </div>

        @include('partials.flash')

        {{-- Summary --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Total Jabatan</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-800">
                            {{ $positions->total() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-500">Sesuai hasil pencarian</p>
                    </div>
                    <div class="rounded-xl bg-stone-100 p-3 text-stone-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m7-10a4 4 0 100-8 4 4 0 000 8zm13 10v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Jabatan Aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#A85435]">
                            {{ $positions->getCollection()->where('is_active', true)->count() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-500">Pada halaman ini</p>
                    </div>
                    <div class="rounded-xl bg-[#F8F0EB] p-3 text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.5 2a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Jabatan Nonaktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-500">
                            {{ $positions->getCollection()->where('is_active', false)->count() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-500">Pada halaman ini</p>
                    </div>
                    <div class="rounded-xl bg-stone-100 p-3 text-stone-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search and Filter --}}
        <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
            <div class="mb-4">
                <h2 class="font-semibold text-stone-800">Cari Jabatan</h2>
                <p class="mt-1 text-sm text-stone-500">
                    Cari berdasarkan nama jabatan atau saring berdasarkan departemen.
                </p>
            </div>

            <form method="GET" action="{{ route('positions.index') }}"
                class="grid grid-cols-1 gap-3 md:grid-cols-[minmax(0,1fr)_minmax(220px,0.7fr)_auto_auto]">

                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7" />
                        <path stroke-linecap="round" d="m20 20-4-4" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama jabatan..."
                        class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] py-2.5 pl-10 pr-3 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                </div>

                <select name="department_id"
                    class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    <option value="">Semua departemen</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#403B36]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M6 9h12m-9 5h6m-4 5h2" />
                    </svg>
                    Terapkan
                </button>

                <a href="{{ route('positions.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                    Reset
                </a>
            </form>
        </div>

        {{-- Positions Table --}}
        <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-1 border-b border-stone-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-semibold text-stone-800">Daftar Jabatan</h2>
                    <p class="mt-1 text-xs text-stone-500">
                        Menampilkan {{ $positions->count() }} dari {{ $positions->total() }} jabatan.
                    </p>
                </div>
                <span class="w-fit rounded-lg bg-[#F8F0EB] px-3 py-1.5 text-xs font-semibold text-[#A85435]">
                    Data Jabatan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-[#FCFAF8]">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                            <th class="px-5 py-4">Jabatan</th>
                            <th class="px-5 py-4">Departemen</th>
                            <th class="px-5 py-4 text-center">Karyawan</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($positions as $position)
                            <tr class="transition hover:bg-[#FCFAF8]">
                                <td class="px-5 py-4">
                                    <div class="flex min-w-52 items-start gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]">
                                            {{ mb_strtoupper(mb_substr($position->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-stone-800">
                                                {{ $position->name }}
                                            </p>
                                            <p class="mt-1 max-w-xs text-xs leading-5 text-stone-500">
                                                {{ $position->description ?: 'Belum ada deskripsi jabatan.' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($position->department)
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01" />
                                                </svg>
                                            </div>
                                            <span class="font-medium text-stone-700">
                                                {{ $position->department->name }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-stone-400">Belum ditentukan</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span
                                        class="inline-flex min-w-10 items-center justify-center rounded-lg bg-stone-100 px-3 py-1.5 font-semibold text-stone-700">
                                        {{ $position->employees_count }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($position->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-semibold text-[#A85435]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('positions.edit', $position) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-600 transition hover:border-[#C96F4A]/40 hover:bg-[#F8F0EB] hover:text-[#A85435]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l2.651 2.651M8 16l-1 4 4-1L20 10a2.121 2.121 0 00-3-3L8 16z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('positions.destroy', $position) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus jabatan {{ addslashes($position->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-100 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 7h12m-10 0V5h8v2m-9 0 1 13h8l1-13M10 11v5m4-5v5" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m7-10a4 4 0 100-8 4 4 0 000 8zm13 10v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 font-semibold text-stone-800">Jabatan tidak ditemukan</h3>
                                    <p class="mt-1 text-sm text-stone-500">
                                        Belum ada data jabatan yang sesuai dengan pencarian.
                                    </p>
                                    <a href="{{ route('positions.create') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#292724] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#403B36]">
                                        <span>+</span> Tambah Jabatan
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($positions->hasPages())
                <div class="border-t border-stone-200 px-5 py-4">
                    {{ $positions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
