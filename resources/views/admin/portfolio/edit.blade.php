@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Edit Artwork
            </h1>
            <p class="text-sm text-zinc-400 mt-1">
                Update details or replace the artwork image.
            </p>
        </div>
    </div>

    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] p-5 md:p-6">
        <form action="{{ route('admin.portfolio.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                            Replace Image (optional)
                        </label>
                        <input type="file" name="image"
                               class="w-full text-sm file:mr-3 file:px-3 file:py-1.5 file:rounded-md file:border-0
                                      file:bg-[#18181f] file:text-zinc-200 file:text-xs
                                      bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-zinc-200 focus:outline-none focus:ring-1 focus:ring-[#ff2455]">
                        @error('image')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <input type="text" name="title" value="{{ old('title', $item->title) }}"
                               placeholder="Title"
                               class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                                      focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
                        @error('title')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <input type="text" name="style" value="{{ old('style', $item->style) }}"
                               placeholder="Style / Price"
                               class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                                      focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
                        @error('style')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <textarea name="description" rows="4"
                                  placeholder="Description"
                                  class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                                         focus:outline-none focus:ring-1 focus:ring-[#ff2455]">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border border-zinc-800 rounded-2xl bg-[#050509] overflow-hidden">
                    <div class="aspect-[4/3] bg-black/70">
                        @if ($item->image_url)
                            <img src="{{ asset('storage/'.$item->image_url) }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-zinc-500">
                                No Image
                            </div>
                        @endif
                    </div>
                    <div class="px-4 py-3">
                        <div class="text-sm font-semibold text-slate-100">
                            {{ $item->title }}
                        </div>
                        @if($item->style)
                            <div class="text-xs text-[#ff2455] mt-0.5">
                                {{ $item->style }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600
                               text-sm font-semibold text-white shadow-md shadow-emerald-500/40 transition">
                    Save Changes
                </button>

                <a href="{{ route('admin.portfolio') }}"
                   class="text-sm text-zinc-400 hover:text-zinc-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
