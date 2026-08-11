<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SynapEd') }} – @yield('title', 'Dashboard LMS')</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🧠</text></svg>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    <style>
        :root {
            --app-bg: #F4F7FE;
            --card-surface: #FFFFFF;
            --text-heading: #1E293B;
            --text-body: #475569;
            --primary-blue: #2563EB;
        }

        body.lms-body {
            background-color: var(--app-bg) !important;
            color: var(--text-body);
            font-family: 'Poppins', 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .lms-content-full {
            flex: 1;
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 24px;
        }
    </style>
</head>
<body class="antialiased lms-body">

    {{-- Dashboard Navbar Component (styled matching landing page navbar) --}}
    <x-dashboard-navbar />

    {{-- Main Page Content --}}
    <main class="lms-content-full">
        {{-- Global Alert Notifier --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-base">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">✕</button>
            </div>
        @endif

        @if(isset($slot) && !empty((string)$slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    @stack('scripts')
</body>
</html>
