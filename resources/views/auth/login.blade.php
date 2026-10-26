@extends('layouts.app')

@section('title', 'Login')

@section('guest-content')
    <main class="min-h-screen bg-[#FCFAF8] lg:grid lg:grid-cols-2">

        {{-- Left: Login Form --}}
        <section class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-10 lg:px-14 xl:px-20">
            <div class="w-full max-w-md">

                {{-- Brand --}}
                <a href="{{ route('login') }}" class="mb-12 inline-flex items-center gap-3">
                    <span
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#292724] text-xl font-bold text-white shadow-sm">
                        P
                    </span>
                    <span class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-[#292724]">
                            PeopleCore
                        </span>
                        <span class="mt-0.5 text-xs font-medium tracking-wide text-[#89827B]">
                            HUMAN RESOURCES INFORMATION SYSTEM
                        </span>
                    </span>
                </a>

                {{-- Heading --}}
                <div class="mb-8">
                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-[#F8F0EB] px-3 py-1.5 text-xs font-bold tracking-wide text-[#A85435]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#C96F4A]"></span>
                        SELAMAT DATANG KEMBALI
                    </span>

                    <h1 class="mt-5 text-3xl font-bold tracking-tight text-[#292724] sm:text-4xl">
                        Masuk ke akun Anda
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-[#79736D]">
                        Silakan masuk untuk mengakses sistem pengelolaan sumber daya manusia.
                    </p>
                </div>

                {{-- Flash Message --}}
                @include('partials.flash')

                {{-- Validation Error --}}
                @if ($errors->any())
                    <div role="alert" class="mb-5 flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-red-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M10.3 3.9L2.7 17.1A2 2 0 004.4 20h15.2a2 2 0 001.7-2.9L13.7 3.9a2 2 0 00-3.4 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-800">
                                Login gagal
                            </p>
                            <p class="mt-1 text-sm leading-5 text-red-700">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Login Form --}}
                <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#403B36]">
                            Alamat email
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#938B83]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                </svg>
                            </div>

                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="nama@perusahaan.com" autocomplete="username" required autofocus
                                class="w-full rounded-xl border border-[#DDD5CE] bg-white py-3.5 pl-12 pr-4 text-sm text-[#292724] outline-none transition placeholder:text-[#B0A79F] focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        </div>

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-[#403B36]">
                            Password
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#938B83]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 10V7a5 5 0 0110 0v3m-12 0h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1v-9a1 1 0 011-1zm7 4v3" />
                                </svg>
                            </div>

                            <input type="password" id="password" name="password" placeholder="Masukkan password"
                                autocomplete="current-password" required
                                class="w-full rounded-xl border border-[#DDD5CE] bg-white py-3.5 pl-12 pr-4 text-sm text-[#292724] outline-none transition placeholder:text-[#B0A79F] focus:border-[#C96F4A] focus:ring-4 focus:ring-[#C96F4A]/10">
                        </div>

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember"
                            class="inline-flex cursor-pointer items-center gap-2.5 text-sm text-[#655E57]">
                            <input type="checkbox" id="remember" name="remember" value="1"
                                @checked(old('remember'))
                                class="h-4 w-4 rounded border-[#CFC5BC] text-[#C96F4A] focus:ring-[#C96F4A]">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit"
                        class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#292724] px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#403B36] focus:outline-none focus:ring-4 focus:ring-[#292724]/15">
                        Masuk ke PeopleCore
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
                        </svg>
                    </button>
                </form>

                {{-- Footer Note --}}
                <div class="mt-8 border-t border-[#EAE4DE] pt-5">
                    <div class="flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-[#A85435]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11V7m0 8h.01M5 11V7a7 7 0 0114 0v4m-14 0h14a2 2 0 012 2v6H3v-6a2 2 0 012-2z" />
                        </svg>
                        <p class="text-xs leading-5 text-[#89827B]">
                            Akses sistem hanya tersedia bagi pengguna yang memiliki akun terdaftar dan izin yang sesuai.
                        </p>
                    </div>

                    <p class="mt-6 text-center text-xs text-[#A39A91]">
                        PeopleCore HRIS · Portfolio Project
                    </p>
                </div>
            </div>
        </section>

        {{-- Right: Branding Panel --}}
        <aside
            class="relative hidden overflow-hidden bg-[#292724] lg:flex lg:min-h-screen lg:flex-col lg:justify-between lg:p-12 xl:p-16">

            {{-- Decorative Shapes --}}
            <div class="pointer-events-none absolute -right-28 -top-24 h-96 w-96 rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute -right-12 -top-8 h-64 w-64 rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-[#C96F4A]/10 blur-3xl">
            </div>

            <div class="relative z-10 flex items-center gap-2 text-sm font-medium tracking-[0.2em] text-white/60">
                <span class="h-2 w-2 rounded-full bg-[#C96F4A]"></span>
                PEOPLE <span class="text-[#C96F4A]">•</span> PROCESS <span class="text-[#C96F4A]">•</span> PERFORMANCE
            </div>

            <div class="relative z-10 my-12 max-w-xl">
                <div
                    class="mb-8 inline-flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.06] text-3xl font-bold text-[#E5A184]">
                    P
                </div>

                <h2 class="text-4xl font-bold leading-tight tracking-tight text-white xl:text-5xl">
                    Pengelolaan SDM yang
                    <span class="text-[#E5A184]">lebih terstruktur.</span>
                </h2>

                <p class="mt-6 max-w-lg text-base leading-8 text-white/60">
                    Satu sistem untuk membantu pengelolaan informasi karyawan, administrasi kehadiran,
                    pengajuan cuti, dan laporan sumber daya manusia secara lebih terorganisir.
                </p>

                {{-- Feature List --}}
                <div class="mt-10 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/[0.07] text-[#E5A184]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m6-10a4 4 0 100-8 4 4 0 000 8zm10 10v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                            </svg>
                        </span>
                        <span class="text-sm text-white/75">Data dan informasi karyawan</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/[0.07] text-[#E5A184]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                            </svg>
                        </span>
                        <span class="text-sm text-white/75">Administrasi kehadiran dan cuti</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/[0.07] text-[#E5A184]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 19V5m0 14h17M8 15l4-4 3 3 5-7" />
                            </svg>
                        </span>
                        <span class="text-sm text-white/75">Rekap dan laporan HR</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 flex items-center justify-between gap-4 border-t border-white/10 pt-6">
                <span class="text-xs text-white/40">
                    © {{ date('Y') }} PeopleCore
                </span>
                <span class="rounded-full border border-white/10 px-3 py-1.5 text-xs text-white/50">
                    HRIS · Portfolio Project
                </span>
            </div>
        </aside>
    </main>
@endsection
