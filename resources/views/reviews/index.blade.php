@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    {{-- Heading --}}
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#ff2455] mb-2">
            Client Reviews
        </h1>
        <p class="text-sm md:text-base text-slate-200 max-w-2xl">
            See what clients are saying about their experience with Aronmovez Tattoo Shop.
        </p>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-500/10 border border-emerald-500/40 px-4 py-3 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-10">
        {{-- LEFT: Reviews list --}}
        <div>
            @if ($reviews->isEmpty())
                <p class="text-sm text-zinc-400">
                    No reviews yet. Once clients share their experience, they will appear here.
                </p>
            @else
                <div class="space-y-4">
                    @foreach ($reviews as $review)
    <div class="bg-[#090909] border border-zinc-900 rounded-2xl px-5 py-4 shadow-[0_10px_30px_rgba(0,0,0,0.6)]">

        <div class="flex items-center justify-between mb-2">
            <span class="font-semibold text-slate-100">
                {{ $review->client_name }}
            </span>

            {{-- star rating --}}
            <div class="flex items-center gap-1 text-amber-400 text-xs">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $review->rating)
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </div>
        </div>

        {{-- NEW — Display date + time --}}
        <div class="text-[11px] text-zinc-500 mb-2">
            Posted on: {{ $review->created_at->format('F d, Y — h:i A') }}
        </div>

        <p class="text-sm text-zinc-300 leading-relaxed">
            {{ $review->content }}
        </p>
    </div>
@endforeach

                </div>
            @endif
        </div>

        {{-- RIGHT: Review form --}}
        <div class="bg-[#090909] border border-zinc-900 rounded-2xl px-6 py-6 shadow-[0_10px_30px_rgba(0,0,0,0.6)]">
            <h2 class="text-lg font-semibold mb-3">
                Share your experience
            </h2>
            <p class="text-xs text-zinc-400 mb-4">
                Your feedback helps us improve and guide other clients.
            </p>

            @if ($errors->any())
                <div class="mb-4 text-xs text-red-300 bg-red-900/30 border border-red-700/60 rounded-lg px-3 py-2">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Your Name
                    </label>
                    <input type="text" name="client_name"
                           value="{{ old('client_name') }}"
                           class="w-full bg-[#101018] border border-zinc-800 rounded-2xl px-4 py-2.5 text-sm text-zinc-100
                                  focus:outline-none focus:ring-1 focus:ring-[#ff2455]" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Rating
                    </label>
                    <select name="rating"
                            class="w-full bg-[#101018] border border-zinc-800 rounded-2xl px-4 py-2.5 text-sm text-zinc-100
                                   focus:outline-none focus:ring-1 focus:ring-[#ff2455]" required>
                        <option value="">Select rating</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Your Feedback
                    </label>
                    <textarea name="content" rows="4"
                              class="w-full bg-[#101018] border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-zinc-100
                                     focus:outline-none focus:ring-1 focus:ring-[#ff2455] resize-none"
                              required>{{ old('content') }}</textarea>
                </div>

                <button type="submit"
                        class="inline-flex items-center justify-center w-full mt-2 rounded-2xl bg-[#ff2455] hover:bg-[#ff3b66]
                               text-sm font-semibold text-white py-2.5 shadow-[0_14px_45px_rgba(255,40,85,0.45)] transition">
                    Submit Review
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
