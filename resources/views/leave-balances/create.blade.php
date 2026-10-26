@extends('layouts.app')

@section('title', 'Tambah Kuota Cuti')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v4m-2-2h4" />
                    </svg>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-2xl font-bold tracking-tight text-[#292724]">
                            Tambah Kuota Cuti
                        </h1>
                        <span class="rounded-full bg-[#F8F0EB] px-2.5 py-1 text-xs font-semibold text-[#A85435]">
                            Data Baru
                        </span>
                    </div>
                    <p class="mt-1.5 max-w-2xl text-sm leading-6 text-[#79736D]">
                        Tetapkan alokasi cuti karyawan berdasarkan jenis cuti dan tahun yang berlaku.
                    </p>
                </div>
            </div>

            <a href="{{ route('leave-balances.index', ['year' => $year]) }}"
                class="inline-flex items-center justify-center gap-2 self-start rounded-xl border border-[#E7E0DA] bg-white px-4 py-2.5 text-sm font-semibold text-[#514B45] transition hover:bg-[#F8F5F2] sm:self-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7 7-7M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>

        @include('partials.flash')

        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-[#EAE4DE] bg-white shadow-sm">
            <div class="border-b border-[#EEE8E2] bg-[#FCFAF8] px-6 py-5 sm:px-8">
                <h2 class="text-base font-bold text-[#292724]">Informasi Kuota</h2>
                <p class="mt-1 text-sm text-[#79736D]">
                    Lengkapi seluruh informasi berikut untuk membuat kuota cuti baru.
                </p>
            </div>

            <form method="POST" action="{{ route('leave-balances.store') }}" class="space-y-7 p-6 sm:p-8">
                @csrf

                {{-- Employee --}}
                <div>
                    <label for="employee_id" class="mb-2 block text-sm font-semibold text-[#403B36]">
                        Karyawan
                        <span class="text-[#C96F4A]">*</span>
                    </label>

                    <select id="employee_id" name="employee_id" required
                        class="w-full rounded-xl border border-[#DDD5CE] bg-white px-4 py-3 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('employee_id') @enderror">
                        <option value="">Pilih karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>
                                {{ $employee->employee_number }} — {{ $employee->full_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('employee_id')
                        <p class="mt-2 flex items-start gap-1.5 text-sm text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4m0 4h.01M10.3 3.9L2.7 17.1A2 2 0 004.4 20h15.2a2 2 0 001.7-2.9L13.7 3.9a2 2 0 00-3.4 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Leave Type --}}
                <div>
                    <label for="leave_type_id" class="mb-2 block text-sm font-semibold text-[#403B36]">
                        Jenis Cuti
                        <span class="text-[#C96F4A]">*</span>
                    </label>

                    <select id="leave_type_id" name="leave_type_id" required
                        class="w-full rounded-xl border border-[#DDD5CE] bg-white px-4 py-3 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('leave_type_id') @enderror">
                        <option value="">Pilih jenis cuti</option>
                        @foreach ($leaveTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('leave_type_id') == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('leave_type_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Year and Quota --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="year" class="mb-2 block text-sm font-semibold text-[#403B36]">
                            Tahun Kuota
                            <span class="text-[#C96F4A]">*</span>
                        </label>

                        <input id="year" name="year" type="number" min="2000" max="2100" required
                            value="{{ old('year', $year) }}"
                            class="w-full rounded-xl border border-[#DDD5CE] bg-white px-4 py-3 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('year') @enderror">

                        <p class="mt-1.5 text-xs leading-5 text-[#89827B]">
                            Tahun kalender berlakunya kuota cuti.
                        </p>

                        @error('year')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quota_days" class="mb-2 block text-sm font-semibold text-[#403B36]">
                            Jumlah Kuota
                            <span class="text-[#C96F4A]">*</span>
                        </label>

                        <div class="relative">
                            <input id="quota_days" name="quota_days" type="number" min="0" max="366" required
                                value="{{ old('quota_days', 12) }}"
                                class="w-full rounded-xl border border-[#DDD5CE] bg-white py-3 pl-4 pr-16 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('quota_days') @enderror">

                            <span class="absolute inset-y-0 right-4 flex items-center text-sm font-medium text-[#89827B]">
                                hari
                            </span>
                        </div>

                        <p class="mt-1.5 text-xs leading-5 text-[#89827B]">
                            Masukkan jumlah hari cuti yang diberikan.
                        </p>

                        @error('quota_days')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Information Note --}}
                <div class="flex gap-3 rounded-xl border border-[#EDE0D7] bg-[#FCF7F3] p-4">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#A85435] shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 16v-4m0-4h.01M22 12a10 10 0 11-20 0 10 10 0 0120 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#514037]">Periksa data sebelum menyimpan</p>
                        <p class="mt-1 text-sm leading-6 text-[#806C60]">
                            Pastikan karyawan, jenis cuti, tahun, dan jumlah kuota sudah sesuai. Hindari membuat kuota ganda
                            untuk kombinasi data yang sama.
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#EEE8E2] pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('leave-balances.index', ['year' => $year]) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#DDD5CE] px-5 py-3 text-sm font-semibold text-[#514B45] transition hover:bg-[#F8F5F2]">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85F3D] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                        </svg>
                        Simpan Kuota
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-[#938B83]">
            PeopleCore · Manajemen Kuota Cuti
        </p>
    </div>
@endsection
