@extends('layouts.app')

@section('content')
{{-- FULLSCREEN HERO --}}
<section
    class="relative min-h-[calc(100vh-4rem)] flex items-center justify-center text-center text-white"
    style="background-image: url('{{ asset('images/bg.jpg') }}'); background-size: cover; background-position: center;">
    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/20"></div>

    {{-- Centered glass card --}}
<div class="relative max-w-4xl mx-auto px-6"> {{-- increased max width --}}
    <div class="bg-black/50 backdrop-blur-l rounded-3xl px-10 py-16 shadow-2xl border border-white/10">
        
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6
            bg-gradient-to-r from-red-700 to-red-300
            bg-clip-text text-transparent text-center">
            Welcome to InkTech
        </h1>

        <p class="text-base md:text-lg text-slate-200 max-w-2xl mx-auto mb-10 leading-relaxed text-center">
            Where art meets skin – precision, passion, and ink.
            Explore our curated tattoo portfolio and book your session with Aronmovez Tattoo Shop with ease.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('portfolio') }}"
   class="inline-flex items-center justify-center px-10 py-4 rounded-full text-sm font-semibold
          bg-gradient-to-r from-red-700 to-red-400
          hover:from-red-800 hover:to-red-500
          shadow-lg shadow-red-500/30 transition">
    Browse Portfolio
</a>


            <a href="{{ route('book.create') }}"
               class="inline-flex items-center justify-center px-10 py-4 rounded-full text-sm font-semibold border border-white/60 bg-white/5 hover:bg-white/10 transition">
                Book Now
            </a>
        </div>
    </div>
</div>


   
</section>
@endsection
