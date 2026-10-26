@extends('layouts.app')

@section('title', 'Riwayat Kepegawaian')

@section('content')
    @php
        $statusLabels = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'resigned' => 'Mengundurkan Diri',
            'terminated' => 'Hubungan Kerja Berakhir',
        ];

        $statusClasses = [
            'active' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/15',
            'inactive' => 'bg-stone-100 text-stone-600 ring-1 ring-stone-500/15',
            'resigned' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/15',
            'terminated' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-600/15',
        ];

        $currentStatus = $employee->employment_status;

        $changeLabels = [
            'employment_status' => 'Status Kepegawaian',
            'employment_type' => 'Jenis Kepegawaian',
            'department' => 'Departemen',
            'position' => 'Jabatan',
            'hire_date' => 'Tanggal Masuk',
            'contract_end_date' => 'Akhir Kontrak',
        ];

        $valueLabels = [
            'employment_status' => $statusLabels,
            'employment_type' => [
                'permanent' => 'Permanen',
                'contract' => 'Kontrak',
            ],
            'gender' => [
                'male' => 'Laki-laki',
                'female' => 'Perempuan',
            ],
        ];
    @endphp

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-stone-500">
                    <a href="{{ route('employees.index') }}" class="transition hover:text-[#C96F4A]">
                        Manajemen Karyawan
                    </a>
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                    </svg>
                    <span class="font-medium text-stone-700">Riwayat Kepegawaian</span>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-bold tracking-tight text-stone-900 sm:text-3xl">
                        Riwayat Kepegawaian
                    </h1>

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-[#C96F4A]/10 px-3 py-1 text-xs font-semibold text-[#B85D3B]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l2.5 2.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Audit Kepegawaian
                    </span>
                </div>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                    Dokumentasi perubahan status dan informasi kepegawaian untuk menjaga
                    keterlacakan data karyawan.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('employees.show', $employee) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-stone-200 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700! shadow-sm transition hover:bg-stone-50">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h11" />
                    </svg>
                    Detail Karyawan
                </a>

                <a href="{{ route('employees.employment-history.create', $employee) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#C96F4A] bg-[#C96F4A] px-4 py-2.5 text-sm font-semibold text-white! shadow-sm transition hover:border-[#B85D3B] hover:bg-[#B85D3B]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    Ubah Status
                </a>
            </div>
        </div>

        @include('partials.flash')

        {{-- Employee summary --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-100 bg-linear-to-r from-stone-50 to-white px-5 py-5 sm:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#C96F4A]/10 text-xl font-bold text-[#B85D3B] ring-1 ring-[#C96F4A]/15">
                        {{ strtoupper(substr($employee->full_name, 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-stone-400">
                            Profil Karyawan
                        </p>
                        <h2 class="mt-1 truncate text-xl font-bold text-stone-900">
                            {{ $employee->full_name }}
                        </h2>
                        <p class="mt-1 text-sm text-stone-500">
                            ID Karyawan:
                            <span class="font-semibold text-stone-700">{{ $employee->employee_number }}</span>
                        </p>
                    </div>

                    <div class="sm:text-right">
                        <p class="mb-2 text-xs font-medium uppercase tracking-wider text-stone-400">
                            Status Saat Ini
                        </p>
                        <span
                            class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClasses[$currentStatus] ?? 'bg-stone-100 text-stone-600' }}">
                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                            {{ $statusLabels[$currentStatus] ?? ucfirst(str_replace('_', ' ', $currentStatus)) }}
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="grid divide-y divide-stone-100 sm:grid-cols-2 sm:divide-y-0 lg:grid-cols-3 lg:divide-x lg:divide-y-0">
                <div class="px-5 py-4 sm:px-6">
                    <p class="text-xs font-medium uppercase tracking-wider text-stone-400">
                        Departemen
                    </p>
                    <p class="mt-1.5 font-semibold text-stone-800">
                        {{ $employee->department?->name ?? 'Belum ditentukan' }}
                    </p>
                </div>

                <div class="px-5 py-4 sm:px-6">
                    <p class="text-xs font-medium uppercase tracking-wider text-stone-400">
                        Jabatan
                    </p>
                    <p class="mt-1.5 font-semibold text-stone-800">
                        {{ $employee->position?->name ?? 'Belum ditentukan' }}
                    </p>
                </div>

                <div class="px-5 py-4 sm:col-span-2 sm:px-6 lg:col-span-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-stone-400">
                        Total Catatan
                    </p>
                    <p class="mt-1.5 font-semibold text-stone-800">
                        {{ $histories->total() }}
                        <span class="text-sm font-normal text-stone-500">perubahan tercatat</span>
                    </p>
                </div>
            </div>
        </section>


        {{-- History table --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">

            {{-- Table heading --}}
            <div
                class="flex flex-col gap-4 border-b border-stone-200 bg-[#292724] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#C96F4A]/15 text-[#E9A184]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7h8M8 11h8M8 15h5M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-base font-bold tracking-tight text-white">
                            Catatan Perubahan
                        </h2>
                        <p class="mt-1 text-sm leading-5 text-stone-400">
                            Rekam jejak perubahan informasi kepegawaian.
                        </p>
                    </div>
                </div>

                <div class="inline-flex w-fit items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2">
                    <span class="h-2 w-2 rounded-full bg-[#D98A68]"></span>
                    <span class="text-sm font-semibold text-stone-200">
                        {{ $histories->total() }} catatan
                    </span>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-left">
                    <thead>
                        <tr class="bg-[#F5F2EF]">
                            <th
                                class="whitespace-nowrap border-b border-stone-200 px-5 py-4 text-[10px] font-extrabold uppercase tracking-[0.14em] text-stone-500">
                                Tanggal Efektif
                            </th>
                            <th
                                class="whitespace-nowrap border-b border-stone-200 px-5 py-4 text-[10px] font-extrabold uppercase tracking-[0.14em] text-stone-500">
                                Jenis Perubahan
                            </th>
                            <th
                                class="min-w-40 border-b border-stone-200 px-5 py-4 text-[10px] font-extrabold uppercase tracking-[0.14em] text-stone-500">
                                Sebelum
                            </th>
                            <th
                                class="min-w-40 border-b border-stone-200 px-5 py-4 text-[10px] font-extrabold uppercase tracking-[0.14em] text-stone-500">
                                Sesudah
                            </th>
                            <th
                                class="min-w-52 border-b border-stone-200 px-5 py-4 text-[10px] font-extrabold uppercase tracking-[0.14em] text-stone-500">
                                Alasan Perubahan
                            </th>
                            <th
                                class="min-w-48 border-b border-stone-200 px-5 py-4 text-[10px] font-extrabold uppercase tracking-[0.14em] text-stone-500">
                                Dicatat Oleh
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($histories as $history)
                            @php
                                $changeType = $history->change_type;
                                $oldValue = $history->old_value;
                                $newValue = $history->new_value;

                                if (isset($valueLabels[$changeType])) {
                                    $oldValue = $valueLabels[$changeType][$oldValue] ?? $oldValue;
                                    $newValue = $valueLabels[$changeType][$newValue] ?? $newValue;
                                }

                                if (in_array($changeType, ['hire_date', 'contract_end_date'])) {
                                    try {
                                        $oldValue = $oldValue
                                            ? \Illuminate\Support\Carbon::parse($oldValue)->format('d M Y')
                                            : $oldValue;
                                    } catch (\Throwable $e) {
                                        // Pertahankan nilai asli jika format tanggal tidak valid.
                                    }

                                    try {
                                        $newValue = $newValue
                                            ? \Illuminate\Support\Carbon::parse($newValue)->format('d M Y')
                                            : $newValue;
                                    } catch (\Throwable $e) {
                                        // Pertahankan nilai asli jika format tanggal tidak valid.
                                    }
                                }

                                $changeBadgeClasses = match ($changeType) {
                                    'employment_status' => 'bg-[#C96F4A]/10 text-[#A95232] ring-[#C96F4A]/20',
                                    'employment_type' => 'bg-violet-50 text-violet-700 ring-violet-600/15',
                                    'department' => 'bg-sky-50 text-sky-700 ring-sky-600/15',
                                    'position' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
                                    'hire_date',
                                    'contract_end_date'
                                        => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
                                    default => 'bg-stone-100 text-stone-700 ring-stone-500/15',
                                };

                                $changeIcon = match ($changeType) {
                                    'employment_status' => 'activity',
                                    'employment_type' => 'briefcase-business',
                                    'department' => 'building-2',
                                    'position' => 'badge-check',
                                    'hire_date', 'contract_end_date' => 'calendar-days',
                                    default => 'file-text',
                                };
                            @endphp

                            <tr
                                class="group transition-colors duration-150 odd:bg-white even:bg-[#FCFAF8] hover:bg-[#FBF0EA]">

                                {{-- Effective date --}}
                                <td class="border-b border-stone-100 px-5 py-5 align-top">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-stone-200 bg-white text-stone-500 shadow-sm transition group-hover:border-[#C96F4A]/30 group-hover:text-[#B85D3B]">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" />
                                            </svg>
                                        </div>

                                        <div class="pt-0.5">
                                            <p class="whitespace-nowrap text-sm font-bold tabular-nums text-stone-800">
                                                {{ $history->effective_date?->format('d M Y') ?? '-' }}
                                            </p>
                                            <p class="mt-1 text-[11px] font-medium text-stone-400">
                                                Tanggal berlaku
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Change type --}}
                                <td class="border-b border-stone-100 px-5 py-5 align-top">
                                    <span
                                        class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-lg px-2.5 py-2 text-xs font-bold ring-1 ring-inset {{ $changeBadgeClasses }}">
                                        {{ $changeLabels[$changeType] ?? ucfirst(str_replace('_', ' ', $changeType)) }}
                                    </span>
                                </td>

                                {{-- Previous value --}}
                                <td class="border-b border-stone-100 px-5 py-5 align-top">
                                    <div class="max-w-48">
                                        <p class="text-sm leading-6 text-stone-500">
                                            {{ filled($oldValue) ? $oldValue : '—' }}
                                        </p>
                                    </div>
                                </td>

                                {{-- New value --}}
                                <td class="border-b border-stone-100 px-5 py-5 align-top">
                                    <div class="flex max-w-48 items-start gap-2">
                                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#C96F4A]"></span>
                                        <p class="text-sm font-bold leading-6 text-stone-800">
                                            {{ filled($newValue) ? $newValue : '—' }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Reason --}}
                                <td class="border-b border-stone-100 px-5 py-5 align-top">
                                    <p class="max-w-xs whitespace-normal wrap-break-word text-sm leading-6 text-stone-600">
                                        {{ $history->reason ?: 'Tidak ada keterangan' }}
                                    </p>
                                </td>

                                {{-- Changed by --}}
                                <td class="border-b border-stone-100 px-5 py-5 align-top">
                                    <div class="flex items-start gap-2.5">
                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#C96F4A]/15 bg-[#C96F4A]/10 text-xs font-extrabold text-[#A95232]">
                                            {{ strtoupper(substr($history->changedBy?->name ?? '?', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0 pt-0.5">
                                            <p class="max-w-40 wrap-break-word text-sm font-bold leading-5 text-stone-800">
                                                {{ $history->changedBy?->name ?? 'Pengguna tidak tersedia' }}
                                            </p>

                                            <p
                                                class="mt-1.5 whitespace-nowrap text-[11px] font-medium tabular-nums text-stone-400">
                                                {{ $history->created_at?->format('d M Y, H:i') ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-stone-200 bg-[#F5F2EF] text-stone-400">
                                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7h8M8 11h8M8 15h5M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 text-base font-bold text-stone-800">
                                        Belum Ada Riwayat Perubahan
                                    </h3>

                                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-stone-500">
                                        Perubahan informasi kepegawaian yang dicatat melalui sistem akan ditampilkan di
                                        sini.
                                    </p>

                                    <a href="{{ route('employees.employment-history.create', $employee) }}"
                                        class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-[#C96F4A] px-4 py-2.5 text-sm font-semibold text-white! transition hover:bg-[#B85D3B]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                        </svg>
                                        Catat Perubahan
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($histories->hasPages())
                <div
                    class="flex flex-col gap-3 border-t border-stone-200 bg-[#FCFAF8] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <p class="text-xs font-medium text-stone-500">
                        Menampilkan data riwayat kepegawaian
                    </p>

                    {{ $histories->links() }}
                </div>
            @endif
        </section>

        <p class="flex items-start gap-2 text-xs leading-5 text-stone-400">
            <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3m0 4h.01M10.3 3.9 2.7 17.2A2 2 0 0 0 4.4 20h15.2a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
            </svg>
            Riwayat ini digunakan sebagai dokumentasi perubahan data kepegawaian. Pastikan tanggal efektif dan alasan
            perubahan dicatat dengan benar.
        </p>
    </div>
@endsection
