@extends('layouts.app')

@section('content')

{{-- SUCCESS ALERT --}}
@if (session('success'))
    <div class="mb-6 w-full max-w-xl mx-auto rounded-xl bg-emerald-500/10 
                border border-emerald-500/40 px-4 py-3 text-sm 
                text-emerald-200 text-center">
        {{ session('success') }}
    </div>
@endif

<section class="bg-gradient-to-b from-black via-[#121212] to-black min-h-[calc(100vh-4rem)] flex items-center justify-center pt-8 pb-16">
    <div class="w-full max-w-5xl px-4">

        <h1 class="text-center text-2xl md:text-3xl font-bold text-white mb-6">
            Book a Tattoo Session
        </h1>

        {{-- FORM + CARDS --}}
        <form id="booking-form" action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">

                {{-- LEFT CARD – PERSONAL INFO + SCHEDULE --}}
                <div class="bg-[#101010]/95 border border-white/5 rounded-[30px] shadow-[0_25px_60px_rgba(0,0,0,0.75)] px-6 py-7 md:px-7 md:py-8">
                    {{-- VALIDATION ERRORS --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/50 text-red-200 text-xs">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FULL NAME --}}
                    <div>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Full Name"
                            class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                            required
                        >
                    </div>

                    {{-- CONTACT NUMBER (OPTIONAL) --}}
                    <div class="mt-4">
                        <label for="phone" class="block mb-1 text-sm text-slate-400">
                            Contact Number (Optional)
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="09XXXXXXXXX"
                            class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] 
                                   text-sm text-slate-100 placeholder:text-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                        >
                    </div>

                    {{-- EMAIL ADDRESS --}}
                    <div class="mt-4">
                        <label for="email" class="block mb-1 text-sm text-slate-400">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="yourname@example.com"
                            class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626]
                                   text-sm text-slate-100 placeholder:text-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                            required
                        >
                    </div>

                        {{-- HOME ADDRESS --}}
<div class="mt-4">
    <label for="home_address" class="block mb-1 text-sm text-slate-400">
        Home Address (Optional)
    </label>

    <input
        type="text"
        id="home_address"
        name="home_address"
        value="{{ old('home_address') }}"
        placeholder="House/Street, Barangay, Town/City"
        class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626]
               text-sm text-slate-100 placeholder:text-slate-500
               focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
    >
