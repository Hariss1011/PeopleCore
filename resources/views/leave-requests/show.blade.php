@extends('layouts.app')

@section('title', 'Detail Pengajuan Cuti')
@section('heading', 'Detail Pengajuan Cuti')

@section('content')
    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Menunggu Persetujuan',
                'class' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
                'dot' => 'bg-amber-500',
                'description' => 'Pengajuan Anda sedang menunggu proses peninjauan.',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
                'dot' => 'bg-emerald-500',
                'description' => 'Pengajuan cuti ini telah disetujui.',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-rose-50 text-rose-700 ring-rose-600/15',
                'dot' => 'bg-rose-500',
                'description' => 'Pengajuan cuti ini tidak disetujui.',
            ],
        ];

        $status = $statusStyles[$leaveRequest->status] ?? $statusStyles['pending'];
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Navigation --}}
        <a href="{{ route('my.leave-requests.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-stone-500 transition hover:text-[#A85435]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
            </svg>
            Kembali ke pengajuan saya
        </a>

        {{-- Success Message --}}
        @if (session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <span
                    class="inline-flex w-fit shrink-0 items-center gap-3 rounded-full px-6 py-4 text-xl font-extrabold ring-1 ring-inset {{ $status['class'] }}">
                    <span class="h-3.5 w-3.5 rounded-full {{ $status['dot'] }}"></span>
                    {{ $status['label'] }}
                </span>
                <div class="pt-0.5">
                    <p class="text-sm font-bold text-emerald-800">Berhasil</p>
                    <p class="mt-1 text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Main Details --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-100 bg-linear-to-r from-[#FCFAF8] to-white p-5 sm:p-7">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2-2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#A85435]">
                                Detail Pengajuan
                            </p>
                            <h1 class="mt-1 text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                                {{ $leaveRequest->leaveType->name }}
                            </h1>
                            <p class="mt-2 text-sm text-stone-500">
                                Diajukan pada {{ $leaveRequest->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>


                    <span
                        class="inline-flex w-fit shrink-0 items-center gap-2.5 rounded-full px-5 py-3 text-base font-bold ring-1 ring-inset {{ $status['class'] }}">
                        <span class="h-2.5 w-2.5 rounded-full {{ $status['dot'] }}"></span>
                        {{ $status['label'] }}
                    </span>

                </div>

                <div class="mt-5 flex items-start gap-3 rounded-xl border border-stone-200/80 bg-white/80 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-stone-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 1.5" />
                    </svg>
                    <p class="text-sm leading-6 text-stone-600">{{ $status['description'] }}</p>
                </div>
            </div>

            <div class="p-5 sm:p-7">
                <div class="mb-5">
                    <h2 class="text-base font-bold text-[#292724]">Informasi Cuti</h2>
                    <p class="mt-1 text-sm text-stone-500">
                        Rincian periode dan informasi pemrosesan permohonan.
                    </p>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-stone-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A85435]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                            Tanggal Mulai
                        </dt>
                        <dd class="mt-3 text-lg font-bold text-[#292724]">
                            {{ $leaveRequest->start_date->format('d F Y') }}
                        </dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-stone-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#A85435]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2-2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                            Tanggal Selesai
                        </dt>
                        <dd class="mt-3 text-lg font-bold text-[#292724]">
                            {{ $leaveRequest->end_date->format('d F Y') }}
                        </dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-stone-500">
                            Durasi Cuti
                        </dt>
                        <dd class="mt-2 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-[#292724]">
                                {{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }}
                            </span>
                            <span class="text-sm text-stone-500">hari kalender</span>
                        </dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-stone-500">
                            Diproses Oleh
                        </dt>
                        <dd class="mt-2 font-semibold text-[#292724]">
                            {{ $leaveRequest->reviewer?->name ?? 'Belum diproses' }}
                        </dd>
                    </div>
                </dl>

                {{-- Reason --}}
                <div class="mt-6 rounded-xl border border-stone-200 p-5">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h8M8 14h5m-8 6l3-3h10a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 001 2z" />
                            </svg>
                        </span>
                        <h3 class="text-sm font-bold text-[#292724]">Alasan Pengajuan</h3>
                    </div>
                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-stone-600">{{ $leaveRequest->reason }}</p>
                </div>

                {{-- HR Review Note --}}
                @if ($leaveRequest->review_note)
                    <div class="mt-4 rounded-xl border border-[#EBD9CF] bg-[#FCFAF8] p-5">
                        <div class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F8F0EB] text-[#A85435]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 10h8M8 14h5m-8 6l3-3h10a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 001 2z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold text-[#292724]">Catatan HR</h3>
                        </div>
                        <p class="mt-3 whitespace-pre-line text-sm leading-7 text-stone-600">
                            {{ $leaveRequest->review_note }}
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Status History --}}
        <section class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm sm:p-7">
            <div class="flex items-start gap-3 border-b border-stone-100 pb-5">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-bold text-[#292724]">Riwayat Status</h2>
                    <p class="mt-1 text-sm text-stone-500">
                        Catatan perubahan status dan aktivitas pemrosesan pengajuan.
                    </p>
                </div>
            </div>

            <div class="pt-6">
                @forelse ($leaveRequest->histories->sortByDesc('changed_at') as $history)
                    @php
                        $historyStatus = $statusStyles[$history->new_status] ?? $statusStyles['pending'];
                    @endphp

                    <div class="relative flex gap-4 pb-7 last:pb-0">
                        @if (!$loop->last)
                            <div class="absolute bottom-0 left-4 top-9 w-px bg-stone-200"></div>
                        @endif

                        <span
                            class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full ring-4 ring-white {{ $historyStatus['class'] }}">
                            @if ($history->new_status === 'approved')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif ($history->new_status === 'rejected')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 1.5" />
                                </svg>
                            @endif
                        </span>

                        <div class="min-w-0 flex-1 rounded-xl border border-stone-100 bg-stone-50/60 p-4">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-sm font-bold text-[#292724]">
                                        @if ($history->new_status === 'pending')
                                            Pengajuan Dibuat
                                        @elseif ($history->new_status === 'approved')
                                            Pengajuan Disetujui
                                        @elseif ($history->new_status === 'rejected')
                                            Pengajuan Ditolak
                                        @else
                                            Status Diperbarui
                                        @endif
                                    </p>
                                    <p class="mt-1 text-xs text-stone-500">
                                        Oleh {{ $history->changedBy?->name ?? 'Pengguna' }}
                                    </p>
                                </div>

                                <span class="text-xs font-medium text-stone-400">
                                    {{ $history->changed_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            @if ($history->note)
                                <div class="mt-3 border-t border-stone-200 pt-3">
                                    <p class="whitespace-pre-line text-sm leading-6 text-stone-600">
                                        {{ $history->note }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <span
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-stone-100 text-stone-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 1.5" />
                            </svg>
                        </span>
                        <p class="mt-3 text-sm font-semibold text-stone-700">Belum ada riwayat status</p>
                        <p class="mt-1 text-sm text-stone-500">
                            Riwayat perubahan status akan ditampilkan di bagian ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
