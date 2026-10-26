@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        {{-- Header --}}
        <section>
            <a href="{{ route('attendances.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#A85435] transition hover:text-[#8E452C]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                    <path d="M20 12H9" />
                </svg>
                Kembali ke Manajemen Absensi
            </a>

            <div class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="h-1.5 w-7 rounded-full bg-[#C96F4A]"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                            Manajemen Kehadiran
                        </p>
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                        Tambah Absensi
                    </h1>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-stone-500">
                        Catat kehadiran karyawan dengan melengkapi informasi tanggal, status, dan waktu kehadiran.
                    </p>
                </div>

                <div class="flex items-center gap-3 rounded-xl border border-[#E7D5CB] bg-[#F8F0EB] px-4 py-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18M12 14v4m-2-2h4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-stone-500">Formulir</p>
                        <p class="mt-0.5 text-sm font-bold text-[#292724]">Absensi baru</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 9v4m0 4h.01" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-rose-800">Data belum dapat disimpan</p>
                        <p class="mt-1 text-sm text-rose-700">Periksa kembali bagian berikut:</p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('attendances.store') }}" method="POST"
            class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            @csrf

            {{-- Bagian 1: Informasi utama --}}
            <div class="border-b border-stone-200 bg-[#FCFAF8] px-5 py-5 sm:px-7">
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#292724] text-sm font-bold text-white">
                        01
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Informasi Kehadiran</h2>
                        <p class="mt-1 text-sm leading-5 text-stone-500">
                            Tentukan karyawan, tanggal, dan status kehadiran.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-7">
                <div>
                    <label for="employee_id" class="mb-2 block text-sm font-semibold text-stone-700">
                        Karyawan <span class="text-rose-600">*</span>
                    </label>
                    <select id="employee_id" name="employee_id" required
                        class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                        <option value="">Pilih karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected((string) old('employee_id') === (string) $employee->id)>
                                {{ $employee->employee_number }} — {{ $employee->full_name }}
                                ({{ $employee->department->name ?? 'Tanpa departemen' }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs leading-5 text-stone-500">
                        Pilih karyawan yang akan dicatat kehadirannya.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="attendance_date" class="mb-2 block text-sm font-semibold text-stone-700">
                            Tanggal absensi <span class="text-rose-600">*</span>
                        </label>
                        <input type="date" id="attendance_date" name="attendance_date" max="{{ now()->toDateString() }}"
                            value="{{ old('attendance_date', now()->toDateString()) }}" required
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-semibold text-stone-700">
                            Status kehadiran <span class="text-rose-600">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                            <option value="">Pilih status</option>
                            <option value="present" @selected(old('status') === 'present')>Hadir</option>
                            <option value="late" @selected(old('status') === 'late')>Terlambat</option>
                            <option value="permission" @selected(old('status') === 'permission')>Izin</option>
                            <option value="sick" @selected(old('status') === 'sick')>Sakit</option>
                            <option value="absent" @selected(old('status') === 'absent')>Alpha</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Bagian 2: Waktu --}}
            <div class="border-y border-stone-200 bg-[#FCFAF8] px-5 py-5 sm:px-7">
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#292724] text-sm font-bold text-white">
                        02
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Waktu Kehadiran</h2>
                        <p class="mt-1 text-sm leading-5 text-stone-500">
                            Masukkan jam masuk dan jam pulang jika tersedia.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-7">
                <div>
                    <label for="check_in" class="mb-2 block text-sm font-semibold text-stone-700">
                        Jam masuk
                    </label>
                    <div class="relative">
                        <input type="time" id="check_in" name="check_in" value="{{ old('check_in') }}"
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    </div>
                    <p class="mt-2 text-xs text-stone-500">Waktu karyawan mulai bekerja.</p>
                </div>

                <div>
                    <label for="check_out" class="mb-2 block text-sm font-semibold text-stone-700">
                        Jam pulang
                    </label>
                    <input type="time" id="check_out" name="check_out" value="{{ old('check_out') }}"
                        class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                    <p class="mt-2 text-xs text-stone-500">Waktu karyawan selesai bekerja.</p>
                </div>
            </div>

            {{-- Bagian 3: Catatan --}}
            <div class="border-y border-stone-200 bg-[#FCFAF8] px-5 py-5 sm:px-7">
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#292724] text-sm font-bold text-white">
                        03
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Catatan Tambahan</h2>
                        <p class="mt-1 text-sm leading-5 text-stone-500">
                            Tambahkan keterangan jika diperlukan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-5 sm:p-7">
                <label for="notes" class="mb-2 block text-sm font-semibold text-stone-700">
                    Catatan <span class="font-normal text-stone-400">(opsional)</span>
                </label>
                <textarea id="notes" name="notes" rows="4" maxlength="1000"
                    placeholder="Contoh: datang terlambat karena kendala transportasi"
                    class="w-full resize-y rounded-xl border border-stone-300 bg-white px-3.5 py-3 text-sm leading-6 text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">{{ old('notes') }}</textarea>
                <p class="mt-2 text-xs text-stone-500">Maksimal 1.000 karakter.</p>
            </div>

            {{-- Aksi formulir --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-stone-200 bg-[#FCFAF8] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <p class="text-xs leading-5 text-stone-500">
                    <span class="font-semibold text-rose-600">*</span>
                    Wajib diisi
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a href="{{ route('attendances.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-100">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-2.5 text-sm font-semibold text-white! shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-2 focus:ring-[#C96F4A] focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12.5 9.5 17 19 7" />
                        </svg>
                        <span class="text-white!">Simpan Absensi</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
