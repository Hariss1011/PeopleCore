@extends('layouts.app')

@section('title', 'Tinjau Pengajuan Cuti')
@section('heading', 'Tinjau Pengajuan Cuti')

@section('content')
    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Menunggu Persetujuan',
                'class' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                'dot' => 'bg-amber-500',
                'description' => 'Pengajuan ini menunggu keputusan dari HR.',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                'dot' => 'bg-emerald-500',
                'description' => 'Pengajuan cuti ini telah disetujui.',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                'dot' => 'bg-rose-500',
                'description' => 'Pengajuan cuti ini tidak disetujui.',
            ],
        ];

        $status = $statusStyles[$leaveRequest->status] ?? $statusStyles['pending'];
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Back Navigation --}}
        <a href="{{ route('leave-approvals.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-stone-500 transition hover:text-[#A85435]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
            </svg>
            Kembali ke persetujuan cuti
        </a>

        {{-- Success Message --}}
        @if (session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <div>
                    <p class="font-bold text-emerald-800">Keputusan berhasil disimpan</p>
                    <p class="mt-1 text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-5">
                <div class="flex items-start gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v4m0 4h.01M10.3 3.9L1.9 18a2 2 0 001.7 3h16.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-bold text-rose-800">Keputusan belum dapat disimpan</p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Employee & Request Header --}}
        <section class="overflow-hidden rounded-2xl border border-[#EBD9CF] bg-white shadow-sm">
            <div
                class="relative overflow-hidden border-b border-[#EBD9CF] bg-linear-to-br from-[#FCFAF8] via-white to-[#F8F0EB] p-6 sm:p-8">
                <div class="absolute -right-10 -top-16 h-48 w-48 rounded-full bg-[#C96F4A]/5"></div>

                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#292724] text-xl font-extrabold text-white shadow-sm">
                            {{ mb_strtoupper(mb_substr($leaveRequest->employee->full_name, 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#A85435]">Detail Permohonan</p>
                            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#292724] sm:text-3xl">
                                {{ $leaveRequest->employee->full_name }}
                            </h1>
                            <p class="mt-2 text-sm text-stone-600">
                                {{ $leaveRequest->employee->employee_number }}
                                <span class="mx-1 text-stone-300">•</span>
                                {{ $leaveRequest->employee->department->name ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="inline-flex w-fit shrink-0 items-center gap-3 rounded-full px-5 py-3 text-sm font-extrabold ring-1 ring-inset {{ $status['class'] }}">
                        <span class="h-2.5 w-2.5 rounded-full {{ $status['dot'] }}"></span>
                        {{ $status['label'] }}
                    </span>
                </div>

                <div class="relative mt-6 flex items-start gap-3 rounded-xl border border-white bg-white/80 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-[#A85435]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 1.5" />
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-[#292724]">Status pengajuan</p>
                        <p class="mt-1 text-sm leading-6 text-stone-600">{{ $status['description'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Leave Details --}}
            <div class="p-6 sm:p-8">
                <div class="mb-5">
                    <h2 class="text-lg font-extrabold text-[#292724]">Informasi Pengajuan</h2>
                    <p class="mt-1 text-sm text-stone-500">Rincian cuti dan informasi pemrosesan permohonan.</p>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-stone-200 bg-[#FCFAF8] p-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-stone-500">Jenis Cuti</dt>
                        <dd class="mt-2 text-base font-bold text-[#292724]">{{ $leaveRequest->leaveType->name }}</dd>
                        <dd class="mt-1 text-xs text-stone-500">Kode: {{ $leaveRequest->leaveType->code }}</dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-[#FCFAF8] p-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-stone-500">Tanggal Pengajuan</dt>
                        <dd class="mt-2 text-base font-bold text-[#292724]">
                            {{ $leaveRequest->created_at->format('d M Y') }}</dd>
                        <dd class="mt-1 text-xs text-stone-500">Pukul {{ $leaveRequest->created_at->format('H:i') }}</dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-stone-500">Tanggal Mulai</dt>
                        <dd class="mt-2 text-lg font-extrabold text-[#292724]">
                            {{ $leaveRequest->start_date->format('d F Y') }}</dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-stone-500">Tanggal Selesai</dt>
                        <dd class="mt-2 text-lg font-extrabold text-[#292724]">
                            {{ $leaveRequest->end_date->format('d F Y') }}</dd>
                    </div>

                    <div class="rounded-xl border border-[#EBD9CF] bg-[#FCFAF8] p-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-stone-500">Durasi Cuti</dt>
                        <dd class="mt-2 flex items-baseline gap-2">
                            <span class="text-3xl font-extrabold text-[#A85435]">
                                {{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }}
                            </span>
                            <span class="text-sm font-medium text-stone-500">hari kalender</span>
                        </dd>
                    </div>

                    <div class="rounded-xl border border-stone-200 bg-white p-4">
                        <dt class="text-xs font-bold uppercase tracking-wider text-stone-500">Diproses Oleh</dt>
                        <dd class="mt-2 text-base font-bold text-[#292724]">
                            {{ $leaveRequest->reviewer?->name ?? 'Belum diproses' }}
                        </dd>
                    </div>
                </dl>

                {{-- Employee Reason --}}
                <div class="mt-6 rounded-xl border border-stone-200 p-5 sm:p-6">
                    <div class="flex items-center gap-3">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h8M8 14h5m-8 6l3-3h10a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 001 2z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-bold text-[#292724]">Alasan Karyawan</h3>
                            <p class="mt-0.5 text-xs text-stone-500">Alasan yang disampaikan saat mengajukan cuti.</p>
                        </div>
                    </div>
                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-stone-700">{{ $leaveRequest->reason }}</p>
                </div>

                {{-- Existing Review Note --}}
                @if ($leaveRequest->review_note)
                    <div class="mt-4 rounded-xl border border-[#EBD9CF] bg-[#FCFAF8] p-5 sm:p-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 10h8M8 14h5m-8 6l3-3h10a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 001 2z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="font-bold text-[#292724]">Catatan HR</h3>
                                <p class="mt-0.5 text-xs text-stone-500">Catatan atas keputusan pengajuan ini.</p>
                            </div>
                        </div>
                        <p class="mt-4 whitespace-pre-line text-sm leading-7 text-stone-700">
                            {{ $leaveRequest->review_note }}</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- HR Decision Form --}}
        @if ($leaveRequest->status === 'pending')
            <section class="overflow-hidden rounded-2xl border border-[#EBD9CF] bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-[#EBD9CF] bg-[#FCFAF8] px-6 py-5 sm:px-8">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#292724] text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5-2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h8l6 6z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-[#292724]">Keputusan HR</h2>
                        <p class="mt-1 text-sm text-stone-500">Periksa informasi sebelum menetapkan keputusan akhir.</p>
                    </div>
                </div>

                <form action="{{ route('leave-approvals.review', $leaveRequest) }}" method="POST"
                    class="space-y-6 p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="mb-2 block text-sm font-bold text-stone-700">
                            Keputusan <span class="text-rose-600">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                            <option value="">Pilih keputusan</option>
                            <option value="approved" @selected(old('status') === 'approved')>Setujui pengajuan</option>
                            <option value="rejected" @selected(old('status') === 'rejected')>Tolak pengajuan</option>
                        </select>
                        <p class="mt-2 text-xs leading-5 text-stone-500">
                            Pilih persetujuan atau penolakan setelah memeriksa rincian pengajuan.
                        </p>
                        @error('status')
                            <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="review_note" class="mb-2 block text-sm font-bold text-stone-700">
                            Catatan HR <span class="font-medium text-stone-400">(wajib jika ditolak)</span>
                        </label>
                        <textarea name="review_note" id="review_note" rows="4" maxlength="1000"
                            placeholder="Tuliskan catatan atau alasan keputusan..."
                            class="w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm leading-6 text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">{{ old('review_note') }}</textarea>
                        <div class="mt-2 flex flex-col justify-between gap-1 sm:flex-row sm:items-center">
                            <p class="text-xs text-stone-500">Maksimal 1.000 karakter.</p>
                            @error('review_note')
                                <p class="text-sm font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-stone-100 pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('leave-approvals.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-bold text-stone-600 transition hover:bg-stone-50">
                            Kembali
                        </a>
                        <button type="submit" onclick="return confirm('Simpan keputusan untuk pengajuan ini?')"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#403B36] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Keputusan
                        </button>
                    </div>
                </form>
            </section>
        @else
            {{-- Processed Request --}}
            <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-7">
                <div class="flex items-start gap-3">
                    <span
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $leaveRequest->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                        @if ($leaveRequest->status === 'approved')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                    </span>
                    <div>
                        <h2 class="font-extrabold text-[#292724]">Pengajuan Sudah Diproses</h2>
                        <p class="mt-1 text-sm leading-6 text-stone-600">
                            Keputusan sudah tercatat dan tidak dapat diubah melalui halaman ini.
                        </p>
                        @if ($leaveRequest->review_note)
                            <div class="mt-4 rounded-xl border border-stone-200 bg-[#FCFAF8] p-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-stone-500">Catatan HR</p>
                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-stone-700">
                                    {{ $leaveRequest->review_note }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- Status History --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-stone-100 px-6 py-5 sm:px-8">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-lg font-extrabold text-[#292724]">Riwayat Status</h2>
                    <p class="mt-1 text-sm text-stone-500">Rekam jejak perubahan dan pemrosesan pengajuan.</p>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                @forelse ($leaveRequest->histories->sortByDesc('changed_at') as $history)
                    @php
                        $historyStatus = $statusStyles[$history->new_status] ?? $statusStyles['pending'];
                    @endphp

                    <div class="relative flex gap-4 pb-7 last:pb-0">
                        @if (!$loop->last)
                            <div class="absolute bottom-0 left-4 top-9 w-px bg-stone-200"></div>
                        @endif

                        <span
                            class="relative z-10 flex h-9 w-9 shrink-0 items-center justify-center rounded-full ring-4 ring-white {{ $historyStatus['class'] }}">
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

                        <div class="min-w-0 flex-1 rounded-xl border border-stone-200 bg-[#FCFAF8] p-4 sm:p-5">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="font-bold text-[#292724]">
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

                                <span class="whitespace-nowrap text-xs font-medium text-stone-400">
                                    {{ $history->changed_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            @if ($history->note)
                                <div class="mt-3 border-t border-stone-200 pt-3">
                                    <p class="whitespace-pre-line text-sm leading-6 text-stone-600">{{ $history->note }}
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
                        <p class="mt-3 text-sm font-bold text-stone-700">Belum ada riwayat status</p>
                        <p class="mt-1 text-sm text-stone-500">Riwayat pemrosesan akan muncul di bagian ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
