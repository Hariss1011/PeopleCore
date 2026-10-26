@extends('layouts.app')

@section('title', $isEdit ? 'Edit Karyawan' : 'Tambah Karyawan')

@section('content')
    @php
        $currentName = old('full_name', $employee->full_name);
        $initials = collect(explode(' ', trim($currentName ?? '')))
            ->filter()
            ->take(2)
            ->map(fn($word) => mb_substr($word, 0, 1))
            ->implode('');
    @endphp

    <div class="mx-auto max-w-5xl space-y-5">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('employees.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-stone-500 transition hover:text-[#9F4B2C]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                        <path stroke-linecap="round" d="M9 12h12" />
                    </svg>
                    Data Karyawan
                </a>

                <div class="mt-3 flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F7E9E2] text-[#9F4B2C]">
                        @if ($isEdit)
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m15 5 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                            </svg>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#B85C38]">
                            Human Resources / Master Data
                        </p>
                        <h1 class="mt-1 text-2xl font-bold tracking-tight text-stone-800">
                            {{ $isEdit ? 'Edit Data Karyawan' : 'Tambah Karyawan Baru' }}
                        </h1>
                        <p class="mt-1 text-sm text-stone-500">
                            {{ $isEdit ? 'Perbarui informasi profil dan kepegawaian.' : 'Daftarkan karyawan baru ke dalam sistem PeopleCore.' }}
                        </p>
                    </div>
                </div>
            </div>

            @if ($isEdit)
                <div class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3 shadow-sm">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F7E9E2] text-sm font-bold text-[#9F4B2C]">
                        {{ mb_strtoupper($initials ?: 'K') }}
                    </div>
                    <div>
                        <p class="text-xs text-stone-500">Nomor Karyawan</p>
                        <p class="text-sm font-bold text-stone-800">
                            {{ $employee->employee_number }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4" role="alert">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" d="M12 8v4m0 4h.01" />
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-rose-800">Periksa kembali data yang dimasukkan.</p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form id="employee-form" action="{{ $isEdit ? route('employees.update', $employee) : route('employees.store') }}"
            method="POST" class="space-y-5">

            @csrf

            @if ($isEdit)
                @method('PUT')
            @endif

            {{-- Personal information --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-stone-100 text-stone-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="8" r="4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-2a8 8 0 0 1 16 0v2" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-stone-800">Informasi Pribadi</h2>
                        <p class="mt-0.5 text-xs text-stone-500">Identitas dan informasi kontak karyawan.</p>
                    </div>
                    <span class="ml-auto text-xs text-stone-400">Bagian 01</span>
                </div>

                <div class="grid grid-cols-1 gap-x-5 gap-y-5 p-5 sm:grid-cols-2 sm:p-6">

                    <div>
                        <label for="employee_number" class="mb-1.5 block text-sm font-semibold text-stone-700">
                            Nomor Karyawan <span class="text-[#B85C38]">*</span>
                        </label>
                        <input id="employee_number" name="employee_number" type="text"
                            value="{{ old('employee_number', $employee->employee_number) }}" placeholder="Contoh: EMP-0009"
                            required maxlength="20" autocomplete="off"
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                        <p class="mt-1.5 text-xs text-stone-400">Gunakan nomor unik untuk setiap karyawan.</p>
                    </div>

                    <div>
                        <label for="full_name" class="mb-1.5 block text-sm font-semibold text-stone-700">
                            Nama Lengkap <span class="text-[#B85C38]">*</span>
                        </label>
                        <input id="full_name" name="full_name" type="text"
                            value="{{ old('full_name', $employee->full_name) }}" placeholder="Masukkan nama lengkap"
                            required maxlength="150" autocomplete="name"
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-stone-700">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $employee->email) }}"
                            placeholder="nama@perusahaan.com" autocomplete="email"
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div>
                        <label for="phone" class="mb-1.5 block text-sm font-semibold text-stone-700">Nomor
                            Telepon</label>
                        <input id="phone" name="phone" type="text"
                            value="{{ old('phone', $employee->phone) }}" placeholder="Contoh: 081234567890"
                            maxlength="25" autocomplete="tel"
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div>
                        <label for="gender" class="mb-1.5 block text-sm font-semibold text-stone-700">Jenis
                            Kelamin</label>
                        <select id="gender" name="gender"
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="male" @selected(old('gender', $employee->gender) === 'male')>Laki-laki</option>
                            <option value="female" @selected(old('gender', $employee->gender) === 'female')>Perempuan</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="mb-1.5 block text-sm font-semibold text-stone-700">Alamat</label>
                        <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat tempat tinggal karyawan"
                            class="w-full resize-y rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition placeholder:text-stone-400 focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">{{ old('address', $employee->address) }}</textarea>
                    </div>
                </div>
            </section>

            {{-- Employment information --}}
            <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-stone-100 px-5 py-4 sm:px-6">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F7E9E2] text-[#9F4B2C]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7">
                            <rect x="3" y="7" width="18" height="14" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-stone-800">Informasi Kepegawaian</h2>
                        <p class="mt-0.5 text-xs text-stone-500">Penempatan organisasi dan ketentuan masa kerja.</p>
                    </div>
                    <span class="ml-auto text-xs text-stone-400">Bagian 02</span>
                </div>

                <div class="grid grid-cols-1 gap-x-5 gap-y-5 p-5 sm:grid-cols-2 sm:p-6">

                    <div>
                        <label for="department_id" class="mb-1.5 block text-sm font-semibold text-stone-700">
                            Departemen <span class="text-[#B85C38]">*</span>
                        </label>
                        <select id="department_id" name="department_id" required
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                            <option value="">Pilih departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected((string) old('department_id', $employee->department_id) === (string) $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="position_id" class="mb-1.5 block text-sm font-semibold text-stone-700">
                            Jabatan <span class="text-[#B85C38]">*</span>
                        </label>
                        <select id="position_id" name="position_id" required
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                            <option value="">Pilih jabatan</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" data-department="{{ $position->department_id }}"
                                    @selected((string) old('position_id', $employee->position_id) === (string) $position->id)>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs text-stone-400">Jabatan mengikuti departemen yang dipilih.</p>
                    </div>

                    <div>
                        <label for="hire_date" class="mb-1.5 block text-sm font-semibold text-stone-700">
                            Tanggal Masuk <span class="text-[#B85C38]">*</span>
                        </label>
                        <input id="hire_date" name="hire_date" type="date"
                            value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}"
                            max="{{ now()->toDateString() }}" required
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                    </div>

                    <div>
                        <label for="employment_type" class="mb-1.5 block text-sm font-semibold text-stone-700">
                            Tipe Pekerjaan <span class="text-[#B85C38]">*</span>
                        </label>
                        <select id="employment_type" name="employment_type" required
                            class="w-full rounded-lg border border-stone-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10">
                            <option value="">Pilih tipe pekerjaan</option>
                            <option value="permanent" @selected(old('employment_type', $employee->employment_type) === 'permanent')>Permanen</option>
                            <option value="contract" @selected(old('employment_type', $employee->employment_type) === 'contract')>Kontrak</option>
                        </select>
                    </div>

                    <div id="contract_end_wrapper" class="sm:col-span-2">
                        <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-4">
                            <div class="mb-3 flex items-start gap-2.5">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-700" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7">
                                    <circle cx="12" cy="12" r="9" />
                                    <path stroke-linecap="round" d="M12 7v5l3 2" />
                                </svg>
                                <div>
                                    <label for="contract_end_date" class="block text-sm font-semibold text-stone-800">
                                        Tanggal Akhir Kontrak
                                    </label>
                                    <p class="mt-0.5 text-xs leading-relaxed text-stone-500">
                                        Isi tanggal berakhirnya kontrak jika karyawan berstatus kontrak.
                                    </p>
                                </div>
                            </div>

                            <input id="contract_end_date" name="contract_end_date" type="date"
                                value="{{ old('contract_end_date', $employee->contract_end_date?->format('Y-m-d')) }}"
                                class="w-full rounded-lg border border-amber-200 bg-white px-3.5 py-2.5 text-sm text-stone-700 outline-none transition focus:border-[#B85C38] focus:ring-2 focus:ring-[#B85C38]/10 sm:max-w-md">
                        </div>
                    </div>
                </div>
            </section>

            {{-- Form actions --}}
            <div class="sticky bottom-0 z-10 -mx-1 border-t border-stone-200 bg-[#F8F7F5]/95 px-1 py-4 backdrop-blur-sm">
                <div class="flex flex-col-reverse justify-between gap-3 sm:flex-row sm:items-center">
                    <p class="text-xs text-stone-500">
                        <span class="font-semibold text-[#B85C38]">*</span>
                        Wajib diisi
                    </p>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row">
                        <a href="{{ $isEdit ? route('employees.show', $employee) : route('employees.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-stone-200 bg-white px-5 py-2.5 text-sm font-semibold text-stone-600 transition hover:bg-stone-100">
                            Batal
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B85C38] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#9F4B2C] focus:outline-none focus:ring-2 focus:ring-[#B85C38]/30">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Karyawan' }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const department = document.getElementById('department_id');
            const position = document.getElementById('position_id');
            const employmentType = document.getElementById('employment_type');
            const contractEnd = document.getElementById('contract_end_date');
            const contractWrapper = document.getElementById('contract_end_wrapper');

            function filterPositions() {
                const departmentId = department.value;
                const currentPosition = position.value;

                Array.from(position.options).forEach(function(option) {
                    if (!option.value) {
                        option.hidden = false;
                        return;
                    }

                    const matches = option.dataset.department === departmentId;
                    option.hidden = !matches;

                    if (!matches && option.value === currentPosition) {
                        position.value = '';
                    }
                });
            }

            function toggleContractEnd() {
                const isContract = employmentType.value === 'contract';

                contractWrapper.hidden = !isContract;
                contractEnd.required = isContract;

                if (!isContract) {
                    contractEnd.value = '';
                }
            }

            department.addEventListener('change', filterPositions);
            employmentType.addEventListener('change', toggleContractEnd);

            filterPositions();
            toggleContractEnd();
        });
    </script>
@endsection
