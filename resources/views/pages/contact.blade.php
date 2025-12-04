@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-black via-[#141414] to-black min-h-[calc(100vh-4rem)] flex items-center justify-center pt-10 pb-16">
    <div class="w-full max-w-6xl px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            {{-- LEFT SIDE: TEXT + INFO + SOCIALS --}}
            <div class="text-white">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-6 text-center md:text-left">
                    Contact Us
                </h1>

                <div class="space-y-3 text-sm md:text-base text-slate-200 mb-8">
                    <p>
                        <span class="mr-2 text-pink-500">📍</span>
                        <span class="align-middle">Address: 123 Ink Street, Bansud</span>
                    </p>
                    <p>
                        <span class="mr-2 text-pink-500">📞</span>
                        <span class="align-middle">Phone: 0912-345-6789</span>
                    </p>
                    <p>
                        <span class="mr-2 text-pink-500">📧</span>
                        <span class="align-middle">Email: inktech@email.com</span>
                    </p>
                </div>

                {{-- SOCIAL BUTTONS --}}
                <div class="flex flex-wrap gap-4">
                    <button
                        type="button"
                        class="px-6 py-2 rounded-full bg-[#111111] text-sm font-semibold text-slate-100 shadow-[0_10px_25px_rgba(0,0,0,0.7)] hover:bg-[#1b1b1b] transition">
                        Facebook
                    </button>
                    <button
                        type="button"
                        class="px-6 py-2 rounded-full bg-[#111111] text-sm font-semibold text-slate-100 shadow-[0_10px_25px_rgba(0,0,0,0.7)] hover:bg-[#1b1b1b] transition">
                        Instagram
                    </button>
                    <button
                        type="button"
                        class="px-6 py-2 rounded-full bg-[#111111] text-sm font-semibold text-slate-100 shadow-[0_10px_25px_rgba(0,0,0,0.7)] hover:bg-[#1b1b1b] transition">
                        TikTok
                    </button>
                </div>
            </div>

            {{-- RIGHT SIDE: GLASS CARD FORM --}}
            <div>
                <div class="bg-[#101010]/95 border border-black/40 rounded-[26px] shadow-[0_25px_60px_rgba(0,0,0,0.85)] px-8 py-8 md:py-10">
                    <form class="space-y-4">
                        <div>
                            <input
                                type="text"
                                placeholder="Name"
                                class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70">
                        </div>

                        <div>
                            <input
                                type="email"
                                placeholder="Email"
                                class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70">
                        </div>

                        <div>
                            <textarea
                                rows="4"
                                placeholder="Message"
                                class="w-full px-5 py-3 rounded-[20px] bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70 resize-none"></textarea>
                        </div>

                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full px-8 py-3 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-sm font-semibold text-white shadow-[0_10px_30px_rgba(255,0,0,0.45)] hover:brightness-110 transition">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
