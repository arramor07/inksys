@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow rounded-xl p-6">
    <h1 class="text-2xl font-bold mb-4">Add Tattoo to Portfolio</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.portfolio.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" name="title"
                   value="{{ old('title') }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Style (optional)</label>
            <input type="text" name="style"
                   value="{{ old('style') }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image URL</label>
            <input type="url" name="image_url"
                   value="{{ old('image_url') }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
                   placeholder="https://example.com/your-tattoo.jpg"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description (optional)</label>
            <textarea name="description" rows="4"
                      class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.portfolio.index') }}"
               class="text-sm px-4 py-2 border border-slate-300 rounded-lg">
                Cancel
            </a>
            <button type="submit"
                    class="text-sm px-4 py-2 bg-sky-600 text-white rounded-lg">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
