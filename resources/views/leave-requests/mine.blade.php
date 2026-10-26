@extends('layouts.app')

@section('title', 'Pengajuan Cuti Saya')
@section('heading', 'Pengajuan Cuti Saya')

@section('content')
    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
                'dot' => 'bg-amber-500',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
                'dot' => 'bg-emerald-500',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-rose-50 text-rose-700 ring-rose-600/15',
                'dot' => 'bg-rose-500',
            ],
        ];
    @endphp

    <div class="space-y-6">

        {{-- Header --}}
        <section class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="absolute inset-y-0 left-0 w-1.5 bg-[#C96F4A]"></div>

            <div class="flex flex-col gap-5 p-5 pl-7 sm:flex-row sm:items-center sm:justify-between sm:p-7 sm:pl-9">
                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2-2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold uppercase tracking-[0.16em] text-stone-500">
                            Layanan Kepegawaian
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                        Pengajuan Cuti Saya
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                        Pantau status permohonan, tinjau riwayat pengajuan, dan buka detail setiap permohonan cuti Anda.
                    </p>
                </div>

                <a href="{{ route('my.leave-requests.create') }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85E3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                    </svg>
                    Ajukan Cuti
                </a>
            </div>
        </section>

        {{-- Success Message --}}
        @if (session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <div class="pt-0.5">
                    <p class="text-sm font-bold text-emerald-800">Berhasil</p>
                    <p class="mt-1 text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Filter --}}
        <section class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-4 flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-sm font-bold text-[#292724]">Filter Pengajuan</h2>
                    <p class="mt-1 text-xs text-stone-500">Pilih status untuk menyaring daftar pengajuan.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('my.leave-requests.index') }}"
                class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="status" class="mb-2 block text-sm font-semibold text-stone-700">
                        Status Pengajuan
                    </label>
                    <select name="status" id="status"
                        class="w-full rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        <option value="">Semua status</option>
                        <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                        <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                        <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                    </select>
                </div>

                <div class="flex flex-col-reverse gap-2 sm:flex-row">
                    <a href="{{ route('my.leave-requests.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                        Reset
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#403B36]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4" />
                        </svg>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </section>

        {{-- Request List --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div
                class="flex flex-col gap-2 border-b border-stone-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-base font-bold text-[#292724]">Riwayat Pengajuan</h2>
                    <p class="mt-1 text-sm text-stone-500">
                        Daftar permohonan cuti yang pernah Anda ajukan.
                    </p>
                </div>
                <span
                    class="inline-flex w-fit items-center rounded-lg bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-600">
                    {{ number_format($leaveRequests->total()) }} pengajuan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50/80">
                        <tr>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Jenis Cuti
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Periode
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Durasi
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Status
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-stone-500">
                                Tanggal Pengajuan
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-stone-500">
                                Detail
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-100">
                        @forelse ($leaveRequests as $item)
                            @php
                                $status = $statusStyles[$item->status] ?? $statusStyles['pending'];
                            @endphp

                            <tr class="transition-colors hover:bg-[#FCFAF8]">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="font-semibold text-[#292724]">
                                                {{ $item->leaveType->name }}
                                            </p>
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $item->leaveType->code }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="font-medium text-stone-700">
                                        {{ $item->start_date->format('d M Y') }}
                                    </p>
                                    <p class="mt-1 text-xs text-stone-400">
                                        sampai {{ $item->end_date->format('d M Y') }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="font-semibold text-stone-700">
                                        {{ $item->start_date->diffInDays($item->end_date) + 1 }}
                                    </span>
                                    <span class="text-stone-500">hari</span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full px-2.5 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $status['class'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $status['label'] }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-stone-600">
                                    {{ $item->created_at->format('d M Y') }}
                                    <p class="mt-1 text-xs text-stone-400">
                                        {{ $item->created_at->format('H:i') }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('my.leave-requests.show', $item) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-bold text-[#A85435] transition hover:bg-[#F8F0EB]">
                                        Lihat detail
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2-2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 text-sm font-bold text-stone-700">
                                        Belum ada pengajuan cuti
                                    </h3>
                                    <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-stone-500">
                                        Pengajuan yang Anda buat akan muncul di sini. Mulai ajukan cuti untuk melihat
                                        riwayatnya.
                                    </p>
                                    <a href="{{ route('my.leave-requests.create') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#C96F4A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#B85E3B]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                        </svg>
                                        Ajukan Cuti
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($leaveRequests->hasPages())
                <div class="border-t border-stone-100 px-5 py-4 sm:px-6">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