</div>


                    {{-- SELECT TATTOO STYLE (UI ONLY) --}}
                    <div class="mt-4">
                        <select
                            class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70 appearance-none"
                        >
                            <option value="" disabled selected>Select Tattoo Style</option>
                            <option value="minimalist">Minimalist / Fine Line</option>
                            <option value="realism">Realism</option>
                            <option value="traditional">Traditional</option>
                            <option value="script">Script / Lettering</option>
                            <option value="custom">Custom Concept</option>
                        </select>
                    </div>

                    {{-- DATE & TIME (SIDE BY SIDE ON DESKTOP) --}}
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <input
                                type="date"
                                id="appointment_date"
                                name="appointment_date"
                                value="{{ old('appointment_date') }}"
                                class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                                style="color-scheme: dark;"
                                required
                            >
                        </div>
                        <div>
                            <input
                                type="time"
                                id="appointment_time"
                                name="appointment_time"
                                value="{{ old('appointment_time') }}"
                                class="w-full px-5 py-3 rounded-full bg-[#181818] border border-[#262626] text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70"
                                style="color-scheme: dark;"
                                required
                            >
                        </div>
                    </div>

                    <style>
                        #appointment_date::-webkit-calendar-picker-indicator,
                        #appointment_time::-webkit-calendar-picker-indicator {
                            filter: invert(0.8) brightness(1.2);
                            cursor: pointer;
                        }
                    </style>
                </div>

                {{-- RIGHT CARD – IDEA / DESIGN / MESSAGES + BUTTONS --}}
                <div class="bg-[#101010]/95 border border-white/5 rounded-[30px] shadow-[0_25px_60px_rgba(0,0,0,0.75)] px-6 py-7 md:px-7 md:py-8 flex flex-col">
                    <div class="flex-1">
                        <label for="tattoo_prompt" class="block mb-1 text-sm text-red-400 font-semibold">
                            This section is required *
                        </label>

                        <textarea
                            id="tattoo_prompt"
                            name="tattoo_prompt"
                            rows="5"
                            class="w-full px-5 py-3 rounded-[20px] bg-[#181818] border border-[#262626] 
                                   text-sm text-slate-100 placeholder:text-slate-500 
                                   focus:outline-none focus:ring-2 focus:ring-red-500/70 focus:border-red-500/70 resize-none"
                            placeholder="Notes / Requests — describe your tattoo idea here. This will be used by the AI generator for your preview."
                            required
                        >{{ old('tattoo_prompt') }}</textarea>
                    </div>

                    {{-- OPTIONAL REFERENCE IMAGE --}}
                    <div class="space-y-1 mt-4">
                        <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                            Upload Reference Image (optional)
                        </label>
                        <input type="file"
                               name="reference_image"
                               accept="image/*"
                               class="w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-md file:border-0
                                      file:bg-[#18181f] file:text-zinc-200 file:text-xs
                                      bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-zinc-200
                                      focus:outline-none focus:ring-1 focus:ring-[#ff2455]">
                        <p class="text-[11px] text-zinc-500">
                            Optional: upload your own design if the AI preview doesn’t match what you want.
                        </p>
                        @error('reference_image')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- OPTIONAL: ADDITIONAL MESSAGE / SPECIAL REQUESTS --}}
                    <div class="space-y-1 mt-4">
                        <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                            Additional Message / Special Requests (optional)
                        </label>
                        <textarea name="additional_message" rows="3"
                                  class="w-full bg-[#101018] border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-zinc-100
                                         focus:outline-none focus:ring-1 focus:ring-[#ff2455] resize-none">{{ old('additional_message') }}</textarea>
                        <p class="text-[11px] text-zinc-500">
                            You can add extra instructions here (placement, size preference, schedule concerns, healing reminders, etc.).
                        </p>
                        @error('additional_message')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-4">
                        <button
                            type="button"
                            id="generate-preview-btn"
                            class="w-full sm:w-auto px-6 py-2 rounded-full 
                                   border border-red-500 
                                   text-red-400 font-semibold 
                                   hover:bg-red-500/10 transition"
                        >
                            Generate AI Preview
                        </button>

                        <button
                            type="submit"
                            class="w-full sm:w-auto px-10 py-3 rounded-full 
                                   bg-gradient-to-r from-red-500 to-red-600 
                                   text-white font-semibold 
                                   shadow-[0_8px_25px_rgba(255,0,0,0.35)] 
                                   hover:brightness-110 transition"
                        >
                            Submit
                        </button>
                    </div>

                    {{-- AI PREVIEW AREA (INSIDE RIGHT CARD) --}}
                    <div id="preview-section" class="mt-6 hidden">
                        <h2 class="text-sm font-semibold text-slate-100 mb-2">
                            AI Preview
                        </h2>
                        <p class="text-[11px] text-slate-400 mb-2">
                            This is an AI-generated concept based on your notes. Aronmovez can still tweak and refine this in the actual session.
                        </p>

                        <div
                            class="relative bg-[#181818] border border-[#262626] rounded-[20px] p-4 flex flex-col items-center justify-center"
                        >
                            <div id="preview-loading" class="text-xs text-slate-400 mb-2 hidden">
                                Generating image, please wait…
                            </div>

                            <img
                                id="preview-image"
                                src=""
                                alt="AI Tattoo Preview"
                                class="rounded-[18px] border border-black/40 shadow-lg max-h-64 object-contain hidden"
                            >

                            <div id="preview-error" class="text-xs text-red-400 mt-2 hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- INLINE SCRIPT FOR AJAX AI PREVIEW --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewSection = document.getElementById('preview-section');
        const previewImage   = document.getElementById('preview-image');
        const previewLoading = document.getElementById('preview-loading');
        const previewError   = document.getElementById('preview-error');
        const generateBtn    = document.getElementById('generate-preview-btn');
        const promptTextarea = document.getElementById('tattoo_prompt');

        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken     = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

        if (!generateBtn || !csrfToken) return;

        generateBtn.addEventListener('click', async function () {
            const prompt = promptTextarea.value.trim();

            if (!prompt) {
                alert('Please add your notes / tattoo description first.');
                return;
            }

            generateBtn.disabled = true;
            generateBtn.classList.add('opacity-60', 'cursor-not-allowed');

            previewSection.classList.remove('hidden');
            previewError.classList.add('hidden');
            previewImage.classList.add('hidden');
            previewLoading.classList.remove('hidden');
            previewLoading.textContent = 'Generating image, please wait…';

            try {
                const response = await fetch('{{ route('book.generate-image') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        tattoo_prompt: prompt
                    }),
                });

                const data = await response.json();

                previewLoading.classList.add('hidden');

                if (response.ok && data.success && data.image_url) {
                    previewImage.src = data.image_url;
                    previewImage.classList.remove('hidden');
                } else {
                    previewError.textContent = data.message || 'Failed to generate image.';
                    previewError.classList.remove('hidden');
                }
            } catch (error) {
                previewLoading.classList.add('hidden');
                previewError.textContent = 'An error occurred while generating the image.';
                previewError.classList.remove('hidden');
            } finally {
                generateBtn.disabled = false;
                generateBtn.classList.remove('opacity-60', 'cursor-not-allowed');
            }
        });
    });
</script>
@endsection
