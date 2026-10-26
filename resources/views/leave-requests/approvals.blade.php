@extends('layouts.app')

@section('title', 'Persetujuan Cuti')
@section('heading', 'Persetujuan Cuti')

@section('content')
    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                'dot' => 'bg-amber-500',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                'dot' => 'bg-emerald-500',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                'dot' => 'bg-rose-500',
            ],
        ];
    @endphp

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
                        Persetujuan Cuti
                    </h1>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-stone-600 sm:text-base">
                        Tinjau permohonan cuti karyawan, periksa periode pengajuan, dan tetapkan keputusan secara
                        terstruktur.
                    </p>
                </div>

                <div class="flex items-center gap-3 rounded-xl border border-white bg-white/80 p-4 shadow-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5-2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h8l6 6z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-medium text-stone-500">Total pengajuan</p>
                        <p class="mt-0.5 text-xl font-extrabold text-[#292724]">
                            {{ $summary['pending'] + $summary['approved'] + $summary['rejected'] }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Flash Message --}}
        @if (session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <div>
                    <p class="font-bold text-emerald-800">Berhasil</p>
                    <p class="mt-1 text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Summary Cards --}}
        <section>
            <div class="mb-4">
                <h2 class="text-base font-bold text-[#292724]">Ringkasan Pengajuan</h2>
                <p class="mt-1 text-sm text-stone-500">Rekap jumlah pengajuan berdasarkan statusnya.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div
                    class="rounded-2xl border border-amber-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-600">Menunggu Persetujuan</p>
                            <p class="mt-3 text-3xl font-extrabold tracking-tight text-amber-700">{{ $summary['pending'] }}
                            </p>
                            <p class="mt-1 text-xs text-stone-500">Memerlukan tinjauan HR</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-amber-100">
                        <div class="h-full rounded-full bg-amber-500" style="width: 100%"></div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-600">Disetujui</p>
                            <p class="mt-3 text-3xl font-extrabold tracking-tight text-emerald-700">
                                {{ $summary['approved'] }}</p>
                            <p class="mt-1 text-xs text-stone-500">Pengajuan telah disetujui</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-emerald-100">
                        <div class="h-full rounded-full bg-emerald-500" style="width: 100%"></div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-rose-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-600">Ditolak</p>
                            <p class="mt-3 text-3xl font-extrabold tracking-tight text-rose-700">{{ $summary['rejected'] }}
                            </p>
                            <p class="mt-1 text-xs text-stone-500">Pengajuan tidak disetujui</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-rose-100">
                        <div class="h-full rounded-full bg-rose-500" style="width: 100%"></div>
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
                    <h2 class="font-bold text-[#292724]">Filter Pengajuan</h2>
                    <p class="mt-0.5 text-xs text-stone-500">Persempit data berdasarkan karyawan, status, atau tanggal.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('leave-approvals.index') }}"
                class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-5 lg:p-6">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-2 block text-sm font-semibold text-stone-700">Cari karyawan</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-stone-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <circle cx="10.5" cy="10.5" r="6.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 15.5L21 21" />
                            </svg>
                        </span>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Nama atau nomor karyawan"
                            class="w-full rounded-xl border border-stone-300 bg-white py-2.5 pl-10 pr-3 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                    </div>
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-stone-700">Status</label>
                    <select name="status" id="status"
                        class="w-full rounded-xl border border-stone-300 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        <option value="">Semua status</option>
                        <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                        <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                        <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label for="date_from" class="mb-2 block text-sm font-semibold text-stone-700">Tanggal mulai</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                        class="w-full rounded-xl border border-stone-300 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                </div>

                <div>
                    <label for="date_to" class="mb-2 block text-sm font-semibold text-stone-700">Sampai tanggal</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                        class="w-full rounded-xl border border-stone-300 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                </div>

                <div class="flex flex-col gap-2 sm:col-span-2 lg:col-span-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('leave-approvals.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-stone-300 px-5 py-2.5 text-sm font-semibold text-stone-600 transition hover:border-stone-400 hover:bg-stone-50">
                        Reset Filter
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#403B36] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                        </svg>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </section>

        {{-- Requests Table --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-2 border-b border-stone-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-lg font-bold text-[#292724]">Daftar Pengajuan Cuti</h2>
                    <p class="mt-1 text-sm text-stone-500">Periksa informasi dan buka detail untuk meninjau pengajuan.</p>
                </div>
                <span
                    class="inline-flex w-fit items-center rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-bold text-[#A85435]">
                    {{ $leaveRequests->total() }} data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-[#FCFAF8] text-left text-xs uppercase tracking-wider text-stone-500">
                        <tr>
                            <th class="px-5 py-4 font-bold sm:px-6">Karyawan</th>
                            <th class="px-5 py-4 font-bold">Jenis Cuti</th>
                            <th class="px-5 py-4 font-bold">Periode Cuti</th>
                            <th class="px-5 py-4 font-bold">Status</th>
                            <th class="px-5 py-4 font-bold">Tanggal Pengajuan</th>
                            <th class="px-5 py-4 text-right font-bold sm:px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($leaveRequests as $item)
                            @php
                                $itemStatus = $statusStyles[$item->status] ?? $statusStyles['pending'];
                            @endphp
                            <tr class="transition hover:bg-[#FCFAF8]">
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-extrabold text-[#A85435]">
                                            {{ mb_strtoupper(mb_substr($item->employee->full_name, 0, 1)) }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="font-bold text-[#292724]">{{ $item->employee->full_name }}</p>
                                            <p class="mt-1 text-xs text-stone-500">{{ $item->employee->employee_number }}
                                            </p>
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $item->employee->department->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-stone-700">{{ $item->leaveType->name }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="font-semibold text-stone-700">{{ $item->start_date->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs text-stone-500">s.d. {{ $item->end_date->format('d M Y') }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex items-center gap-2 whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-bold ring-1 ring-inset {{ $itemStatus['class'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $itemStatus['dot'] }}"></span>
                                        {{ $itemStatus['label'] }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-stone-600">
                                    {{ $item->created_at->format('d M Y') }}
                                    <p class="mt-1 text-xs text-stone-400">{{ $item->created_at->format('H:i') }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right sm:px-6">
                                    <a href="{{ route('leave-approvals.show', $item) }}"
                                        class="inline-flex items-center gap-2 rounded-lg border border-[#EBD9CF] bg-white px-3.5 py-2 text-xs font-bold text-[#A85435] transition hover:border-[#C96F4A] hover:bg-[#F8F0EB]">
                                        Tinjau
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 12h14m-6-6l6 6-6 6" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <span
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <circle cx="10.5" cy="10.5" r="6.5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 15.5L21 21" />
                                        </svg>
                                    </span>
                                    <p class="mt-4 font-bold text-[#292724]">Tidak ada pengajuan ditemukan</p>
                                    <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-stone-500">
                                        Belum ada data yang sesuai dengan filter. Coba ubah kriteria pencarian atau reset
                                        filter.
                                    </p>
                                    <a href="{{ route('leave-approvals.index') }}"
                                        class="mt-4 inline-flex rounded-lg bg-[#292724] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#403B36]">
                                        Reset Filter
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($leaveRequests->hasPages())
                <div class="border-t border-stone-100 bg-white px-5 py-4 sm:px-6">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
