@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
    @php
        $statusLabels = [
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'permission' => 'Izin',
            'sick' => 'Sakit',
            'absent' => 'Alpha',
        ];

        $statusStyles = [
            'present' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'late' => 'bg-amber-50 text-amber-800 ring-amber-600/20',
            'permission' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
            'sick' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
            'absent' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        ];

        $summaryCards = [
            [
                'label' => 'Hadir',
                'value' => $summary->present,
                'icon' => '✓',
                'accent' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
            ],
            [
                'label' => 'Terlambat',
                'value' => $summary->late,
                'icon' => '◷',
                'accent' => 'border-amber-200 bg-amber-50 text-amber-800',
            ],
            [
                'label' => 'Izin',
                'value' => $summary->permission,
                'icon' => '↗',
                'accent' => 'border-sky-200 bg-sky-50 text-sky-700',
            ],
            [
                'label' => 'Sakit',
                'value' => $summary->sick,
                'icon' => '+',
                'accent' => 'border-violet-200 bg-violet-50 text-violet-700',
            ],
            [
                'label' => 'Alpha',
                'value' => $summary->absent,
                'icon' => '!',
                'accent' => 'border-rose-200 bg-rose-50 text-rose-700',
            ],
            [
                'label' => 'Total Catatan',
                'value' => $summary->total,
                'icon' => '#',
                'accent' => 'border-[#E7D5CB] bg-[#F8F0EB] text-[#A85435]',
            ],
        ];
    @endphp

    <div class="space-y-6">
        {{-- Notifikasi --}}
        @if (session('success'))
            <div
                class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span
                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 font-bold">✓</span>
                <p class="pt-0.5 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Header halaman --}}
        <section class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="h-1.5 w-7 rounded-full bg-[#C96F4A]"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                        Human Resources / Kehadiran
                    </p>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                    Manajemen Absensi
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                    Pantau kehadiran karyawan, tinjau catatan absensi, dan kelola data berdasarkan periode.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-stone-200 bg-white px-4 py-3 shadow-sm">
                    <p class="text-xs font-medium text-stone-500">Data ditemukan</p>
                    <p class="mt-1 text-xl font-bold tabular-nums text-[#292724]">
                        {{ number_format($attendances->total()) }}
                        <span class="text-xs font-medium text-stone-500">catatan</span>
                    </p>
                </div>

                <a href="{{ route('attendances.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-4 py-3 text-sm font-semibold text-white! shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-2 focus:ring-[#C96F4A] focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="text-white!">Tambah Absensi</span>
                </a>
            </div>
        </section>

        {{-- Ringkasan statistik --}}
        <section>
            <div class="mb-3">
                <h2 class="text-sm font-bold text-[#292724]">Ringkasan Kehadiran</h2>
                <p class="mt-1 text-xs text-stone-500">Rekap data sesuai hasil ringkasan dari sistem.</p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-6">
                @foreach ($summaryCards as $item)
                    <div
                        class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs font-medium text-stone-500">{{ $item['label'] }}</p>
                            <span
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border text-sm font-bold {{ $item['accent'] }}">
                                {{ $item['icon'] }}
                            </span>
                        </div>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-[#292724]">
                            {{ number_format($item['value'] ?? 0) }}
                        </p>
                        <div class="mt-3 h-1 w-full overflow-hidden rounded-full bg-stone-100">
                            <div class="h-full w-1/3 rounded-full bg-[#C96F4A]"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Filter dan pencarian --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-200 bg-[#FCFAF8] px-5 py-4 sm:px-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F3E5DC] text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 5h16M7 12h10m-7 7h4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Filter Absensi</h2>
                        <p class="mt-1 text-xs leading-5 text-stone-500">
                            Gunakan kata kunci, departemen, status, atau rentang tanggal untuk menemukan data.
                        </p>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('attendances.index') }}" class="p-5 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <div>
                        <label for="search" class="mb-2 block text-sm font-semibold text-stone-700">
                            Cari karyawan
                        </label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Nama atau nomor karyawan"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    </div>

                    <div>
                        <label for="department_id" class="mb-2 block text-sm font-semibold text-stone-700">
                            Departemen
                        </label>
                        <select id="department_id" name="department_id"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                            <option value="">Semua departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-semibold text-stone-700">
                            Status kehadiran
                        </label>
                        <select id="status" name="status"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                            <option value="">Semua status</option>
                            <option value="present" @selected(request('status') === 'present')>Hadir</option>
                            <option value="late" @selected(request('status') === 'late')>Terlambat</option>
                            <option value="permission" @selected(request('status') === 'permission')>Izin</option>
                            <option value="sick" @selected(request('status') === 'sick')>Sakit</option>
                            <option value="absent" @selected(request('status') === 'absent')>Alpha</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="mb-2 block text-sm font-semibold text-stone-700">
                            Dari tanggal
                        </label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    </div>

                    <div>
                        <label for="date_to" class="mb-2 block text-sm font-semibold text-stone-700">
                            Sampai tanggal
                        </label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            min="{{ request('date_from') }}"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-4 py-2.5 text-sm font-semibold text-white! transition hover:bg-[#B85D3B] focus:outline-none focus:ring-2 focus:ring-[#C96F4A] focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 5h16M7 12h10m-7 7h4" />
                            </svg>
                            <span class="text-white!">Terapkan</span>
                        </button>

                        <a href="{{ route('attendances.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-600 transition hover:border-stone-400 hover:bg-stone-50">
                            Reset
                        </a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <p class="font-semibold">Periksa kembali filter yang dimasukkan.</p>
                        <ul class="mt-2 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </section>

        {{-- Tabel absensi --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-3 border-b border-stone-200 bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#292724] text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Catatan Kehadiran</h2>
                        <p class="mt-1 text-xs text-stone-500">
                            Menampilkan {{ $attendances->firstItem() ?? 0 }}–{{ $attendances->lastItem() ?? 0 }}
                            dari {{ number_format($attendances->total()) }} data
                        </p>
                    </div>
                </div>

                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full border border-stone-200 bg-[#FCFAF8] px-3 py-1.5 text-xs font-medium text-stone-600">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Data absensi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-262.5 text-left text-sm">
                    <thead class="bg-[#292724] text-xs uppercase tracking-wider text-stone-200">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Karyawan</th>
                            <th class="px-5 py-4 font-semibold">Departemen</th>
                            <th class="px-5 py-4 font-semibold">Tanggal</th>
                            <th class="px-5 py-4 font-semibold">Jam masuk</th>
                            <th class="px-5 py-4 font-semibold">Jam pulang</th>
                            <th class="px-5 py-4 font-semibold">Status</th>
                            <th class="px-5 py-4 font-semibold">Dicatat oleh</th>
                            <th class="px-5 py-4 font-semibold">Tindakan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($attendances as $attendance)
                            <tr class="transition-colors odd:bg-white even:bg-[#FCFAF8] hover:bg-[#F9EEE8]">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#F3E5DC] text-xs font-bold text-[#A85435]">
                                            {{ mb_strtoupper(mb_substr($attendance->employee->full_name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-[#292724]">
                                                {{ $attendance->employee->full_name ?? 'Karyawan tidak tersedia' }}
                                            </p>
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $attendance->employee->employee_number ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-stone-600">
                                    {{ $attendance->employee->department->name ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 font-medium text-stone-700">
                                    {{ $attendance->attendance_date->format('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="font-semibold text-stone-700">
                                        {{ $attendance->check_in ? substr($attendance->check_in, 0, 5) : '-' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="font-semibold text-stone-700">
                                        {{ $attendance->check_out ? substr($attendance->check_out, 0, 5) : '-' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $statusStyles[$attendance->status] ?? 'bg-stone-100 text-stone-600 ring-stone-500/20' }}">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        {{ $statusLabels[$attendance->status] ?? ucfirst($attendance->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-stone-600">
                                    {{ $attendance->recorder->name ?? '-' }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('attendances.edit', $attendance) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-[#E7D5CB] bg-white px-3 py-2 text-xs font-semibold text-[#A85435] transition hover:border-[#C96F4A] hover:bg-[#F8F0EB]">
                                            Edit
                                        </a>

                                        <form action="{{ route('attendances.destroy', $attendance) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus catatan absensi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg border border-rose-200 bg-white px-3 py-2 text-xs font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-50">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.7"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="17" rx="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 font-bold text-[#292724]">Data absensi tidak ditemukan</h3>
                                    <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-stone-500">
                                        Tidak ada catatan yang sesuai dengan pencarian atau filter saat ini.
                                        Coba ubah filter atau reset pencarian.
                                    </p>
                                    <a href="{{ route('attendances.index') }}"
                                        class="mt-4 inline-flex items-center justify-center rounded-lg border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                                        Reset filter
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($attendances->hasPages())
                <div
                    class="flex flex-col gap-3 border-t border-stone-200 bg-[#FCFAF8] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-stone-500">
                        Halaman {{ $attendances->currentPage() }} dari {{ $attendances->lastPage() }}
                    </p>
                    {{ $attendances->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
