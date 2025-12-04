@extends('layouts.admin')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
            Client Review Management
        </h1>
        <p class="text-sm text-zinc-400 mt-1">
            Approve or manage feedback submitted from the public reviews page.
        </p>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-500/10 border border-emerald-500/40 px-4 py-3 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-8">

        {{-- PENDING REVIEWS --}}
        <section class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-100">
                        Pending Reviews
                    </h2>
                    <p class="text-xs text-zinc-400 mt-1">
                        Require approval before they appear on the site.
                    </p>
                </div>
                <span class="text-xs text-zinc-500">
                    {{ $pendingReviews->count() }} pending
                </span>
            </div>

            @if ($pendingReviews->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-700/70 bg-[#0b0b0f] px-4 py-6 text-center">
                    <p class="text-sm text-zinc-400">No pending reviews at the moment.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($pendingReviews as $review)
                        <div class="bg-[#0b0b0f] rounded-2xl border border-zinc-800 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-3 mb-1">
                                    <div>
                                        <div class="font-semibold text-slate-100">
                                            {{ $review->client_name }}
                                        </div>
                                        <div class="text-[11px] text-zinc-500">
                                            Submitted {{ $review->created_at->format('M d, Y • h:i A') }}
                                        </div>
                                    </div>

                                    {{-- rating stars --}}
                                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating) ★ @else ☆ @endif
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-sm text-zinc-300 mt-1 leading-relaxed">
                                    {{ $review->content }}
                                </p>
                            </div>

                            {{-- ACTIONS: APPROVE + DELETE --}}
                            <div class="flex md:flex-col gap-2 md:ml-4">
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl text-xs font-semibold
                                                   bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm shadow-emerald-500/40 transition">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                      onsubmit="return confirm('Delete this review permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl text-xs font-semibold
                                                   bg-red-500 hover:bg-red-600 text-white shadow-sm shadow-red-500/40 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- APPROVED / PUBLISHED REVIEWS --}}
        <section class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-100">
                        Published Reviews
                    </h2>
                    <p class="text-xs text-zinc-400 mt-1">
                        Currently visible on the public Reviews page.
                    </p>
                </div>
                <span class="text-xs text-zinc-500">
                    {{ $approvedReviews->count() }} active
                </span>
            </div>

            @if ($approvedReviews->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-700/70 bg-[#0b0b0f] px-4 py-6 text-center">
                    <p class="text-sm text-zinc-400">No published reviews yet.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($approvedReviews as $review)
                        <div class="bg-[#0b0b0f] rounded-2xl border border-zinc-800 px-5 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <div class="font-semibold text-slate-100">
                                            {{ $review->client_name }}
                                        </div>
                                        <div class="text-[11px] text-zinc-500">
                                            Posted {{ $review->created_at->format('M d, Y • h:i A') }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating) ★ @else ☆ @endif
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-xs text-zinc-300 mt-1 line-clamp-2">
                                    {{ $review->content }}
                                </p>
                            </div>

                            {{-- ACTIONS: HIDE + DELETE --}}
                            <div class="flex md:flex-col gap-2 md:ml-4">
                                <form action="{{ route('admin.reviews.hide', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl text-xs font-semibold
                                                   bg-amber-500 hover:bg-amber-600 text-black transition">
                                        Hide
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                      onsubmit="return confirm('Delete this review permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl text-xs font-semibold
                                                   bg-red-500 hover:bg-red-600 text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
