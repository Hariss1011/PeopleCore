@extends('layouts.app')

@section('title', $leaveType->exists ? 'Edit Jenis Cuti' : 'Tambah Jenis Cuti')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <a href="{{ route('leave-types.index') }}"
                    class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-stone-500 transition hover:text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke daftar jenis cuti
                </a>

                <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-stone-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                    Pengaturan Kepegawaian
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-stone-800 sm:text-3xl">
                    {{ $leaveType->exists ? 'Edit Jenis Cuti' : 'Tambah Jenis Cuti' }}
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500">
                    {{ $leaveType->exists
                        ? 'Perbarui identitas dan status jenis cuti untuk menjaga konsistensi administrasi kepegawaian.'
                        : 'Daftarkan kategori cuti baru agar dapat dikelola dalam proses administrasi dan pengajuan cuti karyawan.' }}
                </p>
            </div>

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                @if ($leaveType->exists)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l2.651 2.651M8 16l-1 4 4-1L20 10a2.121 2.121 0 00-3-3L8 16z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 01-1 1V6a1 1 0 011-1z" />
                    </svg>
                @endif
            </div>
        </div>

        @include('partials.flash')

        {{-- Form --}}
        <form method="POST"
            action="{{ $leaveType->exists ? route('leave-types.update', $leaveType) : route('leave-types.store') }}"
            class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">

            @csrf

            @if ($leaveType->exists)
                @method('PUT')
            @endif

            {{-- Form Intro --}}
            <div class="border-b border-stone-200 bg-[#FCFAF8] px-6 py-5 sm:px-8">
                <h2 class="font-semibold text-stone-800">Informasi Jenis Cuti</h2>
                <p class="mt-1 text-sm text-stone-500">
                    Lengkapi identitas dan pengaturan kategori cuti.
                </p>
            </div>

            <div class="space-y-6 p-6 sm:p-8">

                {{-- Name --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-stone-700">
                        Nama Jenis Cuti <span class="text-[#A85435]">*</span>
                    </label>

                    <input type="text" id="name" name="name" required maxlength="100"
                        value="{{ old('name', $leaveType->name) }}"
                        placeholder="Contoh: Cuti Tahunan, Cuti Sakit, Cuti Melahirkan"
                        class="w-full rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-stone-500">
                        Gunakan nama yang jelas dan mudah dikenali karyawan.
                    </p>
                </div>

                {{-- Code --}}
                <div>
                    <label for="code" class="mb-2 block text-sm font-semibold text-stone-700">
                        Kode Jenis Cuti <span class="text-[#A85435]">*</span>
                    </label>

                    <input type="text" id="code" name="code" required maxlength="30"
                        value="{{ old('code', $leaveType->code) }}" placeholder="Contoh: CT, CS, CM"
                        class="w-full rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">

                    @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs leading-5 text-stone-500">
                        Gunakan kode singkat yang konsisten. Pastikan kode mengikuti aturan validasi sistem.
                    </p>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-stone-700">
                        Deskripsi
                    </label>

                    <textarea id="description" name="description" rows="4"
                        placeholder="Jelaskan tujuan atau ketentuan umum dari jenis cuti ini..."
                        class="w-full resize-y rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm leading-6 text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">{{ old('description', $leaveType->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-stone-500">
                        Opsional. Deskripsi membantu membedakan kategori cuti dalam administrasi HR.
                    </p>
                </div>

                {{-- Status --}}
                <div class="rounded-xl border border-stone-200 bg-[#FCFAF8] p-5">
                    <label for="is_active" class="mb-2 block text-sm font-semibold text-stone-700">
                        Status Jenis Cuti <span class="text-[#A85435]">*</span>
                    </label>

                    <select id="is_active" name="is_active" required
                        class="w-full rounded-xl border border-stone-200 bg-white px-4 py-3 text-sm text-stone-700 outline-none transition focus:border-[#C96F4A] focus:ring-2 focus:ring-[#C96F4A]/15">
                        <option value="1" @selected((string) old('is_active', $leaveType->exists ? (int) $leaveType->is_active : 1) === '1')>
                            Aktif
                        </option>
                        <option value="0" @selected((string) old('is_active', $leaveType->exists ? (int) $leaveType->is_active : 1) === '0')>
                            Nonaktif
                        </option>
                    </select>

                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs leading-5 text-stone-500">
                        Gunakan status nonaktif jika kategori tidak lagi digunakan. Dampaknya terhadap pengajuan baru
                        mengikuti aturan yang diterapkan pada backend.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-stone-200 bg-[#FCFAF8] px-6 py-5 sm:flex-row sm:justify-end sm:px-8">
                <a href="{{ route('leave-types.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-stone-200 bg-white px-5 py-3 text-sm font-semibold text-stone-600 transition hover:bg-stone-50">
                    Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292724] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#403B36]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ $leaveType->exists ? 'Simpan Perubahan' : 'Simpan Jenis Cuti' }}
                </button>
            </div>
        </form>

        {{-- Guidance --}}
        <div class="flex items-start gap-3 rounded-xl border border-[#EAD7CB] bg-[#F8F0EB] p-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-[#A85435]" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" d="M12 11v5m0-8h.01" />
            </svg>

            <div>
                <p class="text-sm font-semibold text-[#8E482F]">Panduan pengelolaan jenis cuti</p>
                <p class="mt-1 text-sm leading-6 text-[#8E482F]">
                    Pastikan nama dan kode jenis cuti mudah dipahami serta konsisten. Sebelum menghapus kategori yang sudah
                    memiliki riwayat pengajuan, periksa aturan penghapusan pada sistem.
                </p>
            </div>
        </div>
    </div>
@endsection
