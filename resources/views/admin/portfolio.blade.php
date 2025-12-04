@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-extrabold mb-6">Portfolio Manager</h1>

    {{-- UPLOAD FORM (placeholder only) --}}
    <form class="space-y-3 mb-8">
        <input type="file"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <input type="text" placeholder="Title"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <input type="text" placeholder="Description"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <input type="text" placeholder="Price"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <button type="button"
                class="w-full bg-[#19c45b] hover:bg-[#16a94d] text-xs font-semibold text-black py-2 rounded-md">
            Upload
        </button>
    </form>

    <h2 class="text-lg font-semibold mb-4">Gallery</h2>

    @php
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- example card --}}
        <div class="bg-[#111111] rounded-xl shadow-lg p-4 flex flex-col items-center">
            <div class="w-full h-32 bg-black flex items-center justify-center text-xs text-slate-400 mb-3">
                Artwork
            </div>
            <p class="text-center text-sm font-bold text-[#ff2455] mb-3">
                Tattoo Design #1 – ₱2000
            </p>
            <div class="flex gap-3">
                {{-- Edit: visible to both admin and assistant_admin --}}
                <button class="bg-[#2563eb] hover:bg-[#1d4ed8] text-white text-xs px-4 py-1 rounded-md">
                    Edit
                </button>

                {{-- Delete: visible to ADMIN only --}}
                @if ($isAdmin)
                    <button class="bg-[#ef4444] hover:bg-[#dc2626] text-white text-xs px-4 py-1 rounded-md">
                        Delete
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
