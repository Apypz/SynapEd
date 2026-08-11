@php
    $authUser = Auth::check() ? (Auth::user()->fresh() ?? Auth::user()) : null;
@endphp
<nav class="sticky top-0 left-0 right-0 z-50 transition-all duration-300 font-['Poppins'] bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm" id="dashboard-navbar">
    <div class="max-w-7xl mx-auto px-6 py-3.5">
        <div class="flex items-center justify-between">
            
            {{-- Brand Logo matching Landing Page --}}
            <div class="w-1/4">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <img src="{{ asset('images/logotext.png') }}" alt="SynapEd" class="h-14 w-auto origin-left transform scale-125 -my-3 block">
                </a>
            </div>

            {{-- Center Nav Links matching Landing Page typography --}}
            <div class="hidden md:flex flex-1 justify-center items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-slate-700 hover:text-blue-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('courses.index') }}" class="text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('courses.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-slate-700 hover:text-blue-600' }}">
                    Katalog Kursus
                </a>
                @if($authUser && $authUser->role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold tracking-wide transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600 pb-1' : 'text-slate-700 hover:text-blue-600' }}">
                        Manajemen User
                    </a>
                @endif
                <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide transition-colors duration-200 text-slate-700 hover:text-blue-600">
                    Landing Page
                </a>
            </div>

            {{-- User Profile Menu Pill with CLICK Dropdown --}}
            <div class="hidden md:flex w-1/4 justify-end items-center gap-3">
                @auth
                <div class="relative" id="profile-dropdown-container">
                    <button type="button" id="profile-dropdown-trigger" class="flex items-center gap-3 p-1.5 pl-3.5 rounded-2xl hover:bg-slate-200/80 border border-slate-200 cursor-pointer transition-all focus:outline-none select-none">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-900 leading-tight">{{ $authUser->name ?? 'User' }}</p>
                            <span class="inline-block px-0 py-0.5 text-[9px] font-extrabold rounded-full uppercase tracking-wider text-blue-700">
                                {{ $authUser->role ?? 'Student' }}
                            </span>
                        </div>

                        {{-- User Avatar Image or Fallback Letter --}}
                        <div class="w-9 h-9 rounded-xl overflow-hidden bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-sm font-extrabold shadow-md flex-shrink-0">
                            @if($authUser && $authUser->avatar)
                                <img src="{{ $authUser->avatar }}" alt="{{ $authUser->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="images/profil.jpg" alt="Profil User" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" id="profile-dropdown-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    {{-- Profile Dropdown Menu (Opened on CLICK) --}}
                    <div id="profile-dropdown-menu" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 hidden z-50 transition-all">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        @if($authUser && $authUser->role === 'admin')
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                Manajemen User
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>

            {{-- Mobile Menu Trigger --}}
            <div class="flex md:hidden items-center gap-2">
                <button id="dash-mobile-menu-btn" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 border border-slate-200 text-slate-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Dropdown Menu --}}
    <div id="dash-mobile-menu" class="hidden md:hidden bg-white border-t border-slate-200 p-6 flex-col gap-3 shadow-xl">
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-800 py-2">Dashboard</a>
        <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-slate-800 py-2">Katalog Kursus</a>
        @if($authUser && $authUser->role === 'admin')
            <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-slate-800 py-2">Manajemen User</a>
        @endif
        <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-800 py-2">Landing Page</a>
        <hr class="border-slate-100">
        <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-slate-800 py-2">Profil Saya</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left text-sm font-semibold text-rose-600 py-2">Keluar</button>
        </form>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    const mobBtn = document.getElementById('dash-mobile-menu-btn');
    const mobMenu = document.getElementById('dash-mobile-menu');
    if (mobBtn && mobMenu) {
        mobBtn.addEventListener('click', () => {
            mobMenu.classList.toggle('hidden');
            mobMenu.classList.toggle('flex');
        });
    }

    // Profile Dropdown CLICK toggle logic
    const trigger = document.getElementById('profile-dropdown-trigger');
    const dropdown = document.getElementById('profile-dropdown-menu');
    const arrow = document.getElementById('profile-dropdown-arrow');
    const container = document.getElementById('profile-dropdown-container');

    if (trigger && dropdown) {
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = !dropdown.classList.contains('hidden');
            if (isOpen) {
                dropdown.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            } else {
                dropdown.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (container && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });
    }
});
</script>
