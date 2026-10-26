```blade
@extends('layouts.app')

@section('title', 'Saldo dan Kuota Cuti')
@section('heading', 'Saldo dan Kuota Cuti')

@section('content')
    <div class="mx-auto max-w-350 space-y-7">

        {{-- Page Header --}}
        <section
            class="relative overflow-hidden rounded-2xl border border-[#EBD9CF] bg-linear-to-br from-[#FCFAF8] via-white to-[#F8F0EB] p-6 sm:p-8">
            <div class="absolute -right-12 -top-16 h-56 w-56 rounded-full bg-[#C96F4A]/5"></div>
            <div class="absolute -bottom-20 right-36 h-44 w-44 rounded-full bg-[#C96F4A]/5"></div>

            <div class="relative flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div class="max-w-2xl">
                    <div
                        class="mb-3 inline-flex items-center gap-2 rounded-full border border-[#EBD9CF] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-[#A85435]">
                        <span class="h-2 w-2 rounded-full bg-[#C96F4A]"></span>
                        Administrasi SDM
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-[#292724] sm:text-3xl">
                        Saldo dan Kuota Cuti
                    </h1>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-stone-600 sm:text-base">
                        Kelola alokasi cuti tahunan, pantau pemakaian, dan periksa sisa kuota setiap karyawan.
                    </p>
                </div>

                <a href="{{ route('leave-balances.create', ['year' => $year]) }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                    </svg>
                    Tambah Kuota
                </a>
            </div>
        </section>

        {{-- Flash Message --}}
        @include('partials.flash')

        {{-- Summary --}}
        @php
            $totalQuota = $balances->sum('quota_days');
            $totalUsed = $balances->sum('used_days');
            $totalRemaining = $balances->sum('remaining_days');
        @endphp

        <section>
            <div class="mb-4">
                <h2 class="text-base font-bold text-[#292724]">Ringkasan Kuota</h2>
                <p class="mt-1 text-sm text-stone-500">
                    Rekap dari data yang ditampilkan untuk tahun {{ $year }}.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div
                    class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-500">Total Kuota</p>
                            <p class="mt-3 text-3xl font-extrabold tracking-tight text-[#292724]">
                                {{ $totalQuota }}
                                <span class="text-sm font-semibold text-stone-500">hari</span>
                            </p>
                            <p class="mt-1 text-xs text-stone-500">Akumulasi kuota cuti</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-amber-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-500">Cuti Terpakai</p>
                            <p class="mt-3 text-3xl font-extrabold tracking-tight text-amber-700">
                                {{ $totalUsed }}
                                <span class="text-sm font-semibold text-stone-500">hari</span>
                            </p>
                            <p class="mt-1 text-xs text-stone-500">Akumulasi cuti digunakan</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-500">Sisa Kuota</p>
                            <p class="mt-3 text-3xl font-extrabold tracking-tight text-emerald-700">
                                {{ $totalRemaining }}
                                <span class="text-sm font-semibold text-stone-500">hari</span>
                            </p>
                            <p class="mt-1 text-xs text-stone-500">Akumulasi sisa cuti</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Filters --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16M7 12h10m-7 7h4" />
                    </svg>
                </span>
                <div>
                    <h2 class="font-bold text-[#292724]">Filter Data Kuota</h2>
                    <p class="mt-0.5 text-xs text-stone-500">Cari berdasarkan tahun, jenis cuti, atau karyawan.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('leave-balances.index') }}"
                class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-4 lg:items-end sm:p-6">

                <div>
                    <label for="year" class="mb-2 block text-sm font-semibold text-stone-700">Tahun</label>
                    <input type="number" id="year" name="year" value="{{ $year }}" min="2000"
                        max="2100"
                        class="w-full rounded-xl border border-stone-300 px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                </div>

                <div>
                    <label for="leave_type_id" class="mb-2 block text-sm font-semibold text-stone-700">Jenis Cuti</label>
                    <select id="leave_type_id" name="leave_type_id"
                        class="w-full rounded-xl border border-stone-300 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        <option value="">Semua jenis cuti</option>
                        @foreach ($leaveTypes as $type)
                            <option value="{{ $type->id }}" @selected(request('leave_type_id') == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-stone-700">Cari Karyawan</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Nama atau nomor karyawan"
                        class="w-full rounded-xl border border-stone-300 px-3 py-2.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('leave-balances.index') }}"
                        class="inline-flex flex-1 items-center justify-center rounded-xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                        Reset
                    </a>
                    <button type="submit"
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#292724] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#403B36] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                        </svg>
                        Terapkan
                    </button>
                </div>
            </form>
        </section>

        {{-- Balance Table --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-2 border-b border-stone-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-lg font-extrabold text-[#292724]">Daftar Saldo Cuti Karyawan</h2>
                    <p class="mt-1 text-sm text-stone-500">Informasi kuota, penggunaan, dan sisa cuti setiap karyawan.</p>
                </div>
                <span
                    class="inline-flex w-fit items-center rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-bold text-[#A85435]">
                    {{ $balances->total() }} data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-[#FCFAF8] text-left text-xs uppercase tracking-wider text-stone-500">
                        <tr>
                            <th class="px-5 py-4 font-bold sm:px-6">Karyawan</th>
                            <th class="px-5 py-4 font-bold">Departemen</th>
                            <th class="px-5 py-4 font-bold">Jenis Cuti</th>
                            <th class="px-5 py-4 text-center font-bold">Kuota</th>
                            <th class="px-5 py-4 text-center font-bold">Terpakai</th>
                            <th class="px-5 py-4 text-center font-bold">Sisa</th>
                            <th class="px-5 py-4 text-right font-bold sm:px-6">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($balances as $balance)
                            @php
                                $quota = max(0, (int) $balance->quota_days);
                                $used = max(0, (int) $balance->used_days);
                                $usagePercentage = $quota > 0 ? min(100, ($used / $quota) * 100) : 0;
                            @endphp

                            <tr class="transition hover:bg-[#FCFAF8]">
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-extrabold text-[#A85435]">
                                            {{ mb_strtoupper(mb_substr($balance->employee->full_name, 0, 1)) }}
                                        </span>
                                        <div>
                                            <p class="font-bold text-[#292724]">{{ $balance->employee->full_name }}</p>
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $balance->employee->employee_number }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-stone-600">
                                    {{ $balance->employee->department->name ?? '-' }}
                                </td>

                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700">
                                        {{ $balance->leaveType->name }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <span class="font-bold text-[#292724]">{{ $balance->quota_days }}</span>
                                    <span class="text-xs text-stone-500">hari</span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <span class="font-bold text-amber-700">{{ $balance->used_days }}</span>
                                    <span class="text-xs text-stone-500">hari</span>
                                    <div class="mx-auto mt-2 h-1.5 w-16 overflow-hidden rounded-full bg-stone-100">
                                        <div class="h-full rounded-full bg-amber-500"
                                            style="width: {{ $usagePercentage }}%"></div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <span
                                        class="font-extrabold {{ $balance->remaining_days > 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                                        {{ $balance->remaining_days }}
                                    </span>
                                    <span class="text-xs text-stone-500">hari</span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 sm:px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('leave-balances.edit', $balance) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-[#EBD9CF] bg-white px-3 py-2 text-xs font-bold text-[#A85435] transition hover:bg-[#F8F0EB]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('leave-balances.destroy', $balance) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus kuota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 px-3 py-2 text-xs font-bold text-rose-600 transition hover:bg-rose-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <span
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5z" />
                                        </svg>
                                    </span>
                                    <p class="mt-4 font-bold text-[#292724]">Belum ada kuota cuti</p>
                                    <p class="mt-1 text-sm text-stone-500">
                                        Tidak ada data yang cocok untuk filter tahun {{ $year }}.
                                    </p>
                                    <a href="{{ route('leave-balances.create', ['year' => $year]) }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#292724] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#403B36]">
                                        <span>+</span> Tambah Kuota
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($balances->hasPages())
                <div class="border-t border-stone-100 px-5 py-4 sm:px-6">
                    {{ $balances->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
```
