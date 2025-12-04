<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>InkTech • Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- (Optional) You can remove this if Tailwind is already compiled via Vite --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body, html, * {
            font-family: 'Century Gothic', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
        }
    </style>
</head>
<body class="bg-[#050505] text-slate-100">
@php
    $role = auth()->user()->role ?? null;
@endphp

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="fixed top-0 left-0 w-72 h-screen bg-gradient-to-b from-[#0b0b0f] via-[#050508] to-black 
             border-r border-zinc-900/80 flex flex-col 
             py-6 px-5 shadow-[8px_0_30px_rgba(0,0,0,0.35)]">


    {{-- BRAND --}}
    <div class="mb-8 flex items-center gap-3 px-2">
        <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-[#ff2455] to-[#ff7b9b]
                    flex items-center justify-center shadow-lg shadow-[#ff2455]/40">
            <span class="text-xs font-black tracking-tight">IT</span>
        </div>
        <div class="flex flex-col leading-tight">
            <span class="text-xl font-extrabold tracking-wide text-white">InkTech</span>
            <span class="text-[11px] uppercase tracking-[0.16em] text-zinc-400">Admin Console</span>
        </div>
    </div>

    {{-- USER BADGE --}}
    <div class="mb-6 px-2">
        <div class="flex items-center justify-between text-xs">
            <span class="text-zinc-400">Signed in as</span>
            <span class="px-2 py-[2px] rounded-full text-[11px]
                {{ $role === 'admin'
                    ? 'bg-[#ff2455]/10 text-[#ff8aa4] border border-[#ff2455]/40'
                    : 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/40' }}">
                {{ strtoupper($role ?? 'USER') }}
            </span>
        </div>
        <div class="mt-1 text-sm font-semibold truncate text-slate-100">
            {{ auth()->user()->name ?? 'Admin' }}
        </div>
    </div>

    {{-- NAVIGATION (scrollable) + LOGOUT (fixed at bottom) --}}
    <div class="flex-1 flex flex-col min-h-0">

        {{-- NAV LINKS (scrollable area) --}}
        <nav class="flex-1 mt-2 space-y-1 text-sm overflow-y-auto pr-1">

            @php
                $linkBase = 'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-[13px]';
                $iconBase = 'w-4 h-4 shrink-0';
            @endphp

            {{-- Dashboard --}}
            @php $active = request()->routeIs('admin.dashboard'); @endphp
            <a href="{{ route('admin.dashboard') }}"
               class="{{ $linkBase }} {{ $active
                    ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                    : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                          d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-4.5h4.5V21H19.5V10.5" />
                </svg>
                <span>Dashboard</span>
                @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
            </a>

            {{-- Portfolio --}}
            @php $active = request()->routeIs('admin.portfolio'); @endphp
            <a href="{{ route('admin.portfolio') }}"
               class="{{ $linkBase }} {{ $active
                    ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                    : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                          d="M4 5h16M4 12h16M4 19h10" />
                </svg>
                <span>Portfolio Manager</span>
                @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
            </a>

            {{-- Bookings --}}
            @php $active = request()->routeIs('admin.bookings.*'); @endphp
            <a href="{{ route('admin.bookings.index') }}"
               class="{{ $linkBase }} {{ $active
                    ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                    : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                          d="M8 7V4m8 3V4M5 11h14M6 5h12a1 1 0 011 1v13H5V6a1 1 0 011-1z" />
                </svg>
                <span>Bookings</span>
                @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
            </a>

            {{-- Sales --}}
            @php $active = request()->routeIs('admin.sales.*'); @endphp
            <a href="{{ route('admin.sales.index') }}"
               class="{{ $linkBase }} {{ $active
                    ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                    : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                          d="M8 12h4m-4 4h8M9 2l.447 2.236A2 2 0 0011.383 6h1.234a2 2 0 001.936-1.764L15 2m4 4H5a2 2 0 00-2 2v12l3-1.5L9 20l3-1.5L15 20l3-1.5L21 20V8a2 2 0 00-2-2z" />
                </svg>
                <span>Sales</span>
                @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
            </a>

            {{-- REVIEWS (admin + assistant) --}}
            @if(in_array($role, ['admin','assistant_admin']))
                @php $active = request()->routeIs('admin.reviews.*'); @endphp
                <a href="{{ route('admin.reviews.index') }}"
                   class="{{ $linkBase }} {{ $active
                        ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                        : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M7 8h10M7 12h6M5 21l2-4h10a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h1" />
                    </svg>
                    <span>Client Reviews</span>
                    @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
                </a>
            @endif

            {{-- ADMIN ONLY --}}
            @if($role === 'admin')
                <p class="mt-5 mb-1 text-[11px] tracking-[0.18em] uppercase text-zinc-500 px-1">
                    Admin Management
                </p>

                {{-- Inventory --}}
                @php $active = request()->routeIs('admin.inventory.*'); @endphp
                <a href="{{ route('admin.inventory.index') }}"
                   class="{{ $linkBase }} {{ $active
                        ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                        : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M3 7l9-4 9 4-9 4-9-4zM3 13l9 4 9-4M3 17l9 4 9-4" />
                    </svg>
                    <span>Inventory</span>
                    @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
                </a>

                {{-- User Registrations --}}
                @php $active = request()->routeIs('admin.user-registrations.*'); @endphp
                <a href="{{ route('admin.user-registrations.index') }}"
                   class="{{ $linkBase }} {{ $active
                        ? 'bg-[#1b1b1f] text-white shadow-inner shadow-black/40 border border-zinc-700/70'
                        : 'text-slate-300 hover:bg-[#111118] hover:text-white border border-transparent' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M16 14a4 4 0 10-8 0m8 0v1a4 4 0 01-4 4m0 0a4 4 0 01-4-4v-1m4 5v1m-4-13a4 4 0 118 0 4 4 0 01-8 0z" />
                    </svg>
                    <span>User Registrations</span>
                    @if($active) <span class="ml-auto w-1.5 h-6 rounded-full bg-[#ff2455]"></span> @endif
                </a>
            @endif

        </nav>

        {{-- LOGOUT (fixed at bottom) --}}
        <div class="mt-4 border-t border-[#18181c] pt-4 shrink-0">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 text-[13px] text-[#ff4b5c] hover:text-white 
                               px-3 py-2 rounded-xl hover:bg-[#1a0b0d] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 12h9m0 0l-3 3m3-3l-3-3"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </div>

</aside>


    {{-- MAIN CONTENT --}}
    <main class="flex-1 bg-[#050505] ml-72">
        <div class="max-w-6xl mx-auto px-6 md:px-8 py-8">
            @yield('content')
        </div>
    </main>
</div>

@stack('scripts')


</body>
</html>
