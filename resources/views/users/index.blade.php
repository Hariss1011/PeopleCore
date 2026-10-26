@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                    <span class="h-1.5 w-6 rounded-full bg-[#C96F4A]"></span>
                    Pengaturan Admin
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-[#292724]! sm:text-3xl">
                    Manajemen Pengguna
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500!">
                    Kelola akun pengguna, hak akses sistem, dan hubungan akun dengan data karyawan.
                </p>
            </div>

            <a href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white! shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round" />
                </svg>
                Tambah Pengguna
            </a>

        </div>

        @include('partials.flash')

        {{-- Informasi ringkas --}}
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500!">Total akun ditampilkan</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]!">
                            {{ $users->total() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400!">Sesuai filter yang diterapkan</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]!">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 9v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500!">Akun Admin</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]!">
                            {{ (clone $users)->getCollection()->where('role', 'admin')->count() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400!">Pada halaman ini</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-stone-100 text-stone-700!">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3 19 6v5c0 4.5-3 7.5-7 10-4-2.5-7-5.5-7-10V6l7-3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500!">Akun terhubung</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#292724]!">
                            {{ (clone $users)->getCollection()->filter(fn($account) => $account->employee !== null)->count() }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400!">Pada halaman ini</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m-3-3h6" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
            <div class="border-b border-stone-100 px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 text-stone-600!">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m16 16 4 4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-[#292724]!">Cari dan filter pengguna</h2>
                        <p class="mt-0.5 text-xs text-stone-500!">Temukan akun berdasarkan identitas atau role.</p>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('users.index') }}" class="p-5 sm:p-6">
                <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_220px_auto]">
                    <div>
                        <label for="search" class="mb-2 block text-xs font-semibold text-stone-600!">
                            Kata kunci
                        </label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400!"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" d="m16 16 4 4" />
                            </svg>
                            <input id="search" type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama, email, atau role..."
                                class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] py-3 pl-10 pr-4 text-sm text-[#292724]! outline-none transition placeholder:text-stone-400! focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        </div>
                    </div>

                    <div>
                        <label for="role" class="mb-2 block text-xs font-semibold text-stone-600!">
                            Role pengguna
                        </label>
                        <select id="role" name="role"
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-3.5 py-3 text-sm text-[#292724]! outline-none transition focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                            <option value="">Semua role</option>
                            @foreach (['admin' => 'Admin', 'hr' => 'HR', 'employee' => 'Employee'] as $value => $label)
                                <option value="{{ $value }}" @selected(request('role') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col justify-end gap-2 sm:flex-row md:flex-col lg:flex-row">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-3 text-sm font-semibold text-white! transition hover:bg-[#403C37] focus:outline-none focus:ring-4 focus:ring-stone-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="m21 21-4.3-4.3" />
                                <circle cx="11" cy="11" r="7" />
                            </svg>
                            Terapkan
                        </button>
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-3 text-sm font-semibold text-stone-600! transition hover:border-stone-300 hover:bg-stone-50">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel pengguna --}}
        <div class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
            <div
                class="flex flex-col justify-between gap-2 border-b border-stone-100 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
                <div>
                    <h2 class="text-base font-bold text-[#292724]!">Daftar Pengguna</h2>
                    <p class="mt-1 text-xs text-stone-500!">
                        Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}
                        dari {{ $users->total() }} akun
                    </p>
                </div>
                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-semibold text-[#A85435]!">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Data akun sistem
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-212.5 w-full text-left text-sm">
                    <thead class="bg-[#FCFAF8] text-[11px] font-bold uppercase tracking-wider text-stone-500!">
                        <tr>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Role akses</th>
                            <th class="px-6 py-4">Data karyawan</th>
                            <th class="px-6 py-4">Departemen</th>
                            <th class="px-6 py-4 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($users as $account)
                            @php
                                $roleStyles = [
                                    'admin' => 'bg-stone-100 text-stone-700 ring-stone-200',
                                    'hr' => 'bg-[#F8F0EB] text-[#A85435] ring-[#EBD4C7]',
                                    'employee' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
                                ];
                                $roleLabels = [
                                    'admin' => 'Admin',
                                    'hr' => 'HR',
                                    'employee' => 'Employee',
                                ];
                                $initials = collect(preg_split('/\s+/', trim($account->name)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                                    ->implode('');
                            @endphp

                            <tr class="transition hover:bg-[#FCFAF8]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]! ring-1 ring-[#EBD4C7]">
                                            {{ $initials ?: 'U' }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-[#292724]!">{{ $account->name }}</p>
                                            <p class="mt-1 break-all text-xs text-stone-500!">{{ $account->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $roleStyles[$account->role] ?? 'bg-stone-100 text-stone-600 ring-stone-200' }}">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        {{ $roleLabels[$account->role] ?? ucfirst($account->role) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($account->employee)
                                        <p class="font-medium text-[#292724]!">{{ $account->employee->full_name }}</p>
                                        <p class="mt-1 text-xs text-stone-500!">
                                            {{ $account->employee->employee_number }}
                                        </p>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs text-stone-400!">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-300"></span>
                                            Belum terhubung
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-sm text-stone-600!">
                                        {{ $account->employee?->department?->name ?? '—' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('users.edit', $account) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-600! transition hover:border-[#C96F4A] hover:bg-[#F8F0EB] hover:text-[#A85435]!">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16 4 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
                                            </svg>
                                            Edit
                                        </a>

                                        @if ($account->id !== auth()->id())
                                            <form method="POST" action="{{ route('users.destroy', $account) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus akun {{ addslashes($account->name) }}?')">
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
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400!">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="11" cy="11" r="7" />
                                            <path stroke-linecap="round" d="m16 16 4 4" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 font-semibold text-[#292724]!">Pengguna tidak ditemukan</p>
                                    <p class="mt-1 text-sm text-stone-500!">
                                        Coba ubah kata kunci atau reset filter pencarian.
                                    </p>
                                    <a href="{{ route('users.index') }}"
                                        class="mt-4 inline-flex text-sm font-semibold text-[#A85435]! hover:underline">
                                        Reset filter
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t border-stone-100 px-5 py-4 sm:px-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
