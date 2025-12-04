@extends('layouts.app')

@section('content')
<section class="bg-black min-h-screen pt-24 pb-20 text-white">
    <div class="max-w-5xl mx-auto px-6">

        <h1 class="text-4xl font-extrabold mb-3 text-red-500">
            Client Reviews
        </h1>

        <p class="text-slate-300 max-w-xl mb-12">
            See what clients are saying about their experience with Aronmovez Tattoo Shop.
        </p>

        @if($reviews->isEmpty())
            <p class="text-slate-400 text-sm">
                No reviews yet. Once clients share their experience, they will appear here.
            </p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-[#111]/80 border border-[#222] p-6 rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.7)]">
                        <p class="italic text-slate-300 mb-4">
                            “{{ $review->content }}”
                        </p>

                        {{-- STAR RATING --}}
                        <div class="flex items-center gap-1 text-yellow-400 text-lg mb-3">
                            {{ str_repeat('★', $review->rating) }}
                            @if($review->rating < 5)
                                {{ str_repeat('☆', 5 - $review->rating) }}
                            @endif
                        </div>

                        <p class="text-red-400 font-semibold text-sm">— {{ $review->client_name }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
