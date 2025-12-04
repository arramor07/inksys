@extends('layouts.app')

@section('content')
<div class="bg-black min-h-[calc(100vh-4rem)] pt-10 pb-16">
    <div class="max-w-xl mx-auto px-6 text-white">
        <h1 class="text-2xl font-bold mb-4">Edit Review</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/40 text-red-200 text-sm rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs text-slate-300 mb-1 block">Client Name</label>
                <input type="text" name="client_name"
                       value="{{ old('client_name', $review->client_name) }}"
                       class="w-full px-4 py-2 rounded-lg bg-[#181818] border border-[#262626] text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-300 mb-1 block">Rating (1–5)</label>
                <input type="number" name="rating" min="1" max="5"
                       value="{{ old('rating', $review->rating) }}"
                       class="w-full px-4 py-2 rounded-lg bg-[#181818] border border-[#262626] text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-300 mb-1 block">Review Text</label>
                <textarea name="content" rows="4"
                          class="w-full px-4 py-2 rounded-lg bg-[#181818] border border-[#262626] text-sm">{{ old('content', $review->content) }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_visible" name="is_visible" class="rounded border-[#444]"
                       {{ old('is_visible', $review->is_visible) ? 'checked' : '' }}>
                <label for="is_visible" class="text-xs text-slate-300">Show on public page</label>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('admin.reviews.index') }}"
                   class="px-4 py-2 text-xs rounded-full border border-slate-500 text-slate-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 text-xs rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
