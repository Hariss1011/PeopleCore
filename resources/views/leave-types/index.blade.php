@extends('layouts.app')

@section('title', 'Jenis Cuti')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-stone-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Pengaturan Kepegawaian
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl">
                    Manajemen Jenis Cuti
                </h1>
                <p class="mt-2 text-sm leading-6 text-stone-500">
                    Kelola kategori cuti yang tersedia untuk pengajuan dan administrasi karyawan.
                </p>
            </div>

            <a href="{{ route('leave-types.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl  bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jenis Cuti
            </a>
        </div>

        @include('partials.flash')

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Total Jenis Cuti</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-800">
                            {{ $leaveTypes->total() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-500">Sesuai hasil pencarian</p>
                    </div>
                    <div class="rounded-xl bg-stone-100 p-3 text-stone-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Jenis Cuti Aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#A85435]">
                            {{ $leaveTypes->getCollection()->where('is_active', true)->count() }}
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
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Jenis Cuti Nonaktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-500">
                            {{ $leaveTypes->getCollection()->where('is_active', false)->count() }}
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
                <h2 class="font-semibold text-stone-800">Pencarian dan Filter</h2>
                <p class="mt-1 text-sm text-stone-500">
                    Temukan jenis cuti berdasarkan nama, kode, atau statusnya.
                </p>
            </div>

            <form method="GET" action="{{ route('leave-types.index') }}"
                class="grid grid-cols-1 gap-3 md:grid-cols-[minmax(0,1fr)_220px_auto_auto]">

                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7" />
                        <path stroke-linecap="round" d="m20 20-4-4" />
                    </svg>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau kode cuti..."
                        class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] py-2.5 pl-10 pr-3 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                </div>

                <select name="status"
                    class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    <option value="">Semua status</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                </select>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#403B36]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M6 9h12m-9 5h6m-4 5h2" />
                    </svg>
                    Terapkan
                </button>

                <a href="{{ route('leave-types.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                    Reset
                </a>
            </form>
        </div>

        {{-- Leave Types Table --}}
        <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-1 border-b border-stone-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-semibold text-stone-800">Daftar Jenis Cuti</h2>
                    <p class="mt-1 text-xs text-stone-500">
                        Menampilkan {{ $leaveTypes->count() }} dari {{ $leaveTypes->total() }} jenis cuti.
                    </p>
                </div>
                <span class="w-fit rounded-lg bg-[#F8F0EB] px-3 py-1.5 text-xs font-semibold text-[#A85435]">
                    Konfigurasi Cuti
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-[#FCFAF8]">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                            <th class="px-5 py-4">Jenis Cuti</th>
                            <th class="px-5 py-4">Kode</th>
                            <th class="px-5 py-4 text-center">Pengajuan</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($leaveTypes as $leaveType)
                            <tr class="transition hover:bg-[#FCFAF8]">
                                <td class="px-5 py-4">
                                    <div class="flex min-w-56 items-start gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-stone-800">
                                                {{ $leaveType->name }}
                                            </p>
                                            <p class="mt-1 max-w-sm text-xs leading-5 text-stone-500">
                                                {{ $leaveType->description ?: 'Belum ada deskripsi jenis cuti.' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex rounded-lg border border-stone-200 bg-stone-50 px-2.5 py-1.5 font-mono text-xs font-semibold tracking-wide text-stone-700">
                                        {{ $leaveType->code }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span
                                        class="inline-flex min-w-10 items-center justify-center rounded-lg bg-stone-100 px-3 py-1.5 font-semibold text-stone-700">
                                        {{ $leaveType->leave_requests_count }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($leaveType->is_active)
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
                                        <a href="{{ route('leave-types.edit', $leaveType) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-600 transition hover:border-[#C96F4A]/40 hover:bg-[#F8F0EB] hover:text-[#A85435]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l2.651 2.651M8 16l-1 4 4-1L20 10a2.121 2.121 0 00-3-3L8 16z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('leave-types.destroy', $leaveType) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus jenis cuti {{ addslashes($leaveType->name) }}?')">
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
                                                d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 01-1 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 font-semibold text-stone-800">
                                        Jenis cuti tidak ditemukan
                                    </h3>
                                    <p class="mt-1 text-sm text-stone-500">
                                        Tidak ada jenis cuti yang sesuai dengan pencarian atau filter.
                                    </p>
                                    <a href="{{ route('leave-types.create') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#292724] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#403B36]">
                                        <span>+</span> Tambah Jenis Cuti
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($leaveTypes->hasPages())
                <div class="border-t border-stone-200 px-5 py-4">
                    {{ $leaveTypes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
