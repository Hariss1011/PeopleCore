@extends('layouts.app')

@section('title', $user->exists ? 'Edit Akun' : 'Tambah Akun')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        {{-- Header --}}
        <div>
            <a href="{{ route('users.index') }}"
                class="mb-5 inline-flex items-center gap-2 text-sm font-semibold text-stone-500! transition hover:text-[#A85435]!">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
                Kembali ke Manajemen Pengguna
            </a>

            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#A85435]">
                        <span class="h-1.5 w-6 rounded-full bg-[#C96F4A]"></span>
                        Pengaturan Admin
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-[#292724]! sm:text-3xl">
                        {{ $user->exists ? 'Edit Akun Pengguna' : 'Tambah Pengguna Baru' }}
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500!">
                        {{ $user->exists
                            ? 'Perbarui identitas, hak akses, dan keterhubungan akun dengan data karyawan.'
                            : 'Buat akun baru dan tentukan hak akses serta keterhubungannya dengan data karyawan.' }}
                    </p>
                </div>

                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full bg-[#F8F0EB] px-3.5 py-2 text-xs font-semibold text-[#A85435]!">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m-3-3h6" />
                    </svg>
                    {{ $user->exists ? 'Pembaruan Akun' : 'Akun Baru' }}
                </span>
            </div>
        </div>

        @include('partials.flash')

        {{-- Ringkasan akun saat mengedit --}}
        @if ($user->exists)
            <div
                class="flex flex-col gap-4 rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:p-6">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-lg font-bold text-[#A85435]! ring-1 ring-[#EBD4C7]">
                    {{ collect(preg_split('/\s+/', trim($user->name)))->filter()->take(2)->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('') ?:'U' }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-400!">Akun yang sedang diedit</p>
                    <h2 class="mt-1 wrap-break-word text-lg font-bold text-[#292724]!">{{ $user->name }}</h2>
                    <p class="mt-1 break-all text-sm text-stone-500!">{{ $user->email }}</p>
                </div>
                <div class="w-fit rounded-full bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-600!">
                    ID Akun: {{ $user->id }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}"
            class="space-y-5">
            @csrf
            @if ($user->exists)
                @method('PUT')
            @endif

            {{-- Bagian 1: Identitas --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
                <div class="flex items-start gap-3 border-b border-stone-100 px-5 py-5 sm:px-7">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]!">
                        01
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]!">Informasi Akun</h2>
                        <p class="mt-1 text-sm text-stone-500!">Identitas utama yang digunakan untuk masuk ke sistem.</p>
                    </div>
                </div>

                <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-stone-700!">
                            Nama akun <span class="text-[#C96F4A]">*</span>
                        </label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                            autocomplete="name" placeholder="Masukkan nama pengguna"
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724]! outline-none transition placeholder:text-stone-400! focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        @error('name')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-stone-700!">
                            Alamat email <span class="text-[#C96F4A]">*</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                            required autocomplete="email" placeholder="nama@perusahaan.com"
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724]! outline-none transition placeholder:text-stone-400! focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        @error('email')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Bagian 2: Hak akses --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
                <div class="flex items-start gap-3 border-b border-stone-100 px-5 py-5 sm:px-7">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]!">
                        02
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]!">Hak Akses dan Data Karyawan</h2>
                        <p class="mt-1 text-sm text-stone-500!">Tentukan kewenangan dan hubungan akun dengan data
                            kepegawaian.</p>
                    </div>
                </div>

                <div class="space-y-5 p-5 sm:p-7">
                    <div>
                        <label for="role" class="mb-2 block text-sm font-semibold text-stone-700!">
                            Role pengguna <span class="text-[#C96F4A]">*</span>
                        </label>
                        <select id="role" name="role" required
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724]! outline-none transition focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                            <option value="">Pilih role pengguna</option>
                            @foreach (['admin' => 'Admin', 'hr' => 'HR', 'employee' => 'Employee'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="mt-3 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-xl border border-stone-200 bg-[#FCFAF8] p-3.5">
                                <span
                                    class="inline-flex rounded-full bg-stone-200 px-2.5 py-1 text-[11px] font-bold text-stone-700">ADMIN</span>
                                <p class="mt-2 text-xs leading-5 text-stone-500!">Pengelolaan akun dan konfigurasi sistem.
                                </p>
                            </div>
                            <div class="rounded-xl border border-[#EBD4C7] bg-[#F8F0EB]/60 p-3.5">
                                <span
                                    class="inline-flex rounded-full bg-[#F8F0EB] px-2.5 py-1 text-[11px] font-bold text-[#A85435]!">HR</span>
                                <p class="mt-2 text-xs leading-5 text-stone-500!">Pengelolaan operasional dan data
                                    kepegawaian sesuai izin.</p>
                            </div>
                            <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-3.5">
                                <span
                                    class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700">EMPLOYEE</span>
                                <p class="mt-2 text-xs leading-5 text-stone-500!">Akses mandiri sesuai hak akses karyawan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="employee_id" class="mb-2 block text-sm font-semibold text-stone-700!">
                            Hubungkan dengan karyawan
                        </label>
                        <select id="employee_id" name="employee_id"
                            class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724]! outline-none transition focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                            <option value="">Tidak dihubungkan (misalnya akun Admin)</option>
                            @foreach ($employees as $employee)
                                @php
                                    $linkedToAnotherAccount = $employee->user && $employee->user->id !== $user->id;
                                @endphp
                                <option value="{{ $employee->id }}" @selected((string) old('employee_id', $user->employee_id) === (string) $employee->id)
                                    @disabled($linkedToAnotherAccount)>
                                    {{ $employee->employee_number }} — {{ $employee->full_name }}
                                    ({{ $employee->department?->name ?? 'Tanpa departemen' }})
                                    {{ $linkedToAnotherAccount ? '— sudah terhubung ke akun lain' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs leading-5 text-stone-500!">
                            Hubungkan akun HR atau Employee dengan data karyawan yang sesuai. Pilihan yang sudah terhubung
                            ke akun lain tidak dapat dipilih.
                        </p>
                        @error('employee_id')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Bagian 3: Password --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white shadow-sm">
                <div class="flex items-start gap-3 border-b border-stone-100 px-5 py-5 sm:px-7">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F8F0EB] text-sm font-bold text-[#A85435]!">
                        03
                    </div>
                    <div>
                        <h2 class="font-bold text-[#292724]!">Keamanan Akun</h2>
                        <p class="mt-1 text-sm text-stone-500!">Atur kredensial untuk autentikasi pengguna.</p>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="mb-5 flex gap-3 rounded-xl border border-[#EBD4C7] bg-[#F8F0EB]/60 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-[#A85435]!"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="10" width="16" height="11" rx="2" />
                            <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3m-4 5v2" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-[#292724]!">
                                {{ $user->exists ? 'Ganti password secara opsional' : 'Buat password akun' }}
                            </p>
                            <p class="mt-1 text-xs leading-5 text-stone-600!">
                                {{ $user->exists
                                    ? 'Kosongkan kedua kolom password jika tidak ingin mengubah password yang sekarang.'
                                    : 'Gunakan password minimal 8 karakter. Konfirmasi harus sama dengan password yang dimasukkan.' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-stone-700!">
                                Password
                                @unless ($user->exists)
                                    <span class="text-[#C96F4A]">*</span>
                                @endunless
                            </label>
                            <input id="password" type="password" name="password" {{ $user->exists ? '' : 'required' }}
                                autocomplete="new-password" minlength="8"
                                placeholder="{{ $user->exists ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}"
                                class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724]! outline-none transition placeholder:text-stone-400! focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                            @error('password')
                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-stone-700!">
                                Konfirmasi password
                                @unless ($user->exists)
                                    <span class="text-[#C96F4A]">*</span>
                                @endunless
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                {{ $user->exists ? '' : 'required' }} autocomplete="new-password" minlength="8"
                                placeholder="Ulangi password"
                                class="w-full rounded-xl border border-stone-200 bg-[#FCFAF8] px-4 py-3 text-sm text-[#292724]! outline-none transition placeholder:text-stone-400! focus:border-[#C96F4A] focus:bg-white focus:ring-4 focus:ring-[#C96F4A]/10">
                        </div>
                    </div>
                </div>
            </section>

            {{-- Tombol aksi --}}
            <div
                class="flex flex-col-reverse justify-between gap-3 rounded-2xl border border-stone-200/80 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:px-6">
                <p class="hidden text-xs text-stone-500! sm:block">
                    <span class="text-[#C96F4A]">*</span> Wajib diisi
                </p>
                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-3 text-sm font-semibold text-stone-600! transition hover:bg-stone-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-6 py-3 text-sm font-semibold text-white! shadow-sm transition hover:bg-[#B85D3B] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 3h12l4 4v14H3V3h2Zm2 0v6h10V3M7 21v-7h10v7" />
                        </svg>
                        {{ $user->exists ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
