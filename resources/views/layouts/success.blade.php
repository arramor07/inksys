@extends('layouts.app')

@section('content')
<section
    class="relative min-h-[calc(100vh-4rem)] flex items-center justify-center text-white"
    style="background-image: url('{{ asset('images/hero-tattoo.jpg') }}'); background-size: cover; background-position: center;">
    
    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/70"></div>

    {{-- Centered glass card --}}
    <div class="relative max-w-2xl w-full px-4">
        <div class="bg-black/60 backdrop-blur-xl rounded-3xl px-8 py-10 shadow-2xl border border-white/10">

            {{-- Heading --}}
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4 flex items-center gap-2">
                Booking Confirmed <span>🎉</span>
            </h1>

            {{-- Main text --}}
            <p class="text-sm md:text-base text-slate-200 mb-6 leading-relaxed">
                Thank you, <span class="font-bold">{{ $booking->name }}</span>!
                We’ve received your booking for
                <span class="font-semibold">
                    {{ \Carbon\Carbon::parse($booking->appointment_date)->toFormattedDateString() }}
                    at
                    {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
                </span>.
            </p>

            {{-- Tattoo idea --}}
            <div class="mb-6">
                <p class="text-xs uppercase tracking-wide text-slate-400 mb-1">
                    Your tattoo idea:
                </p>
                <p class="text-sm md:text-base text-slate-100">
                    {{ $booking->tattoo_prompt }}
                </p>
            </div>

            {{-- AI IMAGE SECTION --}}
            @if(!empty($booking->ai_image_url))
                <div class="mb-6">
                    <p class="text-xs uppercase tracking-wide text-slate-400 mb-2">
                        AI preview (concept only)
                    </p>
                    <div class="bg-black/40 rounded-2xl border border-white/10 p-3 flex justify-center">
                        <img
                            src="{{ $booking->ai_image_url }}"
                            alt="AI Tattoo Preview"
                            class="rounded-2xl max-h-72 object-contain shadow-lg border border-black/40"
                        >
                    </div>
                    <p class="text-[11px] text-slate-400 mt-2">
                        This is an AI-generated concept based on your description. Aronmovez can still refine and adjust the final design during your session.
                    </p>
                </div>
            @else
                <div class="mb-6">
                    <div class="bg-amber-500/10 border border-amber-400/60 text-amber-200 text-xs md:text-sm px-4 py-3 rounded-2xl">
                        We were not able to generate an AI image at this time, but your booking has been saved successfully.
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between mt-4">
                <a href="{{ route('book.create') }}"
                   class="inline-flex items-center justify-center px-8 py-3 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-sm font-semibold text-white shadow-[0_10px_30px_rgba(255,0,0,0.45)] hover:brightness-110 transition">
                    Book another appointment
                </a>

                <a href="{{ url('/') }}"
                   class="text-xs md:text-sm text-slate-300 hover:text-red-400 underline underline-offset-4">
                    Back to home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
