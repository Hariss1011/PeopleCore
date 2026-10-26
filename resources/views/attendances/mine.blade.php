@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya')

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
    @endphp

    <div class="space-y-6">
        {{-- Header halaman --}}
        <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="h-1.5 w-7 rounded-full bg-[#C96F4A]"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                        Area Karyawan / Kehadiran
                    </p>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                    Riwayat Absensi Saya
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                    Tinjau catatan kehadiran pribadi, jam masuk, jam pulang, dan status absensi berdasarkan periode.
                </p>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-[#E7D5CB] bg-[#F8F0EB] px-4 py-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-stone-500">Total catatan</p>
                    <p class="mt-0.5 text-lg font-bold text-[#292724]">
                        {{ number_format($attendances->total()) }}
                        <span class="text-xs font-medium text-stone-500">data</span>
                    </p>
                </div>
            </div>
        </section>

        {{-- Filter periode --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-200 bg-[#FCFAF8] px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F3E5DC] text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Filter Periode</h2>
                        <p class="mt-1 text-xs text-stone-500">
                            Pilih rentang tanggal untuk melihat catatan absensi.
                        </p>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('my.attendances.index') }}" class="p-5 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
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

                        <a href="{{ route('my.attendances.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-600 transition hover:border-stone-400 hover:bg-stone-50">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </section>

        {{-- Tabel riwayat --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-2 border-b border-stone-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="font-bold text-[#292724]">Catatan Kehadiran</h2>
                    <p class="mt-1 text-xs text-stone-500">
                        Menampilkan {{ $attendances->firstItem() ?? 0 }}–{{ $attendances->lastItem() ?? 0 }}
                        dari {{ number_format($attendances->total()) }} data
                    </p>
                </div>

                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full border border-stone-200 bg-[#FCFAF8] px-3 py-1.5 text-xs font-medium text-stone-600">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Riwayat pribadi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-175 text-left text-sm">
                    <thead class="bg-[#292724] text-xs uppercase tracking-wider text-stone-200">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Tanggal</th>
                            <th class="px-5 py-4 font-semibold">Jam masuk</th>
                            <th class="px-5 py-4 font-semibold">Jam pulang</th>
                            <th class="px-5 py-4 font-semibold">Status</th>
                            <th class="px-5 py-4 font-semibold">Catatan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($attendances as $attendance)
                            <tr class="transition-colors odd:bg-white even:bg-[#FCFAF8] hover:bg-[#F9EEE8]">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3E5DC] text-[#A85435]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="4" width="18" height="17" rx="2" />
                                                <path d="M16 2v4M8 2v4M3 10h18" />
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-[#292724]">
                                            {{ $attendance->attendance_date->format('d M Y') }}
                                        </span>
                                    </div>
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

                                <td class="max-w-sm px-5 py-4 text-stone-600">
                                    @if ($attendance->notes)
                                        <p class="line-clamp-2 leading-5" title="{{ $attendance->notes }}">
                                            {{ $attendance->notes }}
                                        </p>
                                    @else
                                        <span class="text-stone-400">Tidak ada catatan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.7"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="17" rx="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 font-bold text-[#292724]">
                                        Belum ada catatan absensi
                                    </h3>
                                    <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-stone-500">
                                        Belum ditemukan catatan kehadiran pada periode yang dipilih.
                                        Coba ubah rentang tanggal atau reset filter.
                                    </p>
                                    <a href="{{ route('my.attendances.index') }}"
                                        class="mt-4 inline-flex items-center justify-center rounded-lg border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                                        Reset periode
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
