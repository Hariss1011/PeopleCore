```blade
@extends('layouts.app')

@section('title', 'Ubah Status Kepegawaian')

@section('content')
    @php
        $statusLabels = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'resigned' => 'Mengundurkan Diri',
            'terminated' => 'Hubungan Kerja Berakhir',
        ];

        $statusDescriptions = [
            'active' => 'Karyawan berstatus aktif dan masih bekerja.',
            'inactive' => 'Status karyawan menjadi tidak aktif.',
            'resigned' => 'Karyawan mengakhiri hubungan kerja atas pengunduran diri.',
            'terminated' => 'Hubungan kerja karyawan telah berakhir.',
        ];

        $statusClasses = [
            'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
            'inactive' => 'bg-stone-100 text-stone-600 ring-stone-500/15',
            'resigned' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
            'terminated' => 'bg-rose-50 text-rose-700 ring-rose-600/15',
        ];

        $currentStatus = $employee->employment_status;
    @endphp

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div>
            <div class="mb-2 flex flex-wrap items-center gap-2 text-sm text-stone-500">
                <a href="{{ route('employees.index') }}" class="transition hover:text-[#C96F4A]">
                    Manajemen Karyawan
                </a>

                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                </svg>

                <a href="{{ route('employees.show', $employee) }}" class="transition hover:text-[#C96F4A]">
                    Detail Karyawan
                </a>

                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                </svg>

                <span class="font-medium text-stone-700">Ubah Status</span>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#C96F4A]/10 text-[#B85D3B] ring-1 ring-[#C96F4A]/15">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l2.5 2.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-stone-900 sm:text-3xl">
                            Ubah Status Kepegawaian
                        </h1>
                    </div>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-stone-500">
                        Catat perubahan status karyawan dengan tanggal efektif dan alasan yang jelas.
                        Setiap perubahan akan disimpan sebagai bagian dari riwayat kepegawaian.
                    </p>
                </div>

                <a href="{{ route('employees.employment-history.index', $employee) }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 self-start rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-stone-700! shadow-sm transition hover:bg-stone-50">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h11" />
                    </svg>
                    Riwayat Kepegawaian
                </a>
            </div>
        </div>

        @include('partials.flash')

        {{-- Employee summary --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-100 px-5 py-4 sm:px-6">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-stone-400">
                    Karyawan yang Dipilih
                </p>
            </div>

            <div class="flex flex-col gap-4 bg-linear-to-r from-stone-50 to-white p-5 sm:flex-row sm:items-center sm:px-6">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#C96F4A]/10 text-xl font-bold text-[#B85D3B] ring-1 ring-[#C96F4A]/15">
                    {{ strtoupper(substr($employee->full_name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="text-lg font-bold text-stone-900">
                        {{ $employee->full_name }}
                    </h2>

                    <p class="mt-1 text-sm text-stone-500">
                        Nomor Karyawan:
                        <span class="font-semibold text-stone-700">{{ $employee->employee_number }}</span>
                    </p>

                    <p class="mt-1 text-sm text-stone-500">
                        {{ $employee->department?->name ?? 'Departemen belum ditentukan' }}
                        <span class="mx-1 text-stone-300">·</span>
                        {{ $employee->position?->name ?? 'Jabatan belum ditentukan' }}
                    </p>
                </div>

                <div class="sm:text-right">
                    <p class="mb-2 text-xs font-medium uppercase tracking-wider text-stone-400">
                        Status Saat Ini
                    </p>

                    <span
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 {{ $statusClasses[$currentStatus] ?? 'bg-stone-100 text-stone-600 ring-stone-500/15' }}">
                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                        {{ $statusLabels[$currentStatus] ?? ucfirst(str_replace('_', ' ', $currentStatus)) }}
                    </span>
                </div>
            </div>
        </section>

        {{-- Form --}}
        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="border-b border-stone-100 px-5 py-5 sm:px-6">
                <h2 class="text-base font-bold text-stone-900">
                    Informasi Perubahan
                </h2>
                <p class="mt-1 text-sm text-stone-500">
                    Lengkapi seluruh informasi yang diperlukan sebelum menyimpan.
                </p>
            </div>

            <form method="POST" action="{{ route('employees.employment-history.store', $employee) }}"
                class="space-y-6 p-5 sm:p-6">
                @csrf

                {{-- New status --}}
                <div>
                    <label for="employment_status" class="mb-2 block text-sm font-semibold text-stone-700">
                        Status Baru <span class="text-[#C96F4A]">*</span>
                    </label>

                    <select id="employment_status" name="employment_status" required
                        class="w-full rounded-lg border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-800 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                        <option value="">Pilih status kepegawaian</option>

                        @foreach ($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected(old('employment_status') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('employment_status')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <p id="status_description" class="mt-2 text-xs leading-5 text-stone-500">
                        Pilih status yang sesuai dengan kondisi kepegawaian karyawan.
                    </p>
                </div>

                {{-- Effective date --}}
                <div>
                    <label for="effective_date" class="mb-2 block text-sm font-semibold text-stone-700">
                        Tanggal Efektif <span class="text-[#C96F4A]">*</span>
                    </label>

                    <input type="date" id="effective_date" name="effective_date"
                        value="{{ old('effective_date', now()->toDateString()) }}" required
                        class="w-full rounded-lg border border-stone-300 bg-white px-3.5 py-3 text-sm text-stone-800 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">

                    @error('effective_date')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs leading-5 text-stone-500">
                        Tanggal ketika perubahan status mulai berlaku, bukan sekadar tanggal pengisian formulir.
                    </p>
                </div>

                {{-- Reason --}}
                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="reason" class="block text-sm font-semibold text-stone-700">
                            Alasan Perubahan <span class="text-[#C96F4A]">*</span>
                        </label>

                        <span class="text-xs text-stone-400">Maksimal 2.000 karakter</span>
                    </div>

                    <textarea id="reason" name="reason" rows="4" required maxlength="2000"
                        placeholder="Jelaskan alasan perubahan status secara jelas, misalnya: Kontrak kerja telah berakhir sesuai perjanjian."
                        class="w-full resize-y rounded-lg border border-stone-300 bg-white px-3.5 py-3 text-sm leading-6 text-stone-800 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">{{ old('reason') }}</textarea>

                    @error('reason')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs leading-5 text-stone-500">
                        Gunakan keterangan yang faktual agar perubahan dapat ditelusuri kembali saat diperlukan.
                    </p>
                </div>

                {{-- Notice --}}
                <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50/70 p-4">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 4h.01M10.3 3.9 2.7 17.2A2 2 0 0 0 4.4 20h15.2a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-amber-900">
                            Periksa sebelum menyimpan
                        </p>
                        <p class="mt-1 text-sm leading-6 text-amber-800">
                            Pastikan status, tanggal efektif, dan alasan sudah benar.
                            Perubahan yang disimpan akan menjadi catatan riwayat kepegawaian.
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-stone-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('employees.employment-history.index', $employee) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-stone-200 bg-white px-5 py-2.5 text-sm font-semibold text-stone-700! transition hover:bg-stone-50">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#C96F4A] bg-[#C96F4A] px-5 py-2.5 text-sm font-semibold text-white! shadow-sm transition hover:border-[#B85D3B] hover:bg-[#B85D3B]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 9.5 17 19 7.5" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>

        <p class="flex items-start gap-2 px-1 text-xs leading-5 text-stone-400">
            <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3m0 4h.01M10.3 3.9 2.7 17.2A2 2 0 0 0 4.4 20h15.2a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
            </svg>
            Informasi ini merupakan bagian dari catatan administrasi kepegawaian. Pastikan perubahan dilakukan sesuai
            kewenangan yang berlaku.
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('employment_status');
            const statusDescription = document.getElementById('status_description');

            if (!statusSelect || !statusDescription) {
                return;
            }

            const descriptions = @json($statusDescriptions);

            function updateStatusDescription() {
                statusDescription.textContent = descriptions[statusSelect.value] ||
                    'Pilih status yang sesuai dengan kondisi kepegawaian karyawan.';
            }

            statusSelect.addEventListener('change', updateStatusDescription);
            updateStatusDescription();
        });
    </script>
@endsection
