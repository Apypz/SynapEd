<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center group">
                <img src="{{ asset('images/logotext.png') }}" alt="NeuroAcademy" class="h-14 w-auto group-hover:scale-105 transition-transform duration-200">
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#about" class="public-nav-link nav-link-dynamic text-sm font-medium transition-colors duration-200" style="color:#fff;">Tentang</a>
                <a href="#courses" class="public-nav-link nav-link-dynamic text-sm font-medium transition-colors duration-200" style="color:#fff;">Materi</a>
                <a href="#features" class="public-nav-link nav-link-dynamic text-sm font-medium transition-colors duration-200" style="color:#fff;">Keunggulan</a>
                <a href="#faq" class="public-nav-link nav-link-dynamic text-sm font-medium transition-colors duration-200" style="color:#fff;">FAQ</a>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- Logged in: show Dashboard link + user avatar --}}
                    <a href="{{ route('dashboard') }}" class="nav-cta-dynamic flex items-center gap-2 px-4 py-2 text-sm font-semibold glass-card rounded-xl transition-all duration-200" style="color:#fff; border-color:rgba(255,255,255,0.25);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold btn-gradient">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-44 rounded-xl shadow-xl py-1 z-50 nav-profile-dropdown" style="background:#fff; border:1px solid rgba(12,119,121,0.15);">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm transition-colors" style="color:#1A4A52;" onmouseover="this.style.background='rgba(12,119,121,0.06)';this.style.color='#005461';" onmouseout="this.style.background='transparent';this.style.color='#1A4A52';">Profil Saya</a>
                            <hr style="border-color:rgba(12,119,121,0.1);" class="my-1" />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm transition-colors" style="color:#DC2626;" onmouseover="this.style.background='rgba(220,38,38,0.06)';" onmouseout="this.style.background='transparent';">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest: Login + Register --}}
                    <a href="{{ route('login') }}" class="nav-cta-dynamic px-4 py-2 text-sm font-semibold glass-card rounded-xl transition-all duration-200" style="color:#fff; border-color:rgba(255,255,255,0.25);">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl btn-gradient glow-blue transition-all duration-200">
                        Mulai Belajar
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="flex md:hidden items-center gap-2">
                <button id="mobile-menu-btn" class="nav-mobile-btn w-10 h-10 flex items-center justify-center rounded-xl glass-card transition-colors" style="color:#fff; border-color:rgba(255,255,255,0.2);">
                    <svg id="menu-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="close-icon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 bg-white/95 backdrop-blur-xl rounded-2xl p-5 border border-teal-100 shadow-lg">
            <div class="flex flex-col gap-4">
                <a href="#about" class="public-nav-link text-slate-700 text-sm font-medium transition-colors mobile-link">Tentang</a>
                <a href="#courses" class="public-nav-link text-slate-700 text-sm font-medium transition-colors mobile-link">Materi</a>
                <a href="#features" class="public-nav-link text-slate-700 text-sm font-medium transition-colors mobile-link">Keunggulan</a>
                <a href="#faq" class="public-nav-link text-slate-700 text-sm font-medium transition-colors mobile-link">FAQ</a>
                <hr class="border-slate-200" />
                @auth
                    <a href="{{ route('dashboard') }}" class="mobile-link text-center px-5 py-2.5 text-sm font-semibold text-white rounded-xl btn-gradient transition-all duration-200">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="mobile-link text-center px-5 py-2.5 text-sm font-semibold text-slate-700 rounded-xl border border-slate-200 hover:border-teal-300 transition-all duration-200">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="mobile-link text-center px-5 py-2.5 text-sm font-semibold text-white rounded-xl btn-gradient transition-all duration-200">
                        Mulai Belajar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // ── Navbar scroll effect ──────────────────────────────────
    const navbar = document.getElementById('navbar');
    function applyNavbarScroll() {
        const links = document.querySelectorAll('.nav-link-dynamic');
        const ctas  = document.querySelectorAll('.nav-cta-dynamic');
        const mobBtn = document.querySelector('.nav-mobile-btn');

        if (window.scrollY > 20) {
            navbar.classList.add('nav-scrolled');
            navbar.style.background    = 'rgba(255, 255, 255, 0.96)';
            navbar.style.backdropFilter = 'blur(20px)';
            navbar.style.webkitBackdropFilter = 'blur(20px)';
            navbar.style.borderBottom  = '1px solid rgba(12,119,121,0.1)';
            navbar.style.boxShadow     = '0 1px 16px rgba(0,0,0,0.06)';
            // Dark text on white bg
            links.forEach(l => { l.style.color = ''; l.style.color = 'var(--text-h)'; });
            ctas.forEach(c => { c.style.color = 'var(--text-h)'; c.style.borderColor = 'rgba(12,119,121,0.2)'; });
            if (mobBtn) { mobBtn.style.color = 'var(--text-h)'; mobBtn.style.borderColor = 'rgba(12,119,121,0.15)'; }
        } else {
            navbar.classList.remove('nav-scrolled');
            navbar.style.background    = 'transparent';
            navbar.style.backdropFilter = 'none';
            navbar.style.webkitBackdropFilter = 'none';
            navbar.style.borderBottom  = 'none';
            navbar.style.boxShadow     = 'none';
            // White text on dark hero
            links.forEach(l => { l.style.color = '#fff'; });
            ctas.forEach(c => { c.style.color = '#fff'; c.style.borderColor = 'rgba(255,255,255,0.25)'; });
            if (mobBtn) { mobBtn.style.color = '#fff'; mobBtn.style.borderColor = 'rgba(255,255,255,0.2)'; }
        }
    }
    window.addEventListener('scroll', applyNavbarScroll);
    applyNavbarScroll();

    // ── Mobile menu ──────────────────────────────────────────
    const btn       = document.getElementById('mobile-menu-btn');
    const menu      = document.getElementById('mobile-menu');
    const menuIcon  = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });

    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.add('hidden');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        });
    });
</script>
@endpush
