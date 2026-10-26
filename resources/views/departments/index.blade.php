@extends('layouts.app')

@section('title', 'Departemen')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                    <span class="h-1.5 w-6 rounded-full bg-[#C96F4A]"></span>
                    Pengaturan Admin
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                    Manajemen Departemen
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                    Kelola struktur unit organisasi, status departemen, dan keterkaitannya dengan karyawan serta jabatan.
                </p>
            </div>

            <a href="{{ route('departments.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                </svg>
                Tambah Departemen
            </a>
        </div>

        @include('partials.flash')

        {{-- Ringkasan --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Total departemen</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]">
                            {{ $departments->total() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Sesuai hasil pencarian</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="4" width="18" height="16" rx="2" />
                            <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Departemen aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]">
                            {{ $departments->getCollection()->where('is_active', true)->count() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Pada halaman ini</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8 12 2.5 2.5L16 9" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Departemen nonaktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]">
                            {{ $departments->getCollection()->where('is_active', false)->count() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Pada halaman ini</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9" />
                            <path stroke-linecap="round" d="M8 12h8" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Total karyawan</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]">
                            {{ $departments->getCollection()->sum('employees_count') }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Pada departemen di halaman ini</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 9v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pencarian --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7" />
                        <path stroke-linecap="round" d="m16 16 4 4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-[#292724]">Pencarian Departemen</h2>
                    <p class="mt-0.5 text-xs text-stone-500">Cari berdasarkan nama atau kode departemen.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('departments.index') }}" class="p-5 sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative min-w-0 flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m16 16 4 4" />
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Masukkan nama atau kode departemen..."
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] py-3 pl-10 pr-4 text-sm text-[#292724] outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                    </div>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#403C37] focus:outline-none focus:ring-4 focus:ring-stone-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m16 16 4 4" />
                        </svg>
                        Cari
                    </button>

                    <a href="{{ route('departments.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-3 text-sm font-semibold text-stone-600 transition hover:border-stone-300 hover:bg-stone-50">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        {{-- Daftar departemen --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
            <div
                class="flex flex-col justify-between gap-2 border-b border-stone-100 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
                <div>
                    <h2 class="text-base font-bold text-[#292724]">Daftar Departemen</h2>
                    <p class="mt-1 text-xs text-stone-500">
                        Menampilkan {{ $departments->firstItem() ?? 0 }}–{{ $departments->lastItem() ?? 0 }}
                        dari {{ $departments->total() }} departemen
                    </p>
                </div>
                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-semibold text-[#A85435]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Struktur organisasi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[900px] w-full text-left text-sm">
                    <thead class="bg-[#FCFAF8] text-[11px] font-bold uppercase tracking-wider text-stone-500">
                        <tr>
                            <th class="px-6 py-4">Departemen</th>
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Karyawan</th>
                            <th class="px-6 py-4">Jabatan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($departments as $department)
                            <tr class="transition hover:bg-[#FCFAF8]">
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435] ring-1 ring-[#EBD4C7]">
                                            {{ mb_strtoupper(mb_substr($department->code ?: $department->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0 max-w-sm">
                                            <p class="font-semibold text-[#292724]">{{ $department->name }}</p>
                                            <p class="mt-1 text-xs leading-5 text-stone-500">
                                                {{ $department->description ?: 'Belum ada deskripsi departemen.' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-lg border border-stone-200 bg-stone-50 px-2.5 py-1.5 font-mono text-xs font-semibold text-stone-600">
                                        {{ $department->code }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 9v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                            </svg>
                                        </div>
                                        <span
                                            class="font-semibold text-[#292724]">{{ $department->employees_count }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.8">
                                                <rect x="3" y="4" width="18" height="16" rx="2" />
                                                <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h4" />
                                            </svg>
                                        </div>
                                        <span
                                            class="font-semibold text-[#292724]">{{ $department->positions_count }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($department->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-600 ring-1 ring-inset ring-stone-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('departments.edit', $department) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-600 transition hover:border-[#C96F4A] hover:bg-[#F8F0EB] hover:text-[#A85435]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16 4 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('departments.destroy', $department) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus departemen {{ addslashes($department->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-100 px-3 py-2 text-xs font-semibold text-red-600 transition hover:border-red-200 hover:bg-red-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 6h18M9 6V4h6v2m-9 0 1 14h8l1-14M10 10v6m4-6v6" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="4" width="18" height="16" rx="2" />
                                            <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h4" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 font-semibold text-[#292724]">Departemen tidak ditemukan</p>
                                    <p class="mt-1 text-sm text-stone-500">
                                        Coba kata kunci lain atau reset pencarian.
                                    </p>
                                    <a href="{{ route('departments.index') }}"
                                        class="mt-4 inline-flex text-sm font-semibold text-[#A85435] hover:underline">
                                        Reset pencarian
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($departments->hasPages())
                <div class="border-t border-stone-100 px-5 py-4 sm:px-6">
                    {{ $departments->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
