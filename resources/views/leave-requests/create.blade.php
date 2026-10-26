@extends('layouts.app')

@section('title', 'Ajukan Cuti')
@section('heading', 'Ajukan Cuti')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div>
            <a href="{{ route('my.leave-requests.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-stone-500 transition hover:text-[#A85435]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
                </svg>
                Kembali ke pengajuan saya
            </a>

            <div class="mt-5 flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v4m-2-2h4" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#A85435]">
                        Layanan Kepegawaian
                    </p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                        Ajukan Cuti
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                        Isi detail permohonan cuti dengan benar. Pengajuan akan diteruskan untuk ditinjau oleh pihak yang
                        berwenang.
                    </p>
                </div>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div role="alert" class="flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-red-800">Pengajuan belum dapat dikirim</p>
                    <p class="mt-1 text-sm text-red-700">Periksa kembali informasi berikut:</p>
                    <ul class="mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2 text-sm text-red-700">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"></span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('my.leave-requests.store') }}" method="POST"
            class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            @csrf

            <div class="border-b border-stone-100 px-5 py-5 sm:px-7">
                <h2 class="text-base font-bold text-[#292724]">Informasi Pengajuan</h2>
                <p class="mt-1 text-sm text-stone-500">
                    Lengkapi jenis cuti, periode, dan alasan pengajuan.
                </p>
            </div>

            <div class="space-y-6 p-5 sm:p-7">
                {{-- Leave Type --}}
                <div>
                    <label for="leave_type_id" class="mb-2 block text-sm font-semibold text-stone-700">
                        Jenis Cuti <span class="text-red-500">*</span>
                    </label>
                    <select id="leave_type_id" name="leave_type_id" required
                        class="w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        <option value="">Pilih jenis cuti</option>
                        @foreach ($leaveTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('leave_type_id') == $type->id)>
                                {{ $type->name }} ({{ $type->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('leave_type_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs leading-5 text-stone-400">
                        Pilih kategori cuti yang sesuai dengan kebutuhan Anda.
                    </p>
                </div>

                {{-- Date Range --}}
                <div>
                    <div class="mb-3">
                        <h3 class="text-sm font-semibold text-stone-700">Periode Cuti</h3>
                        <p class="mt-1 text-xs text-stone-400">
                            Tentukan tanggal mulai dan tanggal berakhirnya cuti.
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="start_date" class="mb-2 block text-sm font-semibold text-stone-700">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="start_date" name="start_date" min="{{ now()->toDateString() }}"
                                value="{{ old('start_date') }}" required
                                class="w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="mb-2 block text-sm font-semibold text-stone-700">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="end_date" name="end_date"
                                min="{{ old('start_date', now()->toDateString()) }}" value="{{ old('end_date') }}"
                                required
                                class="w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Reason --}}
                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="reason" class="block text-sm font-semibold text-stone-700">
                            Alasan Cuti <span class="text-red-500">*</span>
                        </label>
                        <span class="text-xs text-stone-400">10–2.000 karakter</span>
                    </div>
                    <textarea id="reason" name="reason" rows="5" required minlength="10" maxlength="2000"
                        placeholder="Jelaskan alasan pengajuan cuti secara jelas..."
                        class="w-full resize-y rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm leading-6 text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs leading-5 text-stone-400">
                        Sertakan informasi yang membantu peninjau memahami kebutuhan cuti Anda.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-stone-100 bg-stone-50/70 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <p class="text-xs leading-5 text-stone-500">
                    Kolom bertanda <span class="font-semibold text-red-500">*</span> wajib diisi.
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a href="{{ route('my.leave-requests.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-600 transition hover:bg-stone-100">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85E3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
