<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - PeopleCore</title>

    <meta name="theme-color" content="#303431">
    <meta name="description" content="PeopleCore - Human Resource Information System">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @auth
        @php
            $user = auth()->user();

            $navLinkClass = 'sidebar-link';
            $activeClass = 'active';

            $isAdminOrHr = in_array($user->role, ['admin', 'hr']);
            $isAdmin = $user->role === 'admin';
            $isHr = $user->role === 'hr';
            $isEmployee = $user->role === 'employee';
        @endphp

        <div class="app-shell">
            <aside class="sidebar">
                <a href="{{ route('dashboard') }}" class="brand">
                    <span class="brand-mark">
                        <svg viewBox="0 0 32 32" fill="none" aria-hidden="true">
                            <path d="M8 24V8h5l6 8V8h5v16h-5l-6-8v8H8Z" fill="currentColor" />
                            <circle cx="24" cy="8" r="3" fill="#E7A18B" />
                        </svg>
                    </span>

                    <span class="brand-copy">
                        <strong>PeopleCore</strong>
                        <small>Human Resources</small>
                    </span>
                </a>

                <div class="sidebar-scroll">
                    <div class="sidebar-label">WORKSPACE</div>

                    <nav class="sidebar-nav" aria-label="Navigasi utama">
                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? $activeClass : $navLinkClass }}">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="3" y="3" width="8" height="8" rx="2" />
                                <rect x="13" y="3" width="8" height="5" rx="2" />
                                <rect x="13" y="10" width="8" height="11" rx="2" />
                                <rect x="3" y="13" width="8" height="8" rx="2" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </nav>

                    @if ($isAdminOrHr)
                        <div class="sidebar-label">MANAJEMEN SDM</div>

                        <nav class="sidebar-nav" aria-label="Manajemen SDM">
                            <a href="{{ route('employees.index') }}"
                                class="{{ request()->routeIs('employees.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="10" cy="7" r="4" />
                                    <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <span>Data Karyawan</span>
                            </a>

                            <a href="{{ route('attendances.index') }}"
                                class="{{ request()->routeIs('attendances.*') || request()->routeIs('my.attendances.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M16 3v4M8 3v4M3 10h18M8 14h3M8 17h7" />
                                </svg>
                                <span>Absensi</span>
                            </a>

                            <a href="{{ route('reports.attendance') }}"
                                class="{{ request()->routeIs('reports.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 19V5M4 19h17" />
                                    <path d="m7 15 4-4 3 2 6-7" />
                                    <circle cx="20" cy="6" r="1" />
                                </svg>
                                <span>Laporan HR</span>
                            </a>

                            <a href="{{ route('leave-balances.index') }}"
                                class="{{ request()->routeIs('leave-balances.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                                <span>Saldo dan Kuota Cuti</span>
                            </a>

                            @if ($isHr)
                                <a href="{{ route('leave-approvals.index') }}"
                                    class="{{ request()->routeIs('leave-approvals.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M8 3h8l4 4v14H4V3h4" />
                                        <path d="M14 3v5h6M8 13h8M8 17h5" />
                                        <path d="m8 9 1.5 1.5L12 8" />
                                    </svg>
                                    <span>Persetujuan Cuti</span>
                                </a>
                            @endif
                        </nav>
                    @endif

                    @if ($isAdmin)
                        <div class="sidebar-label">PENGATURAN</div>

                        <nav class="sidebar-nav" aria-label="Pengaturan sistem">
                            <a href="{{ route('users.index') }}"
                                class="{{ request()->routeIs('users.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <circle cx="9" cy="8" r="3.5" />
                                    <path d="M3 20v-2a6 6 0 0 1 12 0v2M18 8v6M15 11h6" />
                                </svg>
                                <span>Manajemen Akun</span>
                            </a>

                            <a href="{{ route('departments.index') }}"
                                class="{{ request()->routeIs('departments.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="7" width="18" height="14" rx="2" />
                                    <path d="M9 7V4h6v3M3 12h18M10 12v2h4v-2" />
                                </svg>
                                <span>Departemen</span>
                            </a>

                            <a href="{{ route('positions.index') }}"
                                class="{{ request()->routeIs('positions.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="16" rx="2" />
                                    <path d="M8 9h8M8 13h5M8 17h3" />
                                </svg>
                                <span>Jabatan</span>
                            </a>

                            <a href="{{ route('leave-types.index') }}"
                                class="{{ request()->routeIs('leave-types.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M7 3h10l4 4v14H3V3h4Z" />
                                    <path d="M14 3v5h7M8 13h8M8 17h5" />
                                </svg>
                                <span>Jenis Cuti</span>
                            </a>
                        </nav>
                    @endif

                    @if ($isEmployee)
                        <div class="sidebar-label">AREA KARYAWAN</div>

                        <nav class="sidebar-nav" aria-label="Menu karyawan">
                            <a href="{{ route('my.attendances.index') }}"
                                class="{{ request()->routeIs('my.attendances.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M16 3v4M8 3v4M3 10h18M8 14h3" />
                                </svg>
                                <span>Riwayat Absensi Saya</span>
                            </a>

                            <a href="{{ route('my.leave-requests.index') }}"
                                class="{{ request()->routeIs('my.leave-requests.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M7 3h10l4 4v14H3V3h4Z" />
                                    <path d="M14 3v5h7M8 14l2 2 5-5" />
                                </svg>
                                <span>Pengajuan Cuti Saya</span>
                            </a>

                            <a href="{{ route('my.leave-balances.index') }}"
                                class="{{ request()->routeIs('my.leave-balances.*') ? 'sidebar-link active' : 'sidebar-link' }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                                <span>Saldo Cuti Saya</span>
                            </a>
                        </nav>
                    @endif
                </div>

                <div class="sidebar-bottom">
                    <div class="sidebar-help">
                        <span class="help-icon">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M9.5 9a2.5 2.5 0 1 1 4.2 1.8c-1.2 1-1.7 1.4-1.7 3" />
                                <path d="M12 17h.01" />
                            </svg>
                        </span>
                        <span>
                            <strong>PeopleCore HRIS</strong>
                            <small>Sistem informasi kepegawaian</small>
                        </span>
                    </div>

                    <div class="sidebar-footer">
                        <span class="avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>

                        <div class="user-summary">
                            <strong>{{ $user->name }}</strong>
                            <small>
                                @switch($user->role)
                                    @case('admin')
                                        Administrator
                                    @break

                                    @case('hr')
                                        Human Resources
                                    @break

                                    @default
                                        Karyawan
                                @endswitch
                            </small>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="logout-button" type="submit" title="Keluar" aria-label="Keluar">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M10 17l5-5-5-5M15 12H3" />
                                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <main class="main-content">
                <header class="topbar">
                    <div class="topbar-heading">
                        <div class="breadcrumb">
                            <span>PeopleCore</span>
                            <span class="breadcrumb-separator">/</span>
                            <span>@yield('heading', trim($__env->yieldContent('title', 'Dashboard')))</span>
                        </div>

                        <h1>@yield('heading', 'Dashboard')</h1>
                        <p class="topbar-subtitle">
                            Kelola informasi dan aktivitas kepegawaian dalam satu tempat.
                        </p>
                    </div>

                    <div class="topbar-actions">
                        <div class="topbar-date">
                            <span class="topbar-date-icon">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M16 3v4M8 3v4M3 10h18" />
                                </svg>
                            </span>
                            <span>{{ now()->locale('id')->translatedFormat('d M Y') }}</span>
                        </div>

                        <div class="topbar-profile">
                            <span class="avatar avatar-small">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <small>{{ strtoupper($user->role) }}</small>
                            </div>
                        </div>
                    </div>
                </header>

                <section class="page-content">
                    @if (session('success'))
                        <div class="alert alert-success" role="status">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="m5 12 4 4L19 6" />
                                <circle cx="12" cy="12" r="9" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error" role="alert">
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </section>

                <footer class="app-footer">
                    <span>© {{ date('Y') }} PeopleCore</span>
                    <span>Human Resource Information System</span>
                </footer>
            </main>
        </div>
    @else
        @yield('guest-content')
    @endauth

    @stack('scripts')
</body>

</html>
