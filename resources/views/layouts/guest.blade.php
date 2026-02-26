<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NeuroAcademy') }}</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🧠</text></svg>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans" style="background-color:#EFF7F7;">

    <div class="min-h-screen relative flex items-center justify-center p-4" style="background:linear-gradient(135deg,#EFF7F7 0%,#CCDFE0 40%,#B8D1D2 75%,#CCDFE0 100%);">

        {{-- Subtle teal blobs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-96 h-96 -top-20 -left-20 rounded-full opacity-40" style="background:radial-gradient(circle,#CCDFE0 0%,transparent 70%);filter:blur(60px);"></div>
            <div class="absolute w-96 h-96 -bottom-20 -right-20 rounded-full opacity-40" style="background:radial-gradient(circle,#0C7779 0%,transparent 70%);filter:blur(60px);"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center group">
                    <img src="{{ asset('images/logotext.png') }}" alt="NeuroAcademy" class="h-12 w-auto group-hover:scale-105 transition-transform duration-200">
                </a>
                <p class="text-[#4A7A82] text-sm mt-2">Platform Pembelajaran Neuroscience & EEG</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-md rounded-2xl p-8 border border-[rgba(12,119,121,0.12)] shadow-md shadow-[rgba(12,119,121,0.06)]">
                {{ $slot }}
            </div>

            {{-- Back to home --}}
            <p class="text-center text-[#4A7A82] text-sm mt-6">
                <a href="{{ route('home') }}" class="hover:text-[#0C7779] transition-colors">← Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</body>
</html>
