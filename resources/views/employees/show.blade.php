@extends('layouts.app')

@section('title', 'Detail Karyawan')

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

        $status = $employee->employment_status;
        $employeeName = $employee->full_name ?: 'Tanpa Nama';

        $initials = collect(explode(' ', trim($employeeName)))
            ->filter()
            ->take(2)
            ->map(fn($word) => mb_substr($word, 0, 1))
            ->implode('');

        $tenureDays = $employee->hire_date ? max(0, (int) $employee->hire_date->diffInDays(now(), false)) : null;

        $tenureYears = $tenureDays !== null ? intdiv($tenureDays, 365) : 0;
        $tenureMonths = $tenureDays !== null ? intdiv($tenureDays % 365, 30) : 0;
    @endphp

    <div class="mx-auto max-w-6xl space-y-5">

        {{-- Breadcrumb --}}
        <a href="{{ route('employees.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-stone-500 transition hover:text-[#9F4B2C]">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                <path stroke-linecap="round" d="M9 12h12" />
            </svg>
            Data Karyawan
        </a>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800"
                role="status">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                    <circle cx="12" cy="12" r="9" />
                </svg>
                {{ session('success') }}
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
                {{ session('error') }}
            </div>
        @endif

        {{-- Profile header --}}
        <section class="relative overflow-hidden rounded-2xl bg-[#292724] text-white shadow-sm">
            <div
                class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-32 border-[#B85C38]/20">
            </div>
            <div class="pointer-events-none absolute bottom-0 right-48 h-32 w-32 rounded-full bg-[#B85C38]/10 blur-2xl">
            </div>

            <div class="relative p-5 sm:p-7">
                <div class="flex flex-col justify-between gap-6 xl:flex-row xl:items-start">
                    <div class="flex min-w-0 items-start gap-4 sm:gap-5">
                        <div
                            class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-[#B85C38] text-xl font-bold text-white shadow-lg sm:h-20 sm:w-20 sm:text-2xl">
                            {{ mb_strtoupper($initials ?: 'K') }}
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-300">
                                Profil Karyawan
                            </p>

                            <h1 class="mt-1.5 wrap-break-word text-2xl font-bold tracking-tight sm:text-3xl">
                                {{ $employee->full_name }}
                            </h1>

                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-stone-300">
                                <span>{{ $employee->employee_number }}</span>
                                <span class="hidden text-stone-500 sm:inline">•</span>
                                <span>{{ $employee->position?->name ?? 'Jabatan belum ditentukan' }}</span>
                            </div>

                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs font-semibold
                                {{ $statusClasses[$status] ?? 'border-white/20 bg-white/10 text-white' }}">
                                    <span
                                        class="h-1.5 w-1.5 rounded-full
                                    {{ $status === 'active' ? 'bg-emerald-500' : '' }}
                                    {{ $status === 'inactive' ? 'bg-stone-400' : '' }}
                                    {{ $status === 'resigned' ? 'bg-amber-500' : '' }}
                                    {{ $status === 'terminated' ? 'bg-rose-500' : '' }}">
                                    </span>
                                    {{ $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status ?? 'unknown')) }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/5 px-2.5 py-1 text-xs font-medium text-stone-200">
                                    {{ $employee->employment_type === 'contract' ? 'Karyawan Kontrak' : 'Karyawan Permanen' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row xl:justify-end">
                        <a href="{{ route('employees.employment-history.index', $employee) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/20 bg-white/5 px-3.5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12a9 9 0 1 0 3-6.7L3 8m0-5v5h5" />
                                <path stroke-linecap="round" d="M12 7v5l3 2" />
                            </svg>
                            Riwayat
                        </a>

                        <a href="{{ route('employees.edit', $employee) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#C96F4A] bg-[#C96F4A] px-4 py-2.5 text-sm font-semibold text-white! shadow-sm transition hover:border-[#B85D3B] hover:bg-[#B85D3B] hover:text-white!">
                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m15 5 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
                            </svg>
                            <span class="text-white!">Edit Profil</span>
                        </a>

                        <a href="{{ route('employees.employment-history.create', $employee) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B85C38] px-3.5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#9F4B2C]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                            </svg>
                            Ubah Status
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Key information --}}
        <section class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white p-4 shadow-sm">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F7E9E2] text-[#9F4B2C]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <rect x="3" y="7" width="18" height="14" rx="2" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-stone-500">Departemen</p>
                    <p class="mt-1 truncate text-sm font-bold text-stone-800">
                        {{ $employee->department?->name ?? 'Belum ditentukan' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white p-4 shadow-sm">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-stone-500">Mulai Bekerja</p>
                    <p class="mt-1 text-sm font-bold text-stone-800">
                        {{ $employee->hire_date?->format('d M Y') ?? 'Belum diisi' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white p-4 shadow-sm">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m3-3h-6" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-stone-500">Masa Kerja</p>
                    <p class="mt-1 text-sm font-bold text-stone-800">
                        @if ($tenureDays === null)
                            Belum diketahui
                        @elseif($tenureDays === 0)
                            Kurang dari 1 hari
                        @else
                            @if ($tenureYears > 0)
                                {{ $tenureYears }} thn
                            @endif
                            @if ($tenureMonths > 0)
                                {{ $tenureMonths }} bln
                            @endif
                            @if ($tenureYears === 0 && $tenureMonths === 0)
                                {{ $tenureDays }} hari
                            @endif
                        @endif
                    </p>
                </div>
            </div>
        </section>

        {{-- Details --}}
        <div class="grid grid-cols-1 items-start gap-5 xl:grid-cols-2">

            {{-- Personal details --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7">
                            <circle cx="12" cy="8" r="4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a8 8 0 0 1 16 0v2" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-stone-800">Informasi Pribadi</h2>
                        <p class="mt-0.5 text-xs text-stone-500">Identitas dan kontak karyawan.</p>
                    </div>
                </div>

                <dl class="divide-y divide-stone-100 px-5 sm:px-6">
                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Nama Lengkap</dt>
                        <dd class="wrap-break-word text-sm font-semibold text-stone-800">{{ $employee->full_name }}</dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Nomor Karyawan</dt>
                        <dd class="wrap-break-word text-sm font-semibold text-stone-800">{{ $employee->employee_number }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Email</dt>
                        <dd class="wrap-break-word text-sm font-medium text-stone-700">
                            {{ $employee->email ?: 'Belum diisi' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Nomor Telepon</dt>
                        <dd class="wrap-break-word text-sm font-medium text-stone-700">
                            {{ $employee->phone ?: 'Belum diisi' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Jenis Kelamin</dt>
                        <dd class="text-sm font-medium text-stone-700">
                            {{ match ($employee->gender) {
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                                default => 'Belum diisi',
                            } }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Alamat</dt>
                        <dd class="whitespace-pre-line wrap-break-word text-sm leading-relaxed text-stone-700">
                            {{ $employee->address ?: 'Belum diisi' }}</dd>
                    </div>
                </dl>
            </section>

            {{-- Employment details --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F7E9E2] text-[#9F4B2C]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7">
                            <rect x="3" y="7" width="18" height="14" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-stone-800">Informasi Kepegawaian</h2>
                        <p class="mt-0.5 text-xs text-stone-500">Penempatan, kontrak, dan akun sistem.</p>
                    </div>
                </div>

                <dl class="divide-y divide-stone-100 px-5 sm:px-6">
                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Departemen</dt>
                        <dd class="wrap-break-word text-sm font-semibold text-stone-800">
                            {{ $employee->department?->name ?? 'Belum ditentukan' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Jabatan</dt>
                        <dd class="wrap-break-word text-sm font-semibold text-stone-800">
                            {{ $employee->position?->name ?? 'Belum ditentukan' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Tipe Pekerjaan</dt>
                        <dd class="text-sm font-medium text-stone-700">
                            {{ $employee->employment_type === 'contract' ? 'Kontrak' : 'Permanen' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Tanggal Masuk</dt>
                        <dd class="text-sm font-medium text-stone-700">
                            {{ $employee->hire_date?->format('d F Y') ?? 'Belum diisi' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Akhir Kontrak</dt>
                        <dd class="text-sm font-medium text-stone-700">
                            {{ $employee->contract_end_date?->format('d F Y') ?? 'Tidak berlaku' }}
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Akun Pengguna</dt>
                        <dd class="min-w-0">
                            @if ($employee->user)
                                <p class="wrap-break-word text-sm font-medium text-stone-700">{{ $employee->user->email }}
                                </p>
                                <span
                                    class="mt-1 inline-flex rounded-md bg-stone-100 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-stone-600">
                                    {{ $employee->user->role }}
                                </span>
                            @else
                                <span class="text-sm text-stone-500">Belum memiliki akun</span>
                            @endif
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-[145px_minmax(0,1fr)] sm:gap-4">
                        <dt class="text-xs font-medium text-stone-500">Data Dibuat</dt>
                        <dd class="text-sm font-medium text-stone-700">
                            {{ $employee->created_at?->format('d F Y, H:i') ?? 'Tidak tersedia' }}
                        </dd>
                    </div>
                </dl>
            </section>
        </div>

        {{-- Data integrity notice --}}
        <section class="rounded-xl border border-amber-200 bg-amber-50/80 p-4 sm:p-5">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-amber-900">Catatan Pengelolaan Data</h2>
                    <p class="mt-1 text-sm leading-6 text-amber-800">
                        Jika status atau hubungan kerja karyawan berubah, gunakan menu
                        <strong>Ubah Status</strong> dan isi tanggal efektif serta alasan perubahan.
                        Riwayat disimpan agar perubahan administrasi dapat ditelusuri.
                        Data yang memiliki akun, transaksi absensi/cuti, atau riwayat kepegawaian
                        tidak dapat dihapus demi menjaga integritas data.
                    </p>
                </div>
            </div>
        </section>

        <div class="flex justify-start border-t border-stone-200 pt-4">
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-stone-200 bg-white px-4 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-100">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                    <path stroke-linecap="round" d="M9 12h12" />
                </svg>
                Kembali ke Direktori
            </a>
        </div>
    </div>
@endsection
