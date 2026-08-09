<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SynapEd') }}</title>

    <link rel="icon" type="images/logo.png" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans" style="background-color:#EFF7F7;">

    <div class="min-h-screen relative flex items-center justify-center p-4" style="background:linear-gradient(135deg,#c1c8ff 0%,#ccd2e0 40%,#b8c1d2 75%,#cad6eb 100%);">

        {{-- Subtle teal blobs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-96 h-96 -top-20 -left-20 rounded-full opacity-40" style="background:radial-gradient(circle,#CCDFE0 0%,transparent 70%);filter:blur(60px);"></div>
            <div class="absolute w-96 h-96 -bottom-20 -right-20 rounded-full opacity-40" style="background:radial-gradient(circle,#0c2979 0%,transparent 70%);filter:blur(60px);"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="flex flex-col items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center h-19 group">
                        <img src="{{ asset('images/logotext.png') }}"
                            alt="NeuroAcademy"
                            class="h-20 w-auto transform scale-[1.8] origin-center transition-transform duration-300 group-hover:scale-[2.0]">
                    </a>
                </div>
            </div>

            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-md rounded-2xl p-8 border border-[rgba(12,119,121,0.12)] shadow-md shadow-[rgba(12,119,121,0.06)]">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
