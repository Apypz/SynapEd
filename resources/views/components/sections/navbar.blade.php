<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 font-['Poppins']" id="navbar">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="w-1/4">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <img src="{{ asset('images/logotextwhite.png') }}" id="logo-white" alt="SynapEd" class="h-16 w-auto origin-left transform scale-150 -my-4 block">
                    <img src="{{ asset('images/logotext.png') }}" id="logo-dark" alt="SynapEd" class="h-16 w-auto origin-left transform scale-150 -my-4 hidden">
                </a>
            </div>

            <div class="hidden md:flex flex-1 justify-center items-center gap-8">
                <a href="#about" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200">Tentang</a>
                <a href="#courses" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200">Materi</a>
                <a href="#features" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200">Keunggulan</a>
                <a href="#faq" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200">FAQ</a>
            </div>

            <div class="hidden md:flex w-1/4 justify-end items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-cta-dynamic flex items-center gap-2 px-4 py-2 text-sm font-semibold glass-card rounded-xl border transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Mulai Belajar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-cta-dynamic px-5 py-2.5 text-sm font-semibold transition-all duration-200">Masuk</a>
                    <a href="{{ route('register') }}" class="nav-cta-dynamic px-4 py-2 text-sm font-semibold glass-card rounded-xl border transition-all duration-200">Daftar Gratis</a>
                @endauth
            </div>

            <div class="flex md:hidden items-center gap-2">
                <button id="mobile-menu-btn" class="nav-mobile-btn w-10 h-10 flex items-center justify-center rounded-xl glass-card border transition-colors">
                    <svg id="menu-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path id="path-open" class="block" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="path-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 shadow-xl border-t border-gray-100 flex-col p-6 gap-4 transition-all duration-300">
        <a href="#about" class="mobile-link-dynamic text-lg font-medium mobile-link">Tentang</a>
        <a href="#courses" class="mobile-link-dynamic text-lg font-medium mobile-link">Materi</a>
        <a href="#features" class="mobile-link-dynamic text-lg font-medium mobile-link">Keunggulan</a>
        <a href="#faq" class="mobile-link-dynamic text-lg font-medium mobile-link">FAQ</a>
        <hr class="border-gray-100 my-2">
        @auth
            <a href="{{ route('dashboard') }}" class="w-full text-center py-3 bg-indigo-600 text-white rounded-xl font-semibold">Mulai Belajar</a>
        @else
            <a href="{{ route('login') }}" class="w-full text-center py-3 mobile-link-dynamic font-semibold border border-gray-200 rounded-xl">Masuk</a>
            <a href="{{ route('register') }}" class="w-full text-center py-3 bg-indigo-600 text-white rounded-xl font-semibold">Daftar Gratis</a>
        @endauth
    </div>
</nav>

