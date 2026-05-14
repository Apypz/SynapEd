<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">

            <a href="{{ route('home') }}" class="flex items-center group">
                <img src="{{ asset('images/logotextwhite.png') }}"
                    id="logo-white"
                    alt="SynapEd"
                    class="h-16 w-auto origin-left transform scale-150 -my-4 block">

                <img src="{{ asset('images/logotext.png') }}"
                    id="logo-dark"
                    alt="SynapEd"
                    class="h-16 w-auto origin-left transform scale-150 -my-4 hidden">
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#about" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200" style="color:#fff;">Tentang</a>
                <a href="#courses" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200" style="color:#fff;">Materi</a>
                <a href="#features" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200" style="color:#fff;">Keunggulan</a>
                <a href="#faq" class="public-nav-link nav-link-dynamic text-sm font-light tracking-wide transition-colors duration-200" style="color:#fff;">FAQ</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- Logged in state --}}
                    <a href="{{ route('dashboard') }}" class="nav-cta-dynamic flex items-center gap-2 px-4 py-2 text-sm font-semibold glass-card rounded-xl border transition-all duration-200" style="color:#fff; border-color:rgba(255,255,255,0.3);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Mulai Belajar
                    </a>
                @else
                    {{-- Guest state --}}
                    <a href="{{ route('login') }}" class="nav-cta-dynamic px-5 py-2.5 text-sm font-semibold transition-all duration-200">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="nav-cta-dynamic px-4 py-2 text-sm font-semibold glass-card rounded-xl border transition-all duration-200" style="color:#fff; border-color:rgba(255,255,255,0.3);">
                        Daftar Gratis
                    </a>
                @endauth
            </div>

            <div class="flex md:hidden items-center gap-2">
                <button id="mobile-menu-btn" class="nav-mobile-btn w-10 h-10 flex items-center justify-center rounded-xl glass-card border transition-colors" style="color:#fff; border-color:rgba(255,255,255,0.25);">
                    <svg id="menu-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    const navbar = document.getElementById('navbar');

    function applyNavbarScroll() {
        const links = document.querySelectorAll('.nav-link-dynamic');
        const ctas = document.querySelectorAll('.nav-cta-dynamic');
        const mobBtn = document.querySelector('.nav-mobile-btn');
        const logoWhite = document.getElementById('logo-white');
        const logoDark = document.getElementById('logo-dark');

        // KONDISI 1: Scroll sudah sangat jauh (Misal: Setelah bagian Stats)
        // Kita buat transparan kembali dengan teks putih
        if (window.scrollY > 850) {
            navbar.style.background = 'rgba(255, 255, 255, 0.1)'; // Background Putih
            navbar.style.backdropFilter = 'blur(10px) saturate(180%)';
            navbar.style.webkitBackdropFilter = 'blur(10px) saturate(180%)';
            navbar.style.borderBottom = '1px solid rgba(0, 0, 0, 0.08)';
            navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.05)';

            if (logoWhite) logoWhite.classList.replace('block', 'hidden');
            if (logoDark) logoDark.classList.replace('hidden', 'block');

            links.forEach(l => { l.style.setProperty('color', '#000000', 'important'); });
            ctas.forEach(c => {
                c.style.setProperty('color', '#000000', 'important');
                c.style.setProperty('border-color', 'rgba(0, 0, 0, 0.2)', 'important');
            });
            if (mobBtn) {
                mobBtn.style.setProperty('color', '#ffffff', 'important');
                mobBtn.style.setProperty('border-color', 'rgba(255, 255, 255, 0.2)', 'important');
            }
        }

        // KONDISI 2: Baru mulai scroll (Antara 20px sampai 850px)
        // Navbar jadi PUTIH SOLID/GLASS, Logo jadi HITAM (logotext.png)
        else if (window.scrollY > 20) {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)'; // Background Putih
            navbar.style.backdropFilter = 'blur(10px) saturate(180%)';
            navbar.style.webkitBackdropFilter = 'blur(10px) saturate(180%)';
            navbar.style.borderBottom = '1px solid rgba(0, 0, 0, 0.08)';
            navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.05)';

            // Switch ke Logo Dark (logotext.png)
            if (logoWhite) logoWhite.classList.replace('block', 'hidden');
            if (logoDark) logoDark.classList.replace('hidden', 'block');

            // Teks menjadi Hitam
            links.forEach(l => { l.style.setProperty('color', '#000000', 'important'); });
            ctas.forEach(c => {
                c.style.setProperty('color', '#000000', 'important');
                c.style.setProperty('border-color', 'rgba(0, 0, 0, 0.2)', 'important');
            });
            if (mobBtn) {
                mobBtn.style.setProperty('color', '#000000', 'important');
                mobBtn.style.setProperty('border-color', 'rgba(0, 0, 0, 0.1)', 'important');
            }
        }

        // KONDISI 3: Kembali ke posisi paling atas (Scroll < 20)
        else {
            navbar.style.background = 'transparent';
            navbar.style.backdropFilter = 'none';
            navbar.style.webkitBackdropFilter = 'none';
            navbar.style.borderBottom = 'none';
            navbar.style.boxShadow = 'none';

            if (logoWhite) logoWhite.classList.replace('hidden', 'block');
            if (logoDark) logoDark.classList.replace('block', 'hidden');

            links.forEach(l => { l.style.setProperty('color', '#ffffff', 'important'); });
            ctas.forEach(c => {
                c.style.setProperty('color', '#ffffff', 'important');
                c.style.setProperty('border-color', 'rgba(255, 255, 255, 0.3)', 'important');
                c.style.background = 'transparent';
            });
            if (mobBtn) {
                mobBtn.style.setProperty('color', '#ffffff', 'important');
                mobBtn.style.setProperty('border-color', 'rgba(255, 255, 255, 0.2)', 'important');
            }
        }
    }

    window.addEventListener('scroll', applyNavbarScroll);
    window.addEventListener('DOMContentLoaded', applyNavbarScroll);
</script>
@endpush
