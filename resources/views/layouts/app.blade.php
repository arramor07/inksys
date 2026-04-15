<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>InkTech • Aronmovez Tattoo Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF for forms & AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Breeze / Vite assets (ok even if you don't use them much) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tailwind CDN for quick custom styling --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Century Gothic Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body, html, * {
            font-family: 'Century Gothic', 'Lato', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

/* Fix Chrome Autofill – make background stay dark */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0px 1000px #181818 inset !important;
    box-shadow: 0 0 0px 1000px #181818 inset !important;
    -webkit-text-fill-color: #e5e7eb !important;
    caret-color: #e5e7eb !important;
}


    </style>
</head>
<body class="bg-black text-slate-100">

    {{-- TOP NAVBAR --}}
    <header class="fixed inset-x-0 top-0 z-40">
        <nav class="backdrop-blur-md bg-black/30 border-b border-white/5">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                {{-- LOGO + BRAND --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-lg">
                        <span class="text-xs font-semibold tracking-tight">IT</span>
                    </div>
                    <span class="font-semibold tracking-wide text-sm md:text-base">
                        InkTech
                    </span>
                </a>

                {{-- NAV LINKS + AUTH --}}
                <div class="hidden md:flex items-center gap-8 text-sm">

                    {{-- MAIN LINKS --}}
                    <a href="{{ url('/') }}"
                       class="hover:text-red-400 transition
                              {{ request()->is('/') ? 'text-red-400 font-semibold' : 'text-slate-300' }}">
                        Home
                    </a>

                    <a href="{{ route('portfolio') }}"
                       class="hover:text-red-400 transition
                              {{ request()->is('portfolio') ? 'text-red-400 font-semibold' : 'text-slate-300' }}">
                        Portfolio
                    </a>

                    <a href="{{ route('book.create') }}"
                       class="hover:text-red-400 transition
                              {{ request()->is('book') ? 'text-red-400 font-semibold' : 'text-slate-300' }}">
                        Book
                    </a>

                    <a href="{{ route('contact') }}"
                       class="hover:text-red-400 transition
                              {{ request()->is('contact') ? 'text-red-400 font-semibold' : 'text-slate-300' }}">
                        Contact
                    </a>

                    <a href="{{ route('reviews.index') }}"
                       class="hover:text-red-400 transition
                              {{ request()->is('reviews') ? 'text-red-400 font-semibold' : 'text-slate-300' }}">
                        Reviews
                    </a>

                    {{-- AUTH AREA --}}
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'assistant_admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="hover:text-red-400 transition
                                      {{ request()->is('admin/*') ? 'text-red-400 font-semibold' : 'text-slate-300' }}">
                                Dashboard
                            </a>
                        @endif

                        <div class="flex items-center gap-3 pl-3 border-l border-slate-700">
                            <span class="text-xs text-slate-300">
                                {{ auth()->user()->name }}
                            </span>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-xs text-slate-300 hover:text-red-400 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                           class="text-xs px-3 py-1 rounded-full border border-slate-500 hover:border-red-500 hover:text-red-400 transition">
                            Log in
                        </a>
                    @endguest

                </div>
            </div>
        </nav>
    </header>

    {{-- MAIN CONTENT (has top padding because of fixed navbar) --}}
    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-black border-t border-white/5 text-center py-4 text-xs text-slate-400">
        © {{ date('Y') }} InkTech • All rights reserved.
    </footer>

</body>
</html>