@push('scripts')
<script>
    const navbar = document.getElementById('navbar');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const pathOpen = document.getElementById('path-open');
    const pathClose = document.getElementById('path-close');

    mobileMenuBtn.addEventListener('click', () => {
        const isOpen = !mobileMenu.classList.contains('hidden');
        if (isOpen) {
            mobileMenu.classList.replace('flex', 'hidden');
            pathOpen.classList.replace('hidden', 'block');
            pathClose.classList.replace('block', 'hidden');
        } else {
            mobileMenu.classList.replace('hidden', 'flex');
            pathOpen.classList.replace('block', 'hidden');
            pathClose.classList.replace('hidden', 'block');
        }
    });

    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.replace('flex', 'hidden');
            pathOpen.classList.replace('hidden', 'block');
            pathClose.classList.replace('block', 'hidden');
        });
    });

    function applyNavbarScroll() {
        const body = document.body;
        const links = document.querySelectorAll('.nav-link-dynamic');
        const ctas = document.querySelectorAll('.nav-cta-dynamic');
        const mobileLinks = document.querySelectorAll('.mobile-link-dynamic');
        const mobBtn = document.querySelector('.nav-mobile-btn');
        const logoWhite = document.getElementById('logo-white');
        const logoDark = document.getElementById('logo-dark');
        const scrollY = window.scrollY;
        const forceLightNav = body.classList.contains('page-light-nav');

        if (forceLightNav) {
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
            navbar.style.backdropFilter = 'blur(10px) saturate(180%)';
            navbar.style.borderBottom = '1px solid rgba(0, 0, 0, 0.08)';
            mobileMenu.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';

            if (logoWhite) logoWhite.classList.replace('block', 'hidden');
            if (logoDark) logoDark.classList.replace('hidden', 'block');

            links.forEach(l => { l.style.setProperty('color', '#000000', 'important'); });
            mobileLinks.forEach(ml => { ml.style.setProperty('color', '#000000', 'important'); });

            if (mobBtn) {
                mobBtn.style.setProperty('color', '#000000', 'important');
                mobBtn.style.borderColor = 'rgba(0,0,0,0.1)';
            }

            return;
        }

        if (scrollY > 20) {
            // --- STATE: SCROLLED (PC & MOBILE) ---
            const isWhiteBg = scrollY <= 850;

            navbar.style.backgroundColor = isWhiteBg ? 'rgba(255, 255, 255, 0.95)' : 'rgba(255, 255, 255, 0.1)';
            navbar.style.backdropFilter = 'blur(10px) saturate(180%)';
            navbar.style.borderBottom = '1px solid rgba(0, 0, 0, 0.08)';
            mobileMenu.style.backgroundColor = isWhiteBg ? 'rgba(255, 255, 255, 0.95)' : 'rgba(255, 255, 255, 0.8)';

            // Pastikan logo gelap muncul
            if (logoWhite) logoWhite.classList.replace('block', 'hidden');
            if (logoDark) logoDark.classList.replace('hidden', 'block');

            // PAKSA SEMUA TEKS JADI HITAM (#000000)
            links.forEach(l => { l.style.setProperty('color', '#000000', 'important'); });
            mobileLinks.forEach(ml => { ml.style.setProperty('color', '#000000', 'important'); });
            ctas.forEach(c => {
                c.style.setProperty('color', '#000000', 'important');
                c.style.borderColor = 'rgba(0,0,0,0.2)';
            });

            if (mobBtn) {
                mobBtn.style.setProperty('color', '#000000', 'important');
                mobBtn.style.borderColor = 'rgba(0,0,0,0.1)';
            }
        } else {
            // --- STATE: TOP (PC TRANSPARENT, MOBILE WHITE) ---
            const isMobile = window.innerWidth < 768;

            if (isMobile) {
                navbar.style.backgroundColor = '#ffffff';
                navbar.style.borderBottom = '1px solid rgba(0, 0, 0, 0.05)';
                mobileMenu.style.backgroundColor = '#ffffff';

                if (logoWhite) logoWhite.classList.replace('block', 'hidden');
                if (logoDark) logoDark.classList.replace('hidden', 'block');

                links.forEach(l => { l.style.setProperty('color', '#000000', 'important'); });
                mobileLinks.forEach(ml => { ml.style.setProperty('color', '#000000', 'important'); });
                ctas.forEach(c => {
                    c.style.setProperty('color', '#000000', 'important');
                    c.style.borderColor = 'rgba(0,0,0,0.1)';
                });
            } else {
                // Desktop Top: Transparan (Baru di sini teks jadi Putih)
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
                navbar.style.borderBottom = 'none';

                if (logoWhite) logoWhite.classList.replace('hidden', 'block');
                if (logoDark) logoDark.classList.replace('block', 'hidden');

                links.forEach(l => { l.style.setProperty('color', '#ffffff', 'important'); });
                ctas.forEach(c => {
                    c.style.setProperty('color', '#ffffff', 'important');
                    c.style.borderColor = 'rgba(255,255,255,0.3)';
                    c.style.background = 'transparent';
                });
            }
        }
    }

    window.addEventListener('scroll', applyNavbarScroll);
    window.addEventListener('resize', applyNavbarScroll);
    window.addEventListener('DOMContentLoaded', applyNavbarScroll);
</script>
@endpush
