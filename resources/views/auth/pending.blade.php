@extends('layouts.app')

@section('content')
<section
    class="relative min-h-[calc(100vh-4rem)] flex items-center justify-center text-white"
    style="background-image: url('{{ asset('images/hero-tattoo.jpg') }}'); background-size: cover; background-position: center;">
    
    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/75"></div>

    <div class="relative max-w-xl w-full px-4">
        <div class="bg-black/65 backdrop-blur-xl rounded-3xl px-8 py-10 shadow-2xl border border-white/10">

            <h1 class="text-2xl md:text-3xl font-extrabold mb-4">
                Account Pending Approval 🔒
            </h1>

            <p class="text-sm md:text-base text-slate-200 mb-4 leading-relaxed">
                Thank you, <span class="font-semibold">{{ $user->name }}</span>.
                Your account registration has been received.
            </p>

            <p class="text-sm text-slate-300 mb-6 leading-relaxed">
                Your request to become a <span class="font-semibold text-red-400">co-admin / assistant admin</span>
                is now <span class="font-semibold">pending review</span> by the main administrator.
                Once your account is approved, you’ll be able to log in and access the admin tools.
            </p>

            <div class="bg-[#181818] border border-[#333] rounded-2xl p-4 text-xs text-slate-300 mb-6">
                <p class="mb-1">
                    <span class="font-semibold text-slate-100">What happens next?</span>
                </p>
                <ul class="list-disc list-inside space-y-1">
                    <li>The main admin will review your registration details.</li>
                    <li>If approved, your account status will change to <span class="text-emerald-400 font-semibold">approved</span>.</li>
                    <li>You can then use your email and password to log in as a co-admin/assistant.</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center justify-center px-8 py-3 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-sm font-semibold text-white shadow-[0_10px_30px_rgba(255,0,0,0.45)] hover:brightness-110 transition">
                    Back to Home
                </a>

                <p class="text-[11px] text-slate-400">
                    You’ll be notified by the admin once your account is activated.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
