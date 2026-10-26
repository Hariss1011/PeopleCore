@extends('layouts.app')

@section('title', 'Saldo Cuti Saya')
@section('heading', 'Saldo Cuti Saya')

@section('content')
    <div class="mx-auto max-w-7xl space-y-7">

        {{-- Page Header --}}
        <section
            class="relative overflow-hidden rounded-2xl border border-[#EBD9CF] bg-linear-to-br from-[#FCFAF8] via-white to-[#F8F0EB] p-6 sm:p-8">
            <div class="absolute -right-12 -top-16 h-56 w-56 rounded-full bg-[#C96F4A]/5"></div>

            <div class="relative flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div>
                    <div
                        class="mb-3 inline-flex items-center gap-2 rounded-full border border-[#EBD9CF] bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-[#A85435]">
                        <span class="h-2 w-2 rounded-full bg-[#C96F4A]"></span>
                        Informasi Kepegawaian
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-[#292724] sm:text-3xl">
                        Saldo Cuti Saya
                    </h1>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-stone-600 sm:text-base">
                        Pantau kuota tahunan, pemakaian, dan sisa hak cuti yang tersedia untuk tahun {{ $year }}.
                    </p>
                </div>

                <a href="{{ route('my.leave-requests.index') }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5z" />
                    </svg>
                    Lihat Pengajuan Cuti
                </a>
            </div>
        </section>

        {{-- Flash Message --}}
        @include('partials.flash')

        {{-- Year Filter --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5z" />
                    </svg>
                </span>
                <div>
                    <h2 class="font-bold text-[#292724]">Periode Saldo Cuti</h2>
                    <p class="mt-0.5 text-xs text-stone-500">Pilih tahun untuk melihat kuota cuti yang tersedia.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('my.leave-balances.index') }}"
                class="flex flex-col gap-3 p-5 sm:flex-row sm:items-end sm:p-6">
                <div class="w-full sm:max-w-xs">
                    <label for="year" class="mb-2 block text-sm font-semibold text-stone-700">Tahun</label>
                    <input id="year" name="year" type="number" min="2000" max="2100"
                        value="{{ $year }}"
                        class="w-full rounded-xl border border-stone-300 px-3 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                </div>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#403B36] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                    </svg>
                    Tampilkan
                </button>
            </form>
        </section>

        {{-- Personal Balance Summary --}}
        @php
            $totalQuota = $balances->sum('quota_days');
            $totalUsed = $balances->sum('used_days');
            $totalRemaining = $balances->sum('remaining_days');
            $overallPercentage = $totalQuota > 0 ? min(100, ($totalUsed / $totalQuota) * 100) : 0;
        @endphp

        @if ($balances->isNotEmpty())
            <section class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-stone-500">Ringkasan Cuti Tahun {{ $year }}</p>
                        <h2 class="mt-1 text-xl font-extrabold text-[#292724]">Gambaran Saldo Cuti</h2>
                    </div>
                    <span
                        class="inline-flex w-fit items-center gap-2 rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-bold text-[#A85435]">
                        {{ $balances->count() }} jenis cuti
                    </span>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-stone-200 bg-[#FCFAF8] p-4">
                        <p class="text-sm font-semibold text-stone-500">Total Kuota</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#292724]">
                            {{ $totalQuota }}
                            <span class="text-sm font-semibold text-stone-500">hari</span>
                        </p>
                    </div>

                    <div class="rounded-xl border border-amber-200 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-500">Total Terpakai</p>
                        <p class="mt-2 text-3xl font-extrabold text-amber-700">
                            {{ $totalUsed }}
                            <span class="text-sm font-semibold text-stone-500">hari</span>
                        </p>
                    </div>

                    <div class="rounded-xl border border-emerald-200 bg-white p-4">
                        <p class="text-sm font-semibold text-stone-500">Total Sisa</p>
                        <p class="mt-2 text-3xl font-extrabold text-emerald-700">
                            {{ $totalRemaining }}
                            <span class="text-sm font-semibold text-stone-500">hari</span>
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <p class="text-sm font-semibold text-stone-700">Penggunaan seluruh kuota</p>
                        <p class="text-sm font-extrabold text-[#A85435]">{{ number_format($overallPercentage, 0) }}%</p>
                    </div>
                    <div class="h-2.5 overflow-hidden rounded-full bg-stone-100">
                        <div class="h-full rounded-full bg-[#C96F4A] transition-all"
                            style="width: {{ $overallPercentage }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-stone-500">
                        Persentase berdasarkan total kuota dari jenis cuti yang tersedia pada halaman ini.
                    </p>
                </div>
            </section>
        @endif

        {{-- Individual Leave Balances --}}
        <section>
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-lg font-extrabold text-[#292724]">Rincian Kuota Cuti</h2>
                    <p class="mt-1 text-sm text-stone-500">Lihat sisa dan penggunaan untuk setiap jenis cuti.</p>
                </div>
                <p class="text-xs font-medium text-stone-500">Periode {{ $year }}</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($balances as $balance)
                    @php
                        $quota = max(0, (int) $balance->quota_days);
                        $used = max(0, (int) $balance->used_days);
                        $remaining = max(0, (int) $balance->remaining_days);
                        $percentage = $quota > 0 ? min(100, ($used / $quota) * 100) : 0;
                    @endphp

                    <article
                        class="group overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-[#EBD9CF] hover:shadow-md">
                        <div class="h-1.5 bg-linear-to-r from-[#A85435] to-[#D99A7D]"></div>

                        <div class="p-5 sm:p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex min-w-0 items-start gap-3">
                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5z" />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold uppercase tracking-wider text-stone-400">Jenis Cuti</p>
                                        <h3 class="mt-1 wrap-break-word text-base font-extrabold text-[#292724]">
                                            {{ $balance->leaveType->name }}
                                        </h3>
                                    </div>
                                </div>

                                <span
                                    class="shrink-0 rounded-lg px-2.5 py-1 text-xs font-bold {{ $remaining > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                                    {{ $remaining > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>

                            <div class="mt-6 rounded-xl bg-[#FCFAF8] p-4">
                                <p class="text-xs font-semibold text-stone-500">Sisa kuota</p>
                                <div class="mt-1 flex items-baseline gap-2">
                                    <span
                                        class="text-4xl font-extrabold tracking-tight {{ $remaining > 0 ? 'text-[#A85435]' : 'text-stone-500' }}">
                                        {{ $balance->remaining_days }}
                                    </span>
                                    <span class="text-sm font-semibold text-stone-500">hari</span>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <div class="rounded-xl border border-stone-200 p-3">
                                    <p class="text-xs font-medium text-stone-500">Kuota Awal</p>
                                    <p class="mt-1.5 text-xl font-extrabold text-[#292724]">
                                        {{ $balance->quota_days }}
                                        <span class="text-xs font-semibold text-stone-400">hari</span>
                                    </p>
                                </div>

                                <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-3">
                                    <p class="text-xs font-medium text-stone-500">Terpakai</p>
                                    <p class="mt-1.5 text-xl font-extrabold text-amber-700">
                                        {{ $balance->used_days }}
                                        <span class="text-xs font-semibold text-stone-400">hari</span>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <span class="text-xs font-semibold text-stone-600">Pemakaian kuota</span>
                                    <span
                                        class="text-xs font-extrabold text-[#A85435]">{{ number_format($percentage, 0) }}%</span>
                                </div>

                                <div class="h-2 overflow-hidden rounded-full bg-stone-100">
                                    <div class="h-full rounded-full {{ $percentage >= 100 ? 'bg-rose-500' : 'bg-[#C96F4A]' }}"
                                        style="width: {{ $percentage }}%"></div>
                                </div>

                                <div class="mt-2 flex items-center justify-between text-xs text-stone-400">
                                    <span>0 hari</span>
                                    <span>{{ $balance->quota_days }} hari</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="rounded-2xl border border-dashed border-stone-300 bg-white p-8 sm:col-span-2 xl:col-span-3 sm:p-12">
                        <span
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5z" />
                            </svg>
                        </span>

                        <h3 class="mt-4 text-center font-extrabold text-[#292724]">
                            Belum Ada Kuota Cuti
                        </h3>
                        <p class="mx-auto mt-2 max-w-md text-center text-sm leading-6 text-stone-500">
                            Belum ada kuota cuti yang tercatat untuk tahun {{ $year }}. Hubungi HR jika kuota cuti
                            kamu belum diatur.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
