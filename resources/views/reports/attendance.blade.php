@extends('layouts.app')

@section('title', 'Laporan Absensi')
@section('heading', 'Laporan Absensi')

@section('content')
    @php
        $statusOptions = [
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'permission' => 'Izin',
            'sick' => 'Sakit',
            'absent' => 'Tidak Hadir',
        ];

        $statusStyles = [
            'present' => [
                'label' => 'Hadir',
                'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
                'dot' => 'bg-emerald-500',
                'icon' => 'M5 13l4 4L19 7',
            ],
            'late' => [
                'label' => 'Terlambat',
                'class' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
                'dot' => 'bg-amber-500',
                'icon' => 'M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            'permission' => [
                'label' => 'Izin',
                'class' => 'bg-sky-50 text-sky-700 ring-sky-600/15',
                'dot' => 'bg-sky-500',
                'icon' => 'M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z',
            ],
            'sick' => [
                'label' => 'Sakit',
                'class' => 'bg-violet-50 text-violet-700 ring-violet-600/15',
                'dot' => 'bg-violet-500',
                'icon' => 'M12 8v8m-4-4h8m5 0a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            'absent' => [
                'label' => 'Tidak Hadir',
                'class' => 'bg-rose-50 text-rose-700 ring-rose-600/15',
                'dot' => 'bg-rose-500',
                'icon' => 'M6 18L18 6M6 6l12 12',
            ],
        ];

        $summaryCards = [
            [
                'key' => 'present',
                'label' => 'Hadir',
                'description' => 'Kehadiran tercatat',
                'icon' => 'M5 13l4 4L19 7',
                'iconBg' => 'bg-emerald-50',
                'iconColor' => 'text-emerald-600',
            ],
            [
                'key' => 'late',
                'label' => 'Terlambat',
                'description' => 'Kehadiran terlambat',
                'icon' => 'M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z',
                'iconBg' => 'bg-amber-50',
                'iconColor' => 'text-amber-600',
            ],
            [
                'key' => 'permission',
                'label' => 'Izin',
                'description' => 'Tidak hadir dengan izin',
                'icon' => 'M8 7V3m8 4V3M5 11h14',
                'iconBg' => 'bg-sky-50',
                'iconColor' => 'text-sky-600',
            ],
            [
                'key' => 'sick',
                'label' => 'Sakit',
                'description' => 'Ketidakhadiran karena sakit',
                'icon' => 'M12 8v8m-4-4h8',
                'iconBg' => 'bg-violet-50',
                'iconColor' => 'text-violet-600',
            ],
            [
                'key' => 'absent',
                'label' => 'Tidak Hadir',
                'description' => 'Tanpa kehadiran tercatat',
                'icon' => 'M6 18L18 6M6 6l12 12',
                'iconBg' => 'bg-rose-50',
                'iconColor' => 'text-rose-600',
            ],
        ];
    @endphp

    <div class="space-y-6">

        {{-- Page Header --}}
        <section class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="absolute inset-y-0 left-0 w-1.5 bg-[#C96F4A]"></div>

            <div class="flex flex-col gap-5 p-5 pl-7 sm:flex-row sm:items-center sm:justify-between sm:p-7 sm:pl-9">
                <div class="min-w-0">
                    <div class="mb-3 flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold uppercase tracking-[0.16em] text-stone-500">
                            Laporan & Analitik HR
                        </span>
                    </div>

                    <h2 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                        Laporan Absensi Karyawan
                    </h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                        Pantau rekap kehadiran, tinjau status absensi, dan unduh data untuk kebutuhan administrasi SDM.
                    </p>
                </div>

                <a href="{{ route('reports.attendance.export', request()->query()) }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85E3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M5 17v3h14v-3" />
                    </svg>
                    Ekspor CSV
                </a>
            </div>
        </section>

        {{-- Filters --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="flex items-start gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                <span
                    class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4" />
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-[#292724]">Filter Data Absensi</h3>
                    <p class="mt-1 text-xs leading-5 text-stone-500">
                        Atur periode dan kriteria untuk menampilkan data yang dibutuhkan.
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('reports.attendance') }}" class="p-5 sm:p-6">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    <div>
                        <label for="start_date" class="mb-2 block text-sm font-semibold text-stone-700">
                            Dari tanggal
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                    </div>

                    <div>
                        <label for="end_date" class="mb-2 block text-sm font-semibold text-stone-700">
                            Sampai tanggal
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                    </div>

                    <div>
                        <label for="department_id" class="mb-2 block text-sm font-semibold text-stone-700">
                            Departemen
                        </label>
                        <select id="department_id" name="department_id"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                            <option value="">Semua departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected((string) ($filters['department_id'] ?? '') === (string) $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-semibold text-stone-700">
                            Status absensi
                        </label>
                        <select id="status" name="status"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                            <option value="">Semua status</option>
                            @foreach ($statusOptions as $key => $label)
                                <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="search" class="mb-2 block text-sm font-semibold text-stone-700">
                            Cari karyawan
                        </label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" d="m16 16 4 4" />
                            </svg>
                            <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}"
                                placeholder="Nama atau nomor karyawan"
                                class="w-full rounded-xl border border-stone-300 bg-white py-2.5 pl-10 pr-3.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        </div>
                    </div>
                </div>

                <div
                    class="mt-6 flex flex-col gap-3 border-t border-stone-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs leading-5 text-stone-500">
                        Gunakan filter untuk mempersempit hasil laporan sesuai kebutuhan.
                    </p>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row">
                        <a href="{{ route('reports.attendance') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-50 hover:text-stone-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 7v5h5M5.5 16a8 8 0 101.2-9.2L4 12" />
                            </svg>
                            Reset
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#403B36] focus:outline-none focus:ring-4 focus:ring-stone-400/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4" />
                            </svg>
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </section>

        {{-- Attendance Summary --}}
        <section>
            <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#292724]">Ringkasan Kehadiran</h3>
                    <p class="mt-1 text-sm text-stone-500">
                        Rekap status berdasarkan filter laporan yang diterapkan.
                    </p>
                </div>
                <p class="text-xs font-medium text-stone-400">5 kategori status</p>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-5">
                @foreach ($summaryCards as $item)
                    <div
                        class="rounded-2xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-stone-600">
                                    {{ $item['label'] }}
                                </p>
                                <p class="mt-1 text-xs leading-5 text-stone-400">
                                    {{ $item['description'] }}
                                </p>
                            </div>
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $item['iconBg'] }} {{ $item['iconColor'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-5 border-t border-stone-100 pt-3">
                            <p class="text-2xl font-bold tracking-tight text-[#292724]">
                                {{ number_format($summary[$item['key']] ?? 0) }}
                            </p>
                            <p class="mt-1 text-xs text-stone-400">catatan absensi</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Attendance Table --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-4 border-b border-stone-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-start gap-3">
                    <span
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-[#292724]">Detail Data Absensi</h3>
                        <p class="mt-1 text-sm text-stone-500">
                            Menampilkan {{ $attendances->count() }} dari {{ number_format($attendances->total()) }}
                            catatan.
                        </p>
                    </div>
                </div>

                <div
                    class="inline-flex w-fit items-center gap-2 rounded-lg border border-stone-200 bg-stone-50 px-3 py-2 text-xs font-medium text-stone-600">
                    <span class="h-2 w-2 rounded-full bg-[#C96F4A]"></span>
                    Data laporan
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50/80">
                        <tr>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Karyawan
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Departemen
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Status
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Jam Masuk
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Jam Keluar
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($attendances as $attendance)
                            @php
                                $status = $statusStyles[$attendance->status] ?? [
                                    'label' => ucfirst($attendance->status),
                                    'class' => 'bg-stone-100 text-stone-600 ring-stone-500/10',
                                    'dot' => 'bg-stone-400',
                                    'icon' => '',
                                ];
                            @endphp

                            <tr class="transition-colors hover:bg-[#FCFAF8]">
                                <td class="whitespace-nowrap px-5 py-4 align-middle">
                                    <div class="font-semibold text-stone-700">
                                        {{ $attendance->attendance_date?->format('d M Y') ?? $attendance->attendance_date }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#EBD9CF] bg-[#F8F0EB] text-sm font-bold text-[#A85435]">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($attendance->employee?->full_name ?? 'K', 0, 1)) }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-[#292724]">
                                                {{ $attendance->employee?->full_name ?? '-' }}
                                            </p>
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $attendance->employee?->employee_number ?? 'Nomor karyawan tidak tersedia' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 align-middle text-stone-600">
                                    {{ $attendance->employee?->department?->name ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 align-middle">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full px-2.5 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $status['class'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $status['label'] }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 align-middle">
                                    <span class="inline-flex items-center gap-2 text-sm font-medium text-stone-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-stone-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="9" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                        </svg>
                                        {{ $attendance->check_in ?: '-' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 align-middle">
                                    <span class="inline-flex items-center gap-2 text-sm font-medium text-stone-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-stone-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="9" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                        </svg>
                                        {{ $attendance->check_out ?: '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                        </svg>
                                    </div>
                                    <h4 class="mt-4 text-sm font-bold text-stone-700">
                                        Data absensi tidak ditemukan
                                    </h4>
                                    <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-stone-500">
                                        Tidak ada catatan yang sesuai dengan filter saat ini. Coba ubah periode atau
                                        kriteria pencarian.
                                    </p>
                                    <a href="{{ route('reports.attendance') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-[#A85435] transition hover:bg-[#F8F0EB]">
                                        Reset filter
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 12h14m-6-6l6 6-6 6" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($attendances->hasPages())
                <div class="border-t border-stone-100 bg-white px-5 py-4 sm:px-6">
                    {{ $attendances->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
