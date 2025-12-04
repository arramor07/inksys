@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-black via-[#141414] to-black min-h-[calc(100vh-4rem)] flex items-center justify-center py-10">
    <div class="w-full max-w-md px-4">
        <div class="bg-[#101010]/95 border border-black/40 rounded-[26px] shadow-[0_25px_60px_rgba(0,0,0,0.85)] px-8 py-10">

            {{-- Logo / Brand --}}
            <div class="flex flex-col items-center mb-6">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-lg mb-3">
                    <span class="text-xs font-semibold tracking-tight">IT</span>
                </div>
                <h1 class="text-xl font-extrabold text-white">Login</h1>
                <p class="text-xs text-slate-400 mt-1">
                    Sign in to your InkTech account.
                </p>
            </div>

            {{-- SESSION STATUS --}}
            @if (session('status'))
                <div class="mb-4 text-xs text-emerald-300 bg-emerald-500/10 border border-emerald-500/40 px-3 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="mb-4 text-xs text-red-300 bg-red-500/10 border border-red-500/40 px-3 py-2 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- LOGIN FORM --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-1">
                        Email
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           class="w-full px-4 py-2.5 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                           placeholder="you@example.com">
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 mb-1">
                        Password
                    </label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="w-full px-4 py-2.5 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                           placeholder="••••••••">
                </div>

                {{-- REMEMBER + FORGOT --}}
                <div class="flex items-center justify-between text-xs text-slate-400 mt-1">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox"
                               name="remember"
                               class="rounded border-[#444] bg-[#181818] text-red-500 focus:ring-red-500/70">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="hover:text-red-400">
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full px-6 py-3 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-sm font-semibold text-white shadow-[0_10px_30px_rgba(255,0,0,0.45)] hover:brightness-110 transition">
                        Sign in
                    </button>
                </div>
            </form>

            {{-- REGISTER LINK --}}
            @if (Route::has('register'))
                <p class="mt-5 text-[11px] text-center text-slate-400">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-red-400 font-semibold hover:text-red-300">
                        Register here
                    </a>
                </p>
            @endif
        </div>
    </div>
</section>
@endsection
