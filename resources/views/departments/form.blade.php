@extends('layouts.app')

@section('title', $department->exists ? 'Edit Departemen' : 'Tambah Departemen')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        {{-- Header --}}
        <div>
            <a href="{{ route('departments.index') }}"
                class="mb-5 inline-flex items-center gap-2 text-sm font-semibold text-stone-500 transition hover:text-[#A85435]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Departemen
            </a>

            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                        <span class="h-1.5 w-6 rounded-full bg-[#C96F4A]"></span>
                        Pengaturan Admin
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-[#292724] sm:text-3xl">
                        {{ $department->exists ? 'Edit Departemen' : 'Tambah Departemen' }}
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                        {{ $department->exists
                            ? 'Perbarui informasi dan status unit organisasi perusahaan.'
                            : 'Tambahkan unit organisasi baru agar struktur kepegawaian tersusun dengan baik.' }}
                    </p>
                </div>

                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full bg-[#F8F0EB] px-3.5 py-2 text-xs font-semibold text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h4" />
                    </svg>
                    {{ $department->exists ? 'Pembaruan Data' : 'Departemen Baru' }}
                </span>
            </div>
        </div>

        @include('partials.flash')

        {{-- Informasi saat edit --}}
        @if ($department->exists)
            <div
                class="flex flex-col gap-4 rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:p-6">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-sm font-bold text-[#A85435] ring-1 ring-[#EBD4C7]">
                    {{ mb_strtoupper(mb_substr($department->code ?: $department->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-400">Departemen yang dipilih</p>
                    <h2 class="mt-1 text-lg font-bold text-[#292724]">{{ $department->name }}</h2>
                    <p class="mt-1 text-sm text-stone-500">Kode: {{ $department->code }}</p>
                </div>
                <div>
                    @if ($department->is_active)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        @endif

        <form method="POST"
            action="{{ $department->exists ? route('departments.update', $department) : route('departments.store') }}"
            class="space-y-5">
            @csrf
            @if ($department->exists)
                @method('PUT')
            @endif

            {{-- Informasi utama --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
                <div class="flex items-start gap-3 border-b border-stone-100 px-5 py-5 sm:px-7">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]">
                        01
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Informasi Departemen</h2>
                        <p class="mt-1 text-sm text-stone-500">
                            Tentukan nama, kode identifikasi, dan deskripsi unit organisasi.
                        </p>
                    </div>
                </div>

                <div class="space-y-5 p-5 sm:p-7">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-stone-700">
                            Nama departemen <span class="text-[#C96F4A]">*</span>
                        </label>
                        <input id="name" name="name" type="text" required maxlength="100"
                            value="{{ old('name', $department->name) }}" placeholder="Contoh: Human Resources"
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724] outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        @error('name')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-stone-400">Maksimal 100 karakter.</p>
                    </div>

                    <div>
                        <label for="code" class="mb-2 block text-sm font-semibold text-stone-700">
                            Kode departemen <span class="text-[#C96F4A]">*</span>
                        </label>
                        <input id="code" name="code" type="text" required maxlength="20"
                            value="{{ old('code', $department->code) }}" placeholder="Contoh: HRD"
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724] outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        @error('code')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-stone-400">Gunakan kode singkat yang mudah dikenali, maksimal 20
                            karakter.</p>
                    </div>

                    <div>
                        <label for="description" class="mb-2 block text-sm font-semibold text-stone-700">
                            Deskripsi departemen
                        </label>
                        <textarea id="description" name="description" rows="4"
                            placeholder="Jelaskan fungsi atau tanggung jawab utama departemen ini..."
                            class="w-full resize-y rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm leading-6 text-[#292724] outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-stone-400">Opsional. Gunakan deskripsi singkat yang menjelaskan fungsi
                            departemen.</p>
                    </div>
                </div>
            </section>

            {{-- Status departemen --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
                <div class="flex items-start gap-3 border-b border-stone-100 px-5 py-5 sm:px-7">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]">
                        02
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]">Status Operasional</h2>
                        <p class="mt-1 text-sm text-stone-500">
                            Atur apakah departemen ditandai aktif atau nonaktif.
                        </p>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <label for="is_active" class="mb-2 block text-sm font-semibold text-stone-700">
                        Status departemen <span class="text-[#C96F4A]">*</span>
                    </label>
                    <select id="is_active" name="is_active" required
                        class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        <option value="1" @selected((string) old('is_active', $department->exists ? (int) $department->is_active : 1) === '1')>
                            Aktif — departemen beroperasi
                        </option>
                        <option value="0" @selected((string) old('is_active', $department->exists ? (int) $department->is_active : 1) === '0')>
                            Nonaktif — departemen tidak aktif
                        </option>
                    </select>
                    @error('is_active')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-4 flex gap-3 rounded-xl border border-amber-100 bg-amber-50/70 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-amber-700"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9" />
                            <path stroke-linecap="round" d="M12 11v5m0-8h.01" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-amber-900">Perhatikan status departemen</p>
                            <p class="mt-1 text-xs leading-5 text-amber-800">
                                Perubahan status di form ini hanya memperbarui status departemen. Dampaknya terhadap
                                pemilihan departemen pada data karyawan atau jabatan mengikuti aturan yang diterapkan di
                                backend.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Aksi form --}}
            <div
                class="flex flex-col-reverse justify-between gap-3 rounded-2xl border border-stone-200/80 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:px-6">
                <p class="hidden text-xs text-stone-500 sm:block">
                    <span class="text-[#C96F4A]">*</span> Wajib diisi
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a href="{{ route('departments.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-3 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 3h12l4 4v14H3V3h2Zm2 0v6h10V3M7 21v-7h10v7" />
                        </svg>
                        {{ $department->exists ? 'Simpan Perubahan' : 'Simpan Departemen' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
