@extends('layouts.app')

@section('title', 'Edit Kuota Cuti')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F8F0EB] text-[#A85435]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 3.5a2.12 2.12 0 013 3L8 18l-4 1 1-4 11.5-11.5z" />
                    </svg>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-2xl font-bold tracking-tight text-[#292724]">
                            Edit Kuota Cuti
                        </h1>
                        <span class="rounded-full bg-[#F8F0EB] px-2.5 py-1 text-xs font-semibold text-[#A85435]">
                            Ubah Data
                        </span>
                    </div>
                    <p class="mt-1.5 max-w-2xl text-sm leading-6 text-[#79736D]">
                        Sesuaikan alokasi cuti karyawan dengan tetap memperhatikan jumlah cuti yang telah digunakan.
                    </p>
                </div>
            </div>

            <a href="{{ route('leave-balances.index', ['year' => $leaveBalance->year]) }}"
                class="inline-flex items-center justify-center gap-2 self-start rounded-xl border border-[#E7E0DA] bg-white px-4 py-2.5 text-sm font-semibold text-[#514B45] transition hover:bg-[#F8F5F2] sm:self-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7 7-7M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>

        @include('partials.flash')

        {{-- Current Data Summary --}}
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-[#EAE4DE] bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F8F0EB] text-[#A85435]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m6-10a4 4 0 100-8 4 4 0 000 8zm10 10v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-[#79736D]">Karyawan</p>
                </div>
                <p class="mt-4 text-sm font-bold text-[#292724]">
                    {{ $leaveBalance->employee->full_name }}
                </p>
                <p class="mt-1 text-xs text-[#89827B]">
                    {{ $leaveBalance->employee->employee_number }}
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAE4DE] bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F4F0EB] text-[#6E6257]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-[#79736D]">Jenis Cuti</p>
                </div>
                <p class="mt-4 text-sm font-bold text-[#292724]">
                    {{ $leaveBalance->leaveType->name }}
                </p>
                <p class="mt-1 text-xs text-[#89827B]">
                    Periode {{ $leaveBalance->year }}
                </p>
            </div>

            <div class="rounded-2xl border border-[#EAE4DE] bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F0F4EE] text-[#53734D]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-[#79736D]">Kuota Saat Ini</p>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-bold tracking-tight text-[#292724]">
                        {{ $leaveBalance->quota_days }}
                    </span>
                    <span class="text-sm text-[#79736D]">hari</span>
                </div>
                <p class="mt-1 text-xs text-[#89827B]">Alokasi cuti yang tercatat</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-[#EAE4DE] bg-white shadow-sm">
            <div class="border-b border-[#EEE8E2] bg-[#FCFAF8] px-6 py-5 sm:px-8">
                <h2 class="text-base font-bold text-[#292724]">Perbarui Informasi Kuota</h2>
                <p class="mt-1 text-sm text-[#79736D]">
                    Periksa kembali data sebelum menyimpan perubahan.
                </p>
            </div>

            <form method="POST" action="{{ route('leave-balances.update', $leaveBalance) }}" class="space-y-7 p-6 sm:p-8">
                @csrf
                @method('PUT')

                {{-- Employee --}}
                <div>
                    <label for="employee_id" class="mb-2 block text-sm font-semibold text-[#403B36]">
                        Karyawan
                        <span class="text-[#C96F4A]">*</span>
                    </label>

                    <select id="employee_id" name="employee_id" required
                        class="w-full rounded-xl border border-[#DDD5CE] bg-white px-4 py-3 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('employee_id') @enderror">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('employee_id', $leaveBalance->employee_id) == $employee->id)>
                                {{ $employee->employee_number }} — {{ $employee->full_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('employee_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
                        @foreach ($leaveTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('leave_type_id', $leaveBalance->leave_type_id) == $type->id)>
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
                            value="{{ old('year', $leaveBalance->year) }}"
                            class="w-full rounded-xl border border-[#DDD5CE] bg-white px-4 py-3 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('year') @enderror">

                        <p class="mt-1.5 text-xs leading-5 text-[#89827B]">
                            Tahun kalender berlakunya kuota.
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
                            <input id="quota_days" name="quota_days" type="number" min="0" max="366"
                                required value="{{ old('quota_days', $leaveBalance->quota_days) }}"
                                class="w-full rounded-xl border border-[#DDD5CE] bg-white py-3 pl-4 pr-16 text-sm text-[#292724] outline-none transition focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10 @error('quota_days') @enderror">

                            <span class="absolute inset-y-0 right-4 flex items-center text-sm font-medium text-[#89827B]">
                                hari
                            </span>
                        </div>

                        <p class="mt-1.5 text-xs leading-5 text-[#89827B]">
                            Jumlah alokasi cuti setelah diperbarui.
                        </p>

                        @error('quota_days')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Warning Note --}}
                <div class="flex gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-amber-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 4h.01M10.3 3.9L2.7 17.1A2 2 0 004.4 20h15.2a2 2 0 001.7-2.9L13.7 3.9a2 2 0 00-3.4 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-amber-900">Perhatikan pemakaian cuti</p>
                        <p class="mt-1 text-sm leading-6 text-amber-800">
                            Kuota baru tidak boleh lebih kecil daripada jumlah cuti yang telah digunakan. Pastikan perubahan
                            tidak mengganggu saldo cuti karyawan.
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#EEE8E2] pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('leave-balances.index', ['year' => $leaveBalance->year]) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#DDD5CE] px-5 py-3 text-sm font-semibold text-[#514B45] transition hover:bg-[#F8F5F2]">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C96F4A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#B85F3D] focus:outline-none focus:ring-4 focus:ring-[#C96F4A]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-[#938B83]">
            PeopleCore · Manajemen Kuota Cuti
        </p>
    </div>
@endsection
