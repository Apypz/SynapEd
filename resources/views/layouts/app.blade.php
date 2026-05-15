<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NeuroAcademy') }} – @yield('title', 'Platform LMS')</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🧠</text></svg>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="antialiased font-sans lms-body">

{{-- ── Sidebar ──────────────────────────────────────────────── --}}
<aside id="lms-sidebar" class="lms-sidebar">
    {{-- Logo --}}
    <div class="lms-sidebar-logo">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logotextwhite.png') }}" alt="NeuroAcademy" class="w-20">
        </a>
    </div>

    {{-- Nav --}}
    <nav class="lms-nav">
        <p class="lms-nav-label">Menu</p>
        <a href="{{ route('dashboard') }}" class="lms-nav-link {{ request()->routeIs('dashboard') ? 'lms-nav-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('courses.index') }}" class="lms-nav-link {{ request()->routeIs('courses.*') ? 'lms-nav-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>Jelajahi Kursus</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="lms-nav-link {{ request()->routeIs('profile.*') ? 'lms-nav-link-active' : '' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Profil Saya</span>
        </a>
    </nav>

    {{-- User card --}}
    <div class="lms-sidebar-user">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background:linear-gradient(135deg,#0C7779,#5ECED0);">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-slate-500 text-xs truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 text-slate-400 hover:text-red-400 text-sm transition-colors duration-200 py-2 px-3 rounded-lg hover:bg-red-500/10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ── Mobile overlay --}}
<div id="sidebar-overlay" class="lms-sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ── Main content ─────────────────────────────────────────── --}}
<div class="lms-main">
    {{-- Top bar --}}
    <header class="lms-topbar">
        <button onclick="toggleSidebar()" class="lms-menu-btn lg:hidden">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div class="flex-1">
            @isset($header)<h1 class="text-white font-bold text-lg" style="font-family:var(--font-heading);">{{ $header }}</h1>@endisset
        </div>
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-white text-sm transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Beranda
        </a>
    </header>

    <main class="lms-content">
        {{ $slot }}
    </main>
</div>

<script>
function toggleSidebar() {
    const s = document.getElementById('lms-sidebar');
    const o = document.getElementById('sidebar-overlay');
    s.classList.toggle('open');
    o.classList.toggle('open');
}
function closeSidebar() {
    document.getElementById('lms-sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('open');
}
</script>

@stack('scripts')
</body>
</html>
