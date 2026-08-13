<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AI Resume Builder - Professional, ATS-Friendly Resumes')</title>
    <meta name="description" content="Generate high-impact, ATS-optimized resumes in seconds with AI. Custom-tailored for students, fresh graduates, job seekers, and career changers.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Inter:wght@300..800&family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=JetBrains+Mono:wght@400..700&display=swap" rel="stylesheet">

    <!-- CSS & JS Assets (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for lightweight state management -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen antialiased flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Navbar -->
    <header class="no-print border-b border-slate-900 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400 group-hover:text-white transition-colors">
                        AI Resume Builder
                    </span>
                </a>
                <span class="text-xs px-2 py-0.5 rounded-full bg-slate-900 border border-slate-800 text-slate-400 font-medium">v2.0</span>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">
                    Dashboard
                </a>
                
                @auth
                    <span class="text-sm text-slate-400 font-medium border-l border-slate-800 pl-4">
                        {{ auth()->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-400 hover:text-red-400 transition-colors cursor-pointer">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors border-l border-slate-800 pl-4">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-medium px-3 py-1.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 shadow-md shadow-indigo-600/10 transition-all">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="no-print border-t border-slate-900 bg-slate-950 py-8 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} AI Resume Builder. Empowering Students, Fresh Graduates, Job Seekers, and Career Changers.</p>
            <p class="mt-2 text-slate-600">Built using Laravel, Tailwind CSS, AlpineJS, and Gemini API.</p>
        </div>
    </footer>

</body>
</html>
