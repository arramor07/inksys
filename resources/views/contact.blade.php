@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-6 py-16">
    <div class="max-w-6xl w-full flex flex-col md:flex-row md:items-start gap-12">

        {{-- LEFT: Contact info + socials --}}
        <div class="w-full md:w-1/2">
            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-500/10 border border-emerald-500/40 px-4 py-3 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
                Contact Us
            </h2>

            <ul class="space-y-2 text-sm md:text-base text-slate-200 mb-6">
                <li class="flex items-center gap-2">
                    <span class="text-pink-500">📍</span>
                    <span>Address: Del Razon, Pinamalayan, Oriental Mindoro</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-pink-500">📞</span>
                    <span>Phone: 09677593505</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-pink-500">📧</span>
                    <span>Email: arramor07@gmail.com</span>
                </li>
            </ul>

            <div class="flex flex-wrap gap-3">
                <a href="https://www.facebook.com/profile.php?id=61574685124414"
                   target="_blank" rel="noopener"
                   class="px-6 py-2 rounded-full bg-[#101018] text-sm text-slate-100
                          hover:bg-[#181824] transition shadow-[0_10px_30px_rgba(0,0,0,0.6)]">
                    Facebook
                </a>

                <a href="https://www.instagram.com/aaronsiena?igsh=MTEwaTN1Z2IxaGZ6ag=="
                   target="_blank" rel="noopener"
                   class="px-6 py-2 rounded-full bg-[#101018] text-sm text-slate-100
                          hover:bg-[#181824] transition shadow-[0_10px_30px_rgba(0,0,0,0.6)]">
                    Instagram
                </a>

                <a href="https://www.tiktok.com/@kanto_tinta0?_r=1&_t=ZS-91j9O5Kk7cK"
                   target="_blank" rel="noopener"
                   class="px-6 py-2 rounded-full bg-[#101018] text-sm text-slate-100
                          hover:bg-[#181824] transition shadow-[0_10px_30px_rgba(0,0,0,0.6)]">
                    TikTok
                </a>
            </div>
        </div>

        {{-- RIGHT: Contact form card (original style) --}}
        <div class="w-full md:w-1/2">
            <div class="bg-[#050505]/90 border border-zinc-900 rounded-[26px] px-6 md:px-8 py-8
                        shadow-[0_40px_90px_rgba(0,0,0,0.85)]">
                <form method="POST" action="{{ route('contact.send') }}" class="space-y-4">
                    @csrf

                    <input
                        type="text"
                        name="name"
                        placeholder="Name"
                        value="{{ old('name') }}"
                        class="w-full bg-[#111111] border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-slate-100
                               focus:outline-none focus:ring-2 focus:ring-[#ff2455] focus:border-transparent"
                        required
                    >

                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        class="w-full bg-[#111111] border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-slate-100
                               focus:outline-none focus:ring-2 focus:ring-[#ff2455] focus:border-transparent"
                        required
                    >

                    <textarea
                        name="message"
                        rows="4"
                        placeholder="Message"
                        class="w-full bg-[#111111] border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-slate-100
                               focus:outline-none focus:ring-2 focus:ring-[#ff2455] focus:border-transparent resize-none"
                        required>{{ old('message') }}</textarea>

                    <button
    type="submit"
    class="w-full mt-4 bg-gradient-to-r from-[#ff2455] to-[#ff4b2b]
           hover:from-[#ff3b66] hover:to-[#ff5c3d]
           text-white font-semibold py-3 rounded-2xl
           shadow-[0_10px_25px_rgba(255,40,85,0.35)] transition">
    Send
</button>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
