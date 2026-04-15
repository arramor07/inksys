@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-black via-[#050509] to-black min-h-[calc(100vh-4rem)] py-10">
    <div class="max-w-6xl mx-auto px-4">

        {{-- HEADER --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">
            Portfolio
        </h1>
        <p class="text-sm text-zinc-400 mb-6">
            Browse sample works. Tap any design to view it larger or book a session inspired by that piece.
        </p>

        @php
            $portfolioCategories = [
                'All',
                'Minimalist/Fine Line',
                'Portrait',
                'Realism',
                'Traditional',
                'Japanese',
                'Script/Lettering',
                'Full Sleeve',
                'Full Back',
                'Geometric',
                'Polynesian/Tribal',
                'Others',
            ];
        @endphp

        @if($portfolio->isEmpty())
            <p class="text-zinc-500">No portfolio items yet. Please check back soon.</p>
        @else
            {{-- CATEGORY FILTER CHIPS --}}
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($portfolioCategories as $cat)
                    @php
                        $value = $cat === 'All' ? 'all' : $cat;
                    @endphp
                    <button
                        type="button"
                        class="portfolio-filter px-4 py-1.5 rounded-full text-xs font-semibold
                               border border-zinc-700 text-zinc-300 bg-[#111015]
                               hover:bg-red-600 hover:border-red-600 hover:text-white transition
                               {{ $cat === 'All' ? 'bg-red-600 border-red-600 text-white' : '' }}"
                        data-filter="{{ $value }}"
                    >
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            {{-- GRID OF CARDS --}}
            <div id="portfolioGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portfolio as $item)
                    @php
                        $categoryRaw = $item->category ?? 'Others';
                        $category    = $categoryRaw === '' ? 'Others' : $categoryRaw;

                        // Build correct image URL (works for storage paths and full URLs)
                        $imgUrl = null;
                        if (!empty($item->image_url)) {
                            if (preg_match('#^https?://#', $item->image_url)) {
                                $imgUrl = $item->image_url;         // already full URL
                            } else {
                                $imgUrl = asset('storage/'.$item->image_url); // stored via Storage::disk('public')
                            }
                        }
                    @endphp

                    <div class="portfolio-card bg-[#0d0d0f] border border-zinc-800 rounded-2xl overflow-hidden shadow-xl
                                hover:shadow-[0_0_30px_rgba(255,0,0,0.35)] transition"
                         data-category="{{ $category }}">

                        {{-- CLICKABLE IMAGE --}}
                        <div class="aspect-[4/3] bg-black cursor-pointer"
                             @if($imgUrl)
                                 onclick="openImageViewer('{{ $imgUrl }}', '{{ addslashes($item->title) }}')"
                             @endif
                        >
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-full object-cover hover:scale-[1.03] transition-transform duration-200">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500">
                                    No image
                                </div>
                            @endif
                        </div>

                        {{-- TEXT --}}
                        <div class="p-4">
                            <h2 class="font-semibold text-lg text-white mb-1">
                                {{ $item->title }}
                            </h2>

                            @if($item->style)
                                <p class="text-[11px] uppercase tracking-[0.16em] text-red-400 mb-2">
                                    {{ $item->style }}
                                </p>
                            @endif

                            @if($item->description)
                                <p class="text-sm text-zinc-400 line-clamp-3 mb-4">
                                    {{ $item->description }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between gap-2">
                                {{-- BOOK THIS DESIGN (OPEN MODAL) --}}
                                <button type="button"
                                        onclick="openBookingModal('{{ addslashes($item->title) }}')"
                                        class="px-4 py-2 rounded-full text-xs md:text-sm font-semibold 
                                               bg-gradient-to-r from-red-500 to-red-600 
                                               text-white shadow-[0_8px_25px_rgba(255,0,0,0.35)]
                                               hover:brightness-110 transition">
                                    Book this design
                                </button>

                                {{-- VIEW FULL --}}
                                @if($imgUrl)
                                    <button type="button"
                                            onclick="openImageViewer('{{ $imgUrl }}', '{{ addslashes($item->title) }}')"
                                            class="text-[11px] md:text-xs text-zinc-300 hover:text-white">
                                        View full →
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- =========================
     FULLSCREEN IMAGE VIEWER
========================= --}}
<div id="imageViewer"
     class="fixed inset-0 hidden bg-black/90 backdrop-blur-sm z-[9999] 
            items-center justify-center p-4">

    {{-- CLOSE BUTTON --}}
    <button type="button"
            onclick="closeImageViewer()"
            class="absolute top-4 right-4 text-white text-3xl font-bold leading-none">
        ×
    </button>

    {{-- DOWNLOAD BUTTON --}}
    <a id="downloadImageBtn"
       href="#"
       download
       class="absolute top-4 left-4 text-xs md:text-sm text-white bg-zinc-800/90 
              px-4 py-2 rounded-full hover:bg-zinc-700">
        Download image
    </a>

    {{-- IMAGE --}}
    <img id="viewerImage"
         src=""
         alt="Tattoo design"
         class="max-h-[90vh] max-w-[90vw] object-contain rounded-xl shadow-2xl border border-zinc-700">
</div>

{{-- =========================
     BOOK THIS DESIGN MODAL
========================= --}}
<div id="bookingModal"
     class="fixed inset-0 hidden bg-black/70 backdrop-blur-sm z-[9999] 
            items-center justify-center p-4">

    <div class="bg-[#101015] border border-zinc-800 rounded-2xl p-6 w-full max-w-md relative">

        {{-- CLOSE --}}
        <button type="button"
                onclick="closeBookingModal()"
                class="absolute top-3 right-4 text-white text-2xl leading-none">
            ×
        </button>

        <h2 class="text-xl font-bold text-white mb-1">
            Book this design
        </h2>
        <p class="text-xs text-zinc-400 mb-4">
            Fill in your details and preferred schedule. Aronmovez will confirm your appointment via email.
        </p>

        <form action="{{ route('book.store') }}" method="POST">
            @csrf

            {{-- store chosen design as tattoo_prompt so it reaches BookingController --}}
            <input type="hidden" id="selected_design" name="tattoo_prompt">

            <div class="mb-3">
                <input type="text" name="name"
                       class="w-full px-4 py-2.5 rounded-lg bg-zinc-900 border border-zinc-700 text-sm text-white
                              focus:outline-none focus:ring-1 focus:ring-red-500"
                       placeholder="Full Name" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email"
                       class="w-full px-4 py-2.5 rounded-lg bg-zinc-900 border border-zinc-700 text-sm text-white
                              focus:outline-none focus:ring-1 focus:ring-red-500"
                       placeholder="Email Address" required>
            </div>

            <div class="mb-3">
                <input type="text" name="phone"
                       class="w-full px-4 py-2.5 rounded-lg bg-zinc-900 border border-zinc-700 text-sm text-white
                              focus:outline-none focus:ring-1 focus:ring-red-500"
                       placeholder="Contact Number (optional)">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                <div>
                    <input type="date" name="appointment_date"
                           class="w-full px-4 py-2.5 rounded-lg bg-zinc-900 border border-zinc-700 text-sm text-white
                                  focus:outline-none focus:ring-1 focus:ring-red-500"
                           required>
                </div>
                <div>
                    <input type="time" name="appointment_time"
                           class="w-full px-4 py-2.5 rounded-lg bg-zinc-900 border border-zinc-700 text-sm text-white
                                  focus:outline-none focus:ring-1 focus:ring-red-500"
                           required>
                </div>
            </div>

            <div class="mb-4">
                <textarea name="additional_message" rows="3"
                          class="w-full px-4 py-2.5 rounded-lg bg-zinc-900 border border-zinc-700 text-sm text-white
                                 focus:outline-none focus:ring-1 focus:ring-red-500 resize-none"
                          placeholder="Message / extra details (placement, size, etc.) (optional)"></textarea>
            </div>

            <button type="submit"
                    class="w-full py-2.5 rounded-full bg-gradient-to-r from-red-500 to-red-600 
                           text-white font-semibold text-sm shadow-[0_10px_30px_rgba(255,0,0,0.4)]
                           hover:brightness-110 transition">
                Submit Booking
            </button>
        </form>
    </div>
</div>

{{-- =========================
     SIMPLE JS HANDLERS
========================= --}}
<script>
    // IMAGE VIEWER
    function openImageViewer(url, title) {
        const viewer = document.getElementById('imageViewer');
        const img    = document.getElementById('viewerImage');
        const dl     = document.getElementById('downloadImageBtn');

        img.src = url;
        img.alt = title || 'Tattoo design';
        dl.href = url;

        viewer.classList.remove('hidden');
        viewer.classList.add('flex');
    }

    function closeImageViewer() {
        const viewer = document.getElementById('imageViewer');
        viewer.classList.add('hidden');
        viewer.classList.remove('flex');
    }

    // BOOKING MODAL
    function openBookingModal(title) {
        const modal = document.getElementById('bookingModal');
        const hiddenInput = document.getElementById('selected_design');

        hiddenInput.value = 'Book this design: ' + (title || '');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // CATEGORY FILTER (client-side)
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.portfolio-filter');
        const cards         = document.querySelectorAll('.portfolio-card');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');

                // active style
                filterButtons.forEach(b => b.classList.remove('bg-red-600', 'border-red-600', 'text-white'));
                btn.classList.add('bg-red-600', 'border-red-600', 'text-white');

                cards.forEach(card => {
                    const cat = card.getAttribute('data-category') || 'Others';

                    if (filter === 'all' || filter === cat) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endsection
