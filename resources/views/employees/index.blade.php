@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
    @php
        $statusLabels = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'resigned' => 'Mengundurkan Diri',
            'terminated' => 'Hubungan Kerja Berakhir',
        ];

        $statusClasses = [
            'active' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
            'inactive' => 'border-stone-200 bg-stone-100 text-stone-600',
            'resigned' => 'border-amber-200 bg-amber-50 text-amber-700',
            'terminated' => 'border-rose-200 bg-rose-50 text-rose-700',
        ];

        $hasFilters =
            request()->filled('search') ||
            request()->filled('department_id') ||
            request()->filled('position_id') ||
            request()->filled('employment_status') ||
            request()->filled('employment_type');
    @endphp

    <div class="mx-auto max-w-7xl space-y-5">

        {{-- Page heading --}}
        <section class="relative overflow-hidden rounded-2xl bg-[#292724] px-5 py-6 text-white shadow-sm sm:px-7">
            <div class="pointer-events-none absolute -right-8 -top-16 h-48 w-48 rounded-full border-26 border-[#B85C38]/20">
            </div>
            <div class="pointer-events-none absolute -bottom-20 right-40 h-40 w-40 rounded-full bg-[#B85C38]/10 blur-2xl">
            </div>

            <div class="relative flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div>
                    <div class="mb-2 flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-[#D49A78]"></span>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-300">
                            Human Resources / Master Data
                        </p>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">
                        Data Karyawan
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-stone-300">
                        Kelola profil, informasi pekerjaan, dan status kepegawaian dalam satu direktori.
                    </p>
                </div>

                <a href="{{ route('employees.create') }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#B85C38] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#9F4B2C] focus:outline-none focus:ring-2 focus:ring-[#D49A78] focus:ring-offset-2 focus:ring-offset-[#292724]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                    </svg>
                    Tambah Karyawan
                </a>
            </div>
        </section>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800"
                role="status">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                    <circle cx="12" cy="12" r="9" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-800"
                role="alert">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" d="M12 8v4m0 4h.01" />
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- Summary cards --}}
        <section class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Total Karyawan</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-800">
                            {{ number_format($totalEmployees) }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Seluruh profil terdaftar</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F7E9E2] text-[#B85C38]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m3-3h-6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1 overflow-hidden rounded-full bg-stone-100">
                    <div class="h-full w-full rounded-full bg-[#B85C38]"></div>
                </div>
            </div>

            <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Karyawan Aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-800">
                            {{ number_format($activeEmployees) }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Berstatus aktif bekerja</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1 overflow-hidden rounded-full bg-stone-100">
                    <div class="h-full rounded-full bg-emerald-500"
                        style="width: {{ $totalEmployees > 0 ? min(100, ($activeEmployees / $totalEmployees) * 100) : 0 }}%">
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-stone-500">Karyawan Kontrak Aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-stone-800">
                            {{ number_format($contractEmployees) }}
                        </p>
                        <p class="mt-1 text-xs text-stone-400">Karyawan kontrak yang aktif</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <rect x="3" y="7" width="18" height="14" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18m-11 0v2h4v-2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1 overflow-hidden rounded-full bg-stone-100">
                    <div class="h-full rounded-full bg-amber-500"
                        style="width: {{ $activeEmployees > 0 ? min(100, ($contractEmployees / $activeEmployees) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </section>

        {{-- Employee directory --}}
        <section class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">

            {{-- Directory heading --}}
            <div
                class="flex flex-col justify-between gap-3 border-b border-stone-100 px-4 py-4 sm:flex-row sm:items-center sm:px-5">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-sm font-bold text-stone-800">Direktori Karyawan</h2>
                            <p class="mt-0.5 text-xs text-stone-500">
                                Cari, filter, dan kelola informasi karyawan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-center">
                    <span class="rounded-lg bg-stone-100 px-3 py-2 text-xs font-medium text-stone-600">
                        {{ $employees->total() }} data ditemukan
                    </span>
                </div>
            </div>

            {{-- Search and filters --}}
            <div class="border-b border-stone-100 bg-stone-50/70 p-4 sm:p-5">
                <form action="{{ route('employees.index') }}" method="GET" class="space-y-3">

                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m16 16 4 4" />
                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, nomor karyawan, atau email..."
                            class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-10 pr-4 text-sm text-stone-700 placeholder:text-stone-400 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <div>
                            <label for="department_id" class="mb-1.5 block text-xs font-semibold text-stone-600">
                                Departemen
                            </label>
                            <select id="department_id" name="department_id"
                                class="w-full rounded-lg border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                                <option value="">Semua Departemen</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="position_id" class="mb-1.5 block text-xs font-semibold text-stone-600">
                                Jabatan
                            </label>
                            <select id="position_id" name="position_id"
                                class="w-full rounded-lg border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                                <option value="">Semua Jabatan</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" @selected(request('position_id') == $position->id)>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="employment_status" class="mb-1.5 block text-xs font-semibold text-stone-600">
                                Status Kepegawaian
                            </label>
                            <select id="employment_status" name="employment_status"
                                class="w-full rounded-lg border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                                <option value="">Semua Status</option>
                                <option value="active" @selected(request('employment_status') === 'active')>Aktif</option>
                                <option value="inactive" @selected(request('employment_status') === 'inactive')>Tidak Aktif</option>
                                <option value="resigned" @selected(request('employment_status') === 'resigned')>Mengundurkan Diri</option>
                                <option value="terminated" @selected(request('employment_status') === 'terminated')>Hubungan Kerja Berakhir</option>
                            </select>
                        </div>

                        <div>
                            <label for="employment_type" class="mb-1.5 block text-xs font-semibold text-stone-600">
                                Tipe Pekerjaan
                            </label>
                            <select id="employment_type" name="employment_type"
                                class="w-full rounded-lg border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                                <option value="">Semua Tipe</option>
                                <option value="permanent" @selected(request('employment_type') === 'permanent')>Permanen</option>
                                <option value="contract" @selected(request('employment_type') === 'contract')>Kontrak</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                        <p class="text-xs text-stone-500">
                            Gunakan filter untuk mempersempit hasil pencarian.
                        </p>

                        <div class="flex flex-wrap gap-2">
                            @if ($hasFilters)
                                <a href="{{ route('employees.index') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm font-medium text-stone-600 transition hover:bg-stone-100">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 12a9 9 0 1 0 3-6.7L3 8m0-5v5h5" />
                                    </svg>
                                    Reset
                                </a>
                            @endif

                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B85C38] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#9F4B2C] focus:outline-none focus:ring-2 focus:ring-[#B85C38]/30">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4" />
                                </svg>
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-sm">
                    <thead class="bg-stone-50">
                        <tr>
                            <th
                                class="whitespace-nowrap px-5 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-stone-500">
                                Karyawan
                            </th>
                            <th
                                class="whitespace-nowrap px-5 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-stone-500">
                                Departemen / Jabatan
                            </th>
                            <th
                                class="whitespace-nowrap px-5 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-stone-500">
                                Tipe Pekerjaan
                            </th>
                            <th
                                class="whitespace-nowrap px-5 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-stone-500">
                                Tanggal Masuk
                            </th>
                            <th
                                class="whitespace-nowrap px-5 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-stone-500">
                                Status
                            </th>
                            <th
                                class="whitespace-nowrap px-5 py-3.5 text-right text-[11px] font-bold uppercase tracking-wider text-stone-500">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($employees as $employee)
                            @php
                                $status = $employee->employment_status;
                                $employeeName = $employee->full_name ?: 'Tanpa Nama';
                                $initials = collect(explode(' ', trim($employeeName)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn($word) => mb_substr($word, 0, 1))
                                    ->implode('');
                            @endphp

                            <tr class="transition-colors hover:bg-[#FCF8F5]">
                                {{-- Employee identity --}}
                                <td class="min-w-62.5 px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F7E9E2] text-sm font-bold text-[#9F4B2C]">
                                            {{ mb_strtoupper($initials) }}
                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-semibold text-stone-800">
                                                {{ $employee->full_name }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-stone-500">
                                                {{ $employee->employee_number }}
                                            </p>
                                            <p class="mt-1 max-w-55 truncate text-xs text-stone-400"
                                                title="{{ $employee->email }}">
                                                {{ $employee->email ?: 'Email belum diisi' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Department and position --}}
                                <td class="min-w-47.5 px-5 py-4">
                                    <p class="font-medium text-stone-700">
                                        {{ $employee->department?->name ?? 'Belum ditentukan' }}
                                    </p>
                                    <p class="mt-1 text-xs text-stone-500">
                                        {{ $employee->position?->name ?? 'Belum ditentukan' }}
                                    </p>
                                </td>

                                {{-- Employment type --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($employee->employment_type === 'contract')
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-xs font-semibold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Kontrak
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 bg-stone-100 px-2.5 py-1.5 text-xs font-semibold text-stone-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                                            Permanen
                                        </span>
                                    @endif
                                </td>

                                {{-- Hire date --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="font-medium text-stone-700">
                                        {{ $employee->hire_date?->format('d M Y') ?? '—' }}
                                    </p>
                                </td>

                                {{-- Employment status --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span
                                        class="inline-flex max-w-47.5 items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$status] ?? 'border-stone-200 bg-stone-100 text-stone-600' }}">
                                        <span
                                            class="h-1.5 w-1.5 shrink-0 rounded-full
                                        {{ $status === 'active' ? 'bg-emerald-500' : '' }}
                                        {{ $status === 'inactive' ? 'bg-stone-400' : '' }}
                                        {{ $status === 'resigned' ? 'bg-amber-500' : '' }}
                                        {{ $status === 'terminated' ? 'bg-rose-500' : '' }}">
                                        </span>
                                        {{ $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status ?? 'unknown')) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('employees.show', $employee) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold text-[#9F4B2C] transition hover:bg-[#F7E9E2]"
                                            title="Lihat detail karyawan">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                            Detail
                                        </a>

                                        <a href="{{ route('employees.edit', $employee) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-2 text-xs font-semibold text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                                            title="Edit data karyawan">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m15 5 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
                                            </svg>
                                            Edit
                                        </a>

                                        @if (
                                            !$employee->user &&
                                                !$employee->attendances()->exists() &&
                                                !$employee->leaveRequests()->exists() &&
                                                !$employee->employmentHistories()->exists())
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-lg p-2 text-stone-400 transition hover:bg-rose-50 hover:text-rose-600"
                                                    title="Hapus karyawan" aria-label="Hapus karyawan">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.6">
                                            <circle cx="11" cy="11" r="7" />
                                            <path stroke-linecap="round" d="m16 16 4 4M8 11h6" />
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-stone-800">
                                        {{ $hasFilters ? 'Data karyawan tidak ditemukan' : 'Belum ada data karyawan' }}
                                    </h3>

                                    <p class="mx-auto mt-1 max-w-sm text-sm text-stone-500">
                                        {{ $hasFilters
                                            ? 'Coba ubah kata kunci atau kombinasi filter untuk menemukan data yang sesuai.'
                                            : 'Tambahkan data karyawan untuk mulai membangun direktori kepegawaian.' }}
                                    </p>

                                    @if ($hasFilters)
                                        <a href="{{ route('employees.index') }}"
                                            class="mt-4 inline-flex items-center gap-2 rounded-lg border border-stone-200 px-3.5 py-2 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                                            Reset Pencarian
                                        </a>
                                    @else
                                        <a href="{{ route('employees.create') }}"
                                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-[#B85C38] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#9F4B2C]">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                                            </svg>
                                            Tambah Karyawan
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($employees->hasPages() || $employees->total() > 0)
                <div
                    class="flex flex-col justify-between gap-3 border-t border-stone-100 bg-white px-4 py-4 sm:flex-row sm:items-center sm:px-5">
                    <p class="text-xs text-stone-500">
                        Menampilkan
                        <span class="font-semibold text-stone-700">{{ $employees->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-semibold text-stone-700">{{ $employees->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-semibold text-stone-700">{{ $employees->total() }}</span>
                        karyawan
                    </p>

                    <div class="peoplecore-pagination">
                        {{ $employees->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </section>

        <footer
            class="flex flex-col justify-between gap-1 border-t border-stone-200 px-1 pt-3 text-xs text-stone-400 sm:flex-row">
            <span>PeopleCore · Manajemen Data Karyawan</span>
            <span>Informasi kepegawaian perusahaan</span>
        </footer>
    </div>
@endsection
