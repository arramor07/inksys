@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- HEADER + ADD BUTTON --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white">
            Portfolio Manager
        </h1>

        <button type="button"
                onclick="toggleNewItemForm()"
                class="px-5 py-2 rounded-full bg-red-600 text-white text-sm font-semibold
                       shadow-[0_10px_30px_rgba(255,0,0,0.45)] hover:bg-red-700 transition">
            Add New Item
        </button>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-500/15 border border-emerald-500/40 px-4 py-2 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- COLLAPSIBLE NEW ITEM FORM --}}
    <div id="newItemPanel"
         class="mb-8 hidden bg-[#090909] border border-zinc-800 rounded-2xl px-5 py-5">

        <h2 class="text-lg font-semibold text-white mb-3">
            Add New Portfolio Item
        </h2>

        <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                {{-- TITLE --}}
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Title
                    </label>
                    <input type="text" name="title"
                           class="w-full px-4 py-2.5 rounded-lg bg-[#111015] border border-zinc-700 text-sm text-white
                                  focus:outline-none focus:ring-1 focus:ring-red-500"
                           placeholder="e.g. Cherry"
                           required>
                </div>

                {{-- STYLE (OPTIONAL SHORT TEXT) --}}
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Style / Short Label (optional)
                    </label>
                    <input type="text" name="style"
                           class="w-full px-4 py-2.5 rounded-lg bg-[#111015] border border-zinc-700 text-sm text-white
                                  focus:outline-none focus:ring-1 focus:ring-red-500"
                           placeholder="e.g. Colored Minimalist – Php. 1,000.00">
                </div>
            </div>

            {{-- CATEGORY SELECT (FOR CLIENT FILTERS) --}}
            <div>
                <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                    Category
                </label>
                <select name="category"
                        class="w-full px-4 py-2.5 rounded-lg bg-[#111015] border border-zinc-700 text-sm text-white
                               focus:outline-none focus:ring-1 focus:ring-red-500">
                    <option value="" selected>Uncategorized</option>
                    <option value="Minimalist/Fine Line">Minimalist / Fine Line</option>
                    <option value="Portrait">Portrait</option>
                    <option value="Realism">Realism</option>
                    <option value="Traditional">Traditional</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Script/Lettering">Script / Lettering</option>
                    <option value="Full Sleeve">Full Sleeve</option>
                    <option value="Full Back">Full Back</option>
                    <option value="Geometric">Geometric</option>
                    <option value="Polynesian/Tribal">Polynesian / Tribal</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                    Description (optional)
                </label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 rounded-lg bg-[#111015] border border-zinc-700 text-sm text-white
                                 focus:outline-none focus:ring-1 focus:ring-red-500 resize-none"
                          placeholder="Short description of the piece (placement, concept, etc.)."></textarea>
            </div>

            {{-- IMAGE UPLOAD --}}
            <div>
                <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                    Upload Image
                </label>
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-zinc-200
                              file:mr-3 file:px-4 file:py-2 file:rounded-lg file:border-0
                              file:bg-red-600 file:text-white
                              bg-[#111015] border border-zinc-700 rounded-lg px-2 py-1.5
                              focus:outline-none focus:ring-1 focus:ring-red-500"
                       required>
                <p class="mt-1 text-[11px] text-zinc-500">
                    Recommended: clear, high-quality JPG/PNG. This will appear in both admin and client portfolio.
                </p>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button"
                        onclick="toggleNewItemForm()"
                        class="px-4 py-2 rounded-full text-xs font-semibold bg-zinc-800 text-zinc-200 hover:bg-zinc-700">
                    Cancel
                </button>
                <button type="submit"
                        class="px-5 py-2 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold
                               shadow-[0_10px_30px_rgba(255,0,0,0.45)] hover:brightness-110 transition">
                    Save Item
                </button>
            </div>
        </form>
    </div>

    {{-- LIST TABLE --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl overflow-hidden">
        <table class="min-w-full text-sm text-zinc-100">
            <thead class="bg-[#101015] text-xs uppercase tracking-[0.16em] text-zinc-400">
                <tr>
                    <th class="px-4 py-3 text-left">Preview</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Category</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-900/80">
                @forelse($items as $item)
                    @php
                        // Support both full URLs and storage paths
                        $imgUrl = preg_match('#^https?://#', $item->image_url ?? '')
                            ? $item->image_url
                            : ($item->image_url ? asset('storage/'.$item->image_url) : null);
                    @endphp
                    <tr class="hover:bg-[#101018] transition">
                        {{-- PREVIEW --}}
                        <td class="px-4 py-3">
                            @if($imgUrl)
                                <div class="w-16 h-16 rounded-lg overflow-hidden border border-zinc-800 bg-black/60">
                                    <img src="{{ $imgUrl }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <span class="text-xs text-zinc-500">No image</span>
                            @endif
                        </td>

                        {{-- TITLE --}}
                        <td class="px-4 py-3 align-middle">
                            <div class="font-semibold text-white">
                                {{ $item->title }}
                            </div>
                            @if($item->style)
                                <div class="text-[11px] text-zinc-400">
                                    {{ $item->style }}
                                </div>
                            @endif
                        </td>

                        {{-- CATEGORY --}}
                        <td class="px-4 py-3 align-middle text-zinc-300">
                            {{ $item->category ?? 'Uncategorized' }}
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-4 py-3 align-middle text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.portfolio.edit', $item) }}"
                                   class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-xs font-semibold text-white">
                                    Edit
                                </a>

                                <form action="{{ route('admin.portfolio.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this portfolio item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-xs font-semibold text-white">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-zinc-500 text-sm">
                            No portfolio items yet. Use <span class="font-semibold text-zinc-300">Add New Item</span> to upload.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SIMPLE TOGGLE SCRIPT --}}
<script>
    function toggleNewItemForm() {
        const panel = document.getElementById('newItemPanel');
        if (!panel) return;
        panel.classList.toggle('hidden');
    }
</script>
@endsection
