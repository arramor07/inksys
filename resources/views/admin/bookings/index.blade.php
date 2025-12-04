@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl md:text-3xl font-extrabold mb-6">
        Bookings
    </h1>

    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] p-5 md:p-6">
        @if ($bookings->isEmpty())
            <p class="text-sm text-zinc-400">No bookings yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-[0.16em] text-zinc-400 border-b border-zinc-800">
                            <th class="text-left py-3 px-4">Client</th>
                            <th class="text-left py-3 px-4">Contact</th>
                            <th class="text-left py-3 px-4">Date & Time</th>
                            <th class="text-left py-3 px-4">Service / Prompt</th>
                            <th class="text-left py-3 px-4">Design</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-right py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-900/80">
                        @foreach ($bookings as $booking)
                            @php
                                $status = strtolower($booking->status ?? 'pending');
                            @endphp

                            <tr class="hover:bg-[#101018] transition">
                                {{-- CLIENT NAME --}}
                                <td class="py-3 px-4 align-top">
                                    <div class="font-semibold text-slate-100">
                                        {{ $booking->name }}
                                    </div>
                                </td>

                                {{-- CONTACT (EMAIL) --}}
                                <td class="py-3 px-4 align-top text-zinc-300">
                                    {{ $booking->email }}
                                </td>

                                {{-- DATE & TIME --}}
                                <td class="py-3 px-4 align-top text-zinc-200">
                                    {{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}
                                    <br>
                                    <span class="text-xs text-zinc-400">
                                        {{ \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A') }}
                                    </span>
                                </td>

                                {{-- SERVICE / PROMPT --}}
                                <td class="py-3 px-4 align-top">
                                    <div class="text-slate-100 text-sm font-semibold">
                                        {{ $booking->service ?? 'Custom Tattoo' }}
                                    </div>
                                    @if ($booking->tattoo_prompt)
                                        <p class="text-xs text-zinc-400 mt-1 line-clamp-3">
                                            "{{ $booking->tattoo_prompt }}"
                                        </p>
                                    @endif

                                    @if ($booking->additional_message)
                                        <p class="text-xs text-zinc-400 mt-1">
                                            <span class="font-semibold text-zinc-300">Client message:</span>
                                            {{ $booking->additional_message }}
                                        </p>
                                    @endif
                                </td>

                                {{-- DESIGN COLUMN (AI + CLIENT UPLOAD) --}}
                                <td class="py-3 px-4 align-top">
                                    @if ($booking->ai_image_url)
                                        @php
                                            $aiUrl = asset('storage/'.$booking->ai_image_url);
                                        @endphp
                                        <div class="mb-3">
                                            <div class="text-[10px] uppercase tracking-[0.16em] text-zinc-500 mb-1">
                                                AI Preview
                                            </div>

                                            {{-- THUMBNAIL – opens modal --}}
                                            <button type="button"
                                                    onclick="openImageModal('{{ $aiUrl }}')"
                                                    class="block w-20 h-20 rounded-lg overflow-hidden border border-zinc-800 bg-black/60 group cursor-zoom-in focus:outline-none">
                                                <img src="{{ $aiUrl }}"
                                                     alt="AI design"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            </button>

                                            {{-- QUICK DOWNLOAD (optional small link under thumb) --}}
                                            <button type="button"
                                                    onclick="downloadImage('{{ $aiUrl }}')"
                                                    class="mt-1 inline-flex items-center gap-1 text-[10px] text-sky-400 hover:text-sky-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                          d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M8 11l4 4m0 0l4-4m-4 4V4" />
                                                </svg>
                                                <span>Download</span>
                                            </button>
                                        </div>
                                    @endif

                                    @if ($booking->reference_image_url)
                                        @php
                                            $refUrl = asset('storage/'.$booking->reference_image_url);
                                        @endphp
                                        <div>
                                            <div class="text-[10px] uppercase tracking-[0.16em] text-zinc-500 mb-1">
                                                Client Upload
                                            </div>

                                            <button type="button"
                                                    onclick="openImageModal('{{ $refUrl }}')"
                                                    class="block w-20 h-20 rounded-lg overflow-hidden border border-zinc-800 bg-black/60 group cursor-zoom-in focus:outline-none">
                                                <img src="{{ $refUrl }}"
                                                     alt="Client reference"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            </button>

                                            <button type="button"
                                                    onclick="downloadImage('{{ $refUrl }}')"
                                                    class="mt-1 inline-flex items-center gap-1 text-[10px] text-sky-400 hover:text-sky-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                          d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M8 11l4 4m0 0l4-4m-4 4V4" />
                                                </svg>
                                                <span>Download</span>
                                            </button>
                                        </div>
                                    @endif

                                    @unless($booking->ai_image_url || $booking->reference_image_url)
                                        <span class="text-xs text-zinc-500">No design</span>
                                    @endunless
                                </td>

                                {{-- STATUS --}}
                                <td class="py-3 px-4 align-top">
                                    @if ($status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                                                    bg-emerald-500/10 text-emerald-300 border border-emerald-500/50">
                                            Completed
                                        </span>
                                    @elseif ($status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                                                    bg-sky-500/10 text-sky-300 border border-sky-500/50">
                                            Approved
                                        </span>
                                    @elseif ($status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                                                    bg-red-500/10 text-red-300 border border-red-500/50">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                                                    bg-amber-500/10 text-amber-300 border border-amber-500/50">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- ACTION BUTTONS --}}
                                <td class="py-3 px-4 align-top text-right">
                                    @php
                                        $status    = strtolower($booking->status ?? 'pending');
                                        $isAdmin   = auth()->check() && auth()->user()->role === 'admin';
                                    @endphp

                                    @if ($isAdmin)
                                        <div class="inline-flex gap-2 justify-end">
                                            @if ($status === 'pending')
                                                {{-- PENDING: Approve + Reject --}}
                                                <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="px-4 py-1.5 rounded-lg text-xs font-semibold
                                                                   bg-emerald-500 hover:bg-emerald-600 text-white
                                                                   shadow-sm shadow-emerald-500/40 transition">
                                                        Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST"
                                                      onsubmit="return confirm('Reject this booking?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="px-4 py-1.5 rounded-lg text-xs font-semibold
                                                                   bg-red-500 hover:bg-red-600 text-white
                                                                   shadow-sm shadow-red-500/40 transition">
                                                        Reject
                                                    </button>
                                                </form>

                                            @elseif ($status === 'approved')
                                                {{-- APPROVED: Done --}}
                                                <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST"
                                                      onsubmit="return confirm('Mark this booking as done?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="px-4 py-1.5 rounded-lg text-xs font-semibold
                                                                   bg-sky-500 hover:bg-sky-600 text-white
                                                                   shadow-sm shadow-sky-500/40 transition">
                                                        Done
                                                    </button>
                                                </form>

                                            @elseif ($status === 'rejected')
                                                {{-- REJECTED: Delete --}}
                                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                                                      onsubmit="return confirm('Delete this rejected booking?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-4 py-1.5 rounded-lg text-xs font-semibold
                                                                   bg-red-500 hover:bg-red-600 text-white
                                                                   shadow-sm shadow-red-500/40 transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        {{-- assistant_admin: view-only --}}
                                        <span class="text-xs text-zinc-500 italic">
                                            View only
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- IMAGE LIGHTBOX MODAL --}}
    <div id="image-modal"
         class="hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center px-4">
        <div class="relative max-w-4xl w-full">
            {{-- CLOSE BUTTON --}}
            <button type="button"
                    onclick="closeImageModal()"
                    class="absolute -top-10 right-0 md:-top-12 md:right-0 inline-flex items-center justify-center
                           w-8 h-8 rounded-full bg-zinc-900/90 border border-zinc-700 text-zinc-200
                           hover:bg-zinc-800 focus:outline-none">
                ✕
            </button>

            {{-- FULL IMAGE --}}
            <img id="image-modal-img"
                 src=""
                 alt="Design preview"
                 class="w-full max-h-[80vh] object-contain rounded-2xl bg-black shadow-[0_25px_70px_rgba(0,0,0,0.9)]">

            {{-- FOOTER ACTIONS --}}
            <div class="mt-3 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-zinc-300">
                <span class="text-[11px] text-zinc-400">
                    Click outside the image or press “Close” to go back.
                </span>
                <div class="flex gap-2">
                    <button type="button"
                            onclick="closeImageModal()"
                            class="px-4 py-1.5 rounded-full bg-zinc-800 text-zinc-100 text-[12px] hover:bg-zinc-700">
                        Close
                    </button>
                    <a id="image-modal-download"
                       href="#"
                       download
                       class="px-4 py-1.5 rounded-full bg-sky-500 text-white text-[12px] font-semibold
                              hover:bg-sky-600 shadow-sm shadow-sky-500/40">
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openImageModal(url) {
        const modal   = document.getElementById('image-modal');
        const img     = document.getElementById('image-modal-img');
        const dlLink  = document.getElementById('image-modal-download');

        img.src       = url;
        dlLink.href   = url;

        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('image-modal');
        const img   = document.getElementById('image-modal-img');

        img.src = '';
        modal.classList.add('hidden');
    }

    function downloadImage(url) {
        // Re-use the download anchor from the modal to trigger a download immediately
        const tempLink = document.createElement('a');
        tempLink.href = url;
        tempLink.download = '';
        document.body.appendChild(tempLink);
        tempLink.click();
        document.body.removeChild(tempLink);
    }

    // Allow clicking on the dark backdrop to close the modal
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('image-modal');
        if (!modal) return;

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeImageModal();
            }
        });
    });
</script>
@endpush
