@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $roleLabels = [
            'admin' => 'Administrator',
            'hr' => 'Human Resources',
            'employee' => 'Employee',
        ];

        $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);

        $periodLabel =
            \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') .
            ' — ' .
            \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y');

        $attendanceCards = [
            [
                'label' => 'Hadir',
                'value' => $attendanceStats['present'],
                'color' => 'text-emerald-700',
                'bg' => 'bg-emerald-50',
                'dot' => 'bg-emerald-500',
            ],
            [
                'label' => 'Terlambat',
                'value' => $attendanceStats['late'],
                'color' => 'text-amber-700',
                'bg' => 'bg-amber-50',
                'dot' => 'bg-amber-500',
            ],
            [
                'label' => 'Izin',
                'value' => $attendanceStats['permission'],
                'color' => 'text-sky-700',
                'bg' => 'bg-sky-50',
                'dot' => 'bg-sky-500',
            ],
            [
                'label' => 'Sakit',
                'value' => $attendanceStats['sick'],
                'color' => 'text-violet-700',
                'bg' => 'bg-violet-50',
                'dot' => 'bg-violet-500',
            ],
            [
                'label' => 'Tidak Hadir',
                'value' => $attendanceStats['absent'],
                'color' => 'text-rose-700',
                'bg' => 'bg-rose-50',
                'dot' => 'bg-rose-500',
            ],
        ];

        $quickLinks = $isEmployee
            ? [
                [
                    'title' => 'Absensi Saya',
                    'description' => 'Lihat riwayat kehadiran',
                    'route' => 'my.attendances.index',
                    'icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v13H4V6a1 1 0 0 1 1-1Z',
                ],
                [
                    'title' => 'Pengajuan Cuti',
                    'description' => 'Ajukan dan pantau cuti',
                    'route' => 'my.leave-requests.index',
                    'icon' => 'M12 8v4l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
                ],
                [
                    'title' => 'Saldo Cuti',
                    'description' => 'Periksa sisa hak cuti',
                    'route' => 'my.leave-balances.index',
                    'icon' => 'M4 6h16M4 12h16M4 18h10',
                ],
            ]
            : [
                [
                    'title' => 'Data Karyawan',
                    'description' => 'Kelola informasi karyawan',
                    'route' => 'employees.index',
                    'icon' =>
                        'M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m3-3h-6',
                ],
                [
                    'title' => 'Data Absensi',
                    'description' => 'Lihat dan kelola kehadiran',
                    'route' => 'attendances.index',
                    'icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v13H4V6a1 1 0 0 1 1-1Z',
                ],
                [
                    'title' => 'Laporan HR',
                    'description' => 'Rekap dan ekspor laporan',
                    'route' => 'reports.attendance',
                    'icon' => 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01',
                ],
                [
                    'title' => 'Persetujuan Cuti',
                    'description' => 'Tinjau pengajuan karyawan',
                    'route' => 'leave-approvals.index',
                    'icon' => 'M9 12l2 2 4-4m5 2a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z',
                ],
            ];

        if ($user->role === 'admin') {
            $quickLinks[] = [
                'title' => 'Manajemen Akun',
                'description' => 'Kelola akses pengguna',
                'route' => 'users.index',
                'icon' =>
                    'M12 15v2m-6 4h12a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2Zm6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z',
            ];

            $quickLinks[] = [
                'title' => 'Departemen',
                'description' => 'Kelola struktur organisasi',
                'route' => 'departments.index',
                'icon' => 'M3 21h18M5 21V7l8-4v18m6 0V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01',
            ];
        }

        $departmentColors = ['#B85C38', '#D49A78', '#6B7280', '#8B9A7A', '#C7A27C', '#64748B', '#A16207', '#78716C'];
    @endphp

    <div class="space-y-5">

        {{-- Header --}}
        <section class="relative overflow-hidden rounded-2xl bg-[#292724] px-5 py-5 text-white shadow-sm sm:px-7">
            <div
                class="pointer-events-none absolute -right-10 -top-16 h-52 w-52 rounded-full border-[28px] border-[#B85C38]/20">
            </div>
            <div class="pointer-events-none absolute -bottom-20 right-32 h-44 w-44 rounded-full bg-[#B85C38]/10 blur-2xl">
            </div>

            <div class="relative flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <div class="mb-2 flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-[#D49A78]"></span>
                        <span class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-300">
                            PeopleCore · {{ $roleLabel }}
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">
                        Selamat datang, {{ $user->name ?? 'Pengguna' }}.
                    </h1>

                    <p class="mt-1.5 max-w-2xl text-sm text-stone-300">
                        @if ($isEmployee)
                            Pantau kehadiran, pengajuan cuti, dan informasi kepegawaian Anda.
                        @else
                            Ringkasan operasional kepegawaian untuk membantu pemantauan dan pengambilan keputusan.
                        @endif
                    </p>
                </div>

                <div class="flex shrink-0 items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-4 py-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#B85C38]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M16 3v4M8 3v4M3 10h18" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400">Hari ini</p>
                        <p class="text-sm font-semibold">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Filter --}}
        @if ($canViewReports)
            <section class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm">
                <form method="GET" action="{{ route('dashboard') }}"
                    class="grid grid-cols-1 items-end gap-3 sm:grid-cols-2 xl:grid-cols-12">

                    <div class="xl:col-span-3">
                        <label for="start_date" class="mb-1.5 block text-xs font-semibold text-stone-600">
                            Dari Tanggal
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                            class="w-full rounded-lg border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div class="xl:col-span-3">
                        <label for="end_date" class="mb-1.5 block text-xs font-semibold text-stone-600">
                            Sampai Tanggal
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                            class="w-full rounded-lg border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div class="sm:col-span-2 xl:col-span-4">
                        <label for="department_id" class="mb-1.5 block text-xs font-semibold text-stone-600">
                            Departemen
                        </label>
                        <select id="department_id" name="department_id"
                            class="w-full rounded-lg border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                            <option value="">Semua Departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected((string) $departmentId === (string) $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 sm:col-span-2 xl:col-span-2">
                        <button type="submit"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-[#B85C38] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#9F4B2C]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 6h16M7 12h10m-7 6h4" />
                            </svg>
                            Terapkan
                        </button>

                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-stone-200 px-3 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-100"
                            title="Reset filter">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 12a9 9 0 1 0 3-6.7L3 8" />
                                <path d="M3 3v5h5" />
                            </svg>
                        </a>
                    </div>
                </form>

                <div class="mt-3 flex items-center gap-2 border-t border-stone-100 pt-3 text-xs text-stone-500">
                    <svg class="h-4 w-4 text-[#B85C38]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                    <span>Periode laporan:</span>
                    <span class="font-semibold text-stone-700">{{ $periodLabel }}</span>
                </div>
            </section>
        @endif

        {{-- KPI Cards --}}
        <section class="grid grid-cols-2 gap-3 xl:grid-cols-4">
            @if (!$isEmployee)
                <div
                    class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs font-medium text-stone-500">Karyawan Aktif</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-stone-800">
                                {{ number_format($activeEmployees) }}</p>
                            <p class="mt-1 text-xs text-stone-500">Karyawan terdaftar aktif</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F7E9E2] text-[#B85C38]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path
                                    d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m3-3h-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs font-medium text-stone-500">Departemen</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-stone-800">
                                {{ number_format($departmentCount) }}</p>
                            <p class="mt-1 text-xs text-stone-500">Unit organisasi</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M3 21h18M5 21V7l8-4v18m6 0V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endif

            <div
                class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-medium text-stone-500">Total Catatan Absensi</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-stone-800">
                            {{ number_format($attendanceTotal) }}</p>
                        <p class="mt-1 text-xs text-stone-500">{{ $periodLabel }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="m5 12 4 4L19 6" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-medium text-stone-500">
                            {{ $isEmployee ? 'Cuti Menunggu' : 'Pengajuan Cuti Menunggu' }}
                        </p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-stone-800">
                            {{ number_format($leaveStats['pending']) }}</p>
                        <p class="mt-1 text-xs text-stone-500">Belum diproses</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        {{-- Main analytics --}}
        <section class="grid grid-cols-1 gap-4 xl:grid-cols-12">

            {{-- Attendance trend --}}
            <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm sm:p-5 xl:col-span-7">
                <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold text-stone-800">Tren Kehadiran</h2>
                        <p class="mt-1 text-xs text-stone-500">Perbandingan kehadiran enam bulan terakhir</p>
                    </div>
                    <span class="rounded-lg bg-[#F7E9E2] px-2.5 py-1.5 text-xs font-semibold text-[#9F4B2C]">
                        6 Bulan
                    </span>
                </div>

                <div class="relative h-64 w-full">
                    <canvas id="attendanceTrendChart"></canvas>
                </div>

                <div class="mt-4 flex flex-wrap gap-x-4 gap-y-2 border-t border-stone-100 pt-3 text-xs text-stone-500">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-[#B85C38]"></span> Hadir
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-[#D4A373]"></span> Terlambat
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-[#9CA3AF]"></span> Tidak Hadir
                    </span>
                </div>
            </div>

            {{-- Distribution / leave status --}}
            @if ($canViewReports)
                <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm sm:p-5 xl:col-span-5">
                    <div class="mb-4">
                        <h2 class="text-sm font-bold text-stone-800">Komposisi Karyawan</h2>
                        <p class="mt-1 text-xs text-stone-500">Jumlah karyawan aktif per departemen</p>
                    </div>

                    @if ($departments->sum('employees_count') > 0)
                        <div class="relative mx-auto h-56 max-w-xs">
                            <canvas id="departmentChart"></canvas>
                        </div>
                        <div class="mt-4 space-y-2">
                            @foreach ($departments->sortByDesc('employees_count')->take(4) as $index => $department)
                                <div class="flex items-center justify-between gap-3 text-xs">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <span class="h-2.5 w-2.5 shrink-0 rounded-sm"
                                            style="background-color: {{ $departmentColors[$index % count($departmentColors)] }}"></span>
                                        <span class="truncate text-stone-600">{{ $department->name }}</span>
                                    </div>
                                    <span
                                        class="shrink-0 font-semibold text-stone-800">{{ $department->employees_count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex h-64 flex-col items-center justify-center text-center">
                            <div
                                class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-stone-100 text-stone-400">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7">
                                    <path d="M3 21h18M5 21V7l8-4v18m6 0V11l-6-4" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-stone-700">Belum ada data karyawan</p>
                            <p class="mt-1 text-xs text-stone-500">Data akan ditampilkan setelah tersedia.</p>
                        </div>
                    @endif

                    <div class="mt-4 border-t border-stone-100 pt-3">
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-xs font-bold text-stone-700">Ringkasan Pengajuan Cuti</h3>
                            <a href="{{ route('leave-approvals.index') }}"
                                class="text-xs font-semibold text-[#B85C38] hover:text-[#9F4B2C]">
                                Lihat detail →
                            </a>
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <div class="rounded-lg bg-amber-50 p-2.5">
                                <p class="text-[11px] text-amber-700">Menunggu</p>
                                <p class="mt-1 text-lg font-bold text-amber-800">{{ $leaveStats['pending'] }}</p>
                            </div>
                            <div class="rounded-lg bg-emerald-50 p-2.5">
                                <p class="text-[11px] text-emerald-700">Disetujui</p>
                                <p class="mt-1 text-lg font-bold text-emerald-800">{{ $leaveStats['approved'] }}</p>
                            </div>
                            <div class="rounded-lg bg-rose-50 p-2.5">
                                <p class="text-[11px] text-rose-700">Ditolak</p>
                                <p class="mt-1 text-lg font-bold text-rose-800">{{ $leaveStats['rejected'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm sm:p-5 xl:col-span-5">
                    <div class="mb-4">
                        <h2 class="text-sm font-bold text-stone-800">Ringkasan Cuti Saya</h2>
                        <p class="mt-1 text-xs text-stone-500">Status pengajuan cuti Anda</p>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div class="rounded-xl border border-amber-100 bg-amber-50 p-3">
                            <div
                                class="mb-2 flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                            </div>
                            <p class="text-xs text-amber-700">Menunggu</p>
                            <p class="mt-1 text-2xl font-bold text-amber-800">{{ $leaveStats['pending'] }}</p>
                        </div>

                        <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-3">
                            <div
                                class="mb-2 flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="m5 12 4 4L19 6" />
                                </svg>
                            </div>
                            <p class="text-xs text-emerald-700">Disetujui</p>
                            <p class="mt-1 text-2xl font-bold text-emerald-800">{{ $leaveStats['approved'] }}</p>
                        </div>

                        <div class="rounded-xl border border-rose-100 bg-rose-50 p-3">
                            <div
                                class="mb-2 flex h-8 w-8 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="m6 6 12 12M18 6 6 18" />
                                </svg>
                            </div>
                            <p class="text-xs text-rose-700">Ditolak</p>
                            <p class="mt-1 text-2xl font-bold text-rose-800">{{ $leaveStats['rejected'] }}</p>
                        </div>
                    </div>

                    <a href="{{ route('my.leave-requests.index') }}"
                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#B85C38] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#9F4B2C]">
                        Buka Pengajuan Cuti
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14m-6-6 6 6-6 6" />
                        </svg>
                    </a>

                    <div class="mt-4 rounded-lg bg-stone-50 p-3">
                        <p class="text-xs leading-relaxed text-stone-500">
                            Pastikan pengajuan cuti dilakukan sesuai prosedur dan saldo cuti yang tersedia.
                        </p>
                    </div>
                </div>
            @endif
        </section>

        {{-- Attendance status strip --}}
        <section class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-sm font-bold text-stone-800">Rincian Status Absensi</h2>
                    <p class="mt-1 text-xs text-stone-500">Rekap berdasarkan filter periode yang dipilih</p>
                </div>
                <a href="{{ $isEmployee ? route('my.attendances.index') : route('attendances.index') }}"
                    class="text-xs font-semibold text-[#B85C38] hover:text-[#9F4B2C]">
                    Lihat absensi →
                </a>
            </div>

            <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($attendanceCards as $item)
                    <div class="flex items-center justify-between gap-2 rounded-lg {{ $item['bg'] }} px-3 py-3">
                        <div class="flex min-w-0 items-center gap-2">
                            <span class="h-2 w-2 shrink-0 rounded-full {{ $item['dot'] }}"></span>
                            <span class="truncate text-xs font-medium {{ $item['color'] }}">{{ $item['label'] }}</span>
                        </div>
                        <span class="text-base font-bold {{ $item['color'] }}">{{ number_format($item['value']) }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Bottom section --}}
        <section class="grid grid-cols-1 gap-4 xl:grid-cols-12">

            @if ($canViewReports)
                {{-- Department table --}}
                <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm xl:col-span-7">
                    <div class="flex items-center justify-between gap-3 border-b border-stone-100 px-5 py-4">
                        <div>
                            <h2 class="text-sm font-bold text-stone-800">Karyawan per Departemen</h2>
                            <p class="mt-1 text-xs text-stone-500">Distribusi karyawan aktif pada setiap unit</p>
                        </div>
                        <a href="{{ route('departments.index') }}"
                            class="shrink-0 text-xs font-semibold text-[#B85C38] hover:text-[#9F4B2C]">
                            Kelola →
                        </a>
                    </div>

                    @if ($departments->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-stone-50 text-[11px] uppercase tracking-wider text-stone-500">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold">Departemen</th>
                                        <th class="px-5 py-3 text-right font-semibold">Karyawan Aktif</th>
                                        <th class="px-5 py-3 font-semibold">Proporsi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @foreach ($departments->sortByDesc('employees_count')->take(6) as $department)
                                        @php
                                            $percentage =
                                                $activeEmployees > 0
                                                    ? round(($department->employees_count / $activeEmployees) * 100)
                                                    : 0;
                                        @endphp
                                        <tr class="transition hover:bg-stone-50/80">
                                            <td class="px-5 py-3">
                                                <div class="flex items-center gap-2.5">
                                                    <span
                                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F7E9E2] text-xs font-bold text-[#9F4B2C]">
                                                        {{ strtoupper(substr($department->name, 0, 1)) }}
                                                    </span>
                                                    <span
                                                        class="font-medium text-stone-700">{{ $department->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-right font-semibold text-stone-800">
                                                {{ number_format($department->employees_count) }}
                                            </td>
                                            <td class="min-w-28 px-5 py-3">
                                                <div class="flex items-center gap-2">
                                                    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-stone-100">
                                                        <div class="h-full rounded-full bg-[#B85C38]"
                                                            style="width: {{ min($percentage, 100) }}%"></div>
                                                    </div>
                                                    <span
                                                        class="w-8 text-right text-xs text-stone-500">{{ $percentage }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-5 py-10 text-center">
                            <p class="text-sm font-semibold text-stone-700">Belum ada departemen</p>
                            <p class="mt-1 text-xs text-stone-500">Tambahkan departemen untuk melihat distribusi karyawan.
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Quick access --}}
            <div
                class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm sm:p-5 {{ $canViewReports ? 'xl:col-span-5' : 'xl:col-span-12' }}">
                <div class="mb-4">
                    <h2 class="text-sm font-bold text-stone-800">Akses Cepat</h2>
                    <p class="mt-1 text-xs text-stone-500">Menu yang sering digunakan</p>
                </div>

                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 {{ $canViewReports ? '' : 'lg:grid-cols-3' }}">
                    @foreach ($quickLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="group flex items-center gap-3 rounded-xl border border-stone-100 p-3 transition hover:border-[#D9A38B] hover:bg-[#FCF7F4]">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-600 transition group-hover:bg-[#F7E9E2] group-hover:text-[#9F4B2C]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                                </svg>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span
                                    class="block truncate text-xs font-semibold text-stone-800">{{ $link['title'] }}</span>
                                <span
                                    class="mt-1 block text-[11px] leading-relaxed text-stone-500">{{ $link['description'] }}</span>
                            </span>
                            <svg class="h-4 w-4 shrink-0 text-stone-300 transition group-hover:translate-x-0.5 group-hover:text-[#B85C38]"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M5 12h14m-6-6 6 6-6 6" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <footer
            class="flex flex-col justify-between gap-1 border-t border-stone-200 px-1 pt-3 text-xs text-stone-400 sm:flex-row">
            <span>PeopleCore · Human Resource Information System</span>
            <span>Ringkasan diperbarui {{ now()->translatedFormat('d F Y, H:i') }}</span>
        </footer>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const graphite = '#292724';
            const terracotta = '#B85C38';
            const sand = '#D4A373';
            const muted = '#9CA3AF';

            const chartText = '#78716C';
            const chartGrid = '#F0EEEB';

            Chart.defaults.font.family = 'Inter, ui-sans-serif, system-ui, sans-serif';
            Chart.defaults.font.size = 11;
            Chart.defaults.color = chartText;

            const trendCanvas = document.getElementById('attendanceTrendChart');

            if (trendCanvas) {
                new Chart(trendCanvas, {
                    type: 'line',
                    data: {
                        labels: @json($trendLabels),
                        datasets: [{
                                label: 'Hadir',
                                data: @json($trendPresent),
                                borderColor: terracotta,
                                backgroundColor: 'rgba(184, 92, 56, 0.10)',
                                borderWidth: 2.5,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                pointBackgroundColor: terracotta,
                                fill: true,
                                tension: 0.35
                            },
                            {
                                label: 'Terlambat',
                                data: @json($trendLate),
                                borderColor: sand,
                                backgroundColor: 'rgba(212, 163, 115, 0.06)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                pointBackgroundColor: sand,
                                fill: false,
                                tension: 0.35
                            },
                            {
                                label: 'Tidak Hadir',
                                data: @json($trendAbsent),
                                borderColor: muted,
                                backgroundColor: 'rgba(156, 163, 175, 0.06)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                pointBackgroundColor: muted,
                                fill: false,
                                tension: 0.35
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: graphite,
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: true
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: chartGrid
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            const departmentCanvas = document.getElementById('departmentChart');

            if (departmentCanvas) {
                const departmentLabels = @json($departments->sortByDesc('employees_count')->pluck('name')->values());

                const departmentValues = @json($departments->sortByDesc('employees_count')->pluck('employees_count')->values());

                const departmentColors = @json($departmentColors);

                new Chart(departmentCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: departmentLabels,
                        datasets: [{
                            data: departmentValues,
                            backgroundColor: departmentLabels.map(
                                (_, index) => departmentColors[index % departmentColors.length]
                            ),
                            borderColor: '#FFFFFF',
                            borderWidth: 3,
                            hoverOffset: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: graphite,
                                padding: 10,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
