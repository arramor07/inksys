@extends('layouts.admin')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Edit Inventory Item
            </h1>
            <p class="text-sm text-zinc-400 mt-1">
                Update this stock record and save the changes.
            </p>
        </div>

        <a href="{{ route('admin.inventory.index') }}"
           class="text-sm text-zinc-400 hover:text-zinc-200">
            ← Back to Inventory
        </a>
    </div>

    {{-- FLASH (optional) --}}
    @if (session('success'))
        <div class="mb-5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] p-5 md:p-6">

        <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- NAME --}}
<div>
    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
        Product
    </label>
    <input type="text" name="name"
           value="{{ old('name', $item->name ?? '') }}"
           class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                  focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
    @error('name')
        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- CATEGORY --}}
<div>
    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
        Category (color, type, size, scent)
    </label>
    <input type="text" name="category"
           value="{{ old('category', $item->category ?? '') }}"
           class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                  focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
    @error('category')
        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
    @enderror
</div>


            {{-- QUANTITY + UNIT --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Quantity
                    </label>
                    <input type="number" name="quantity" min="0"
                           value="{{ old('quantity', $item->quantity) }}"
                           class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                                  focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
                    @error('quantity')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                        Unit
                    </label>
                    <input type="text" name="unit"
                           value="{{ old('unit', $item->unit) }}"
                           class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                                  focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
                    @error('unit')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- LOW STOCK THRESHOLD --}}
            <div>
                <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                    Low Stock Threshold
                </label>
                <input type="number" name="low_stock_threshold" min="0"
                       value="{{ old('low_stock_threshold', $item->low_stock_threshold) }}"
                       class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                              focus:outline-none focus:ring-1 focus:ring-[#ff2455]" />
                @error('low_stock_threshold')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-zinc-500 mt-1">
                    When quantity is less than or equal to this value, the item will be marked as
                    <span class="text-amber-300">“Low stock”.</span>
                </p>
            </div>

            {{-- REMARKS --}}
            <div>
                <label class="block text-xs font-semibold text-zinc-400 mb-1 uppercase tracking-[0.16em]">
                    Remarks (optional)
                </label>
                <textarea name="remarks" rows="4"
                          class="w-full bg-[#101018] border border-zinc-800 rounded-lg px-3 py-2 text-sm text-zinc-100
                                 focus:outline-none focus:ring-1 focus:ring-[#ff2455]">{{ old('remarks', $item->remarks) }}</textarea>
                @error('remarks')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600
                               text-sm font-semibold text-white shadow-md shadow-emerald-500/40 transition">
                    Save Changes
                </button>

                <a href="{{ route('admin.inventory.index') }}"
                   class="text-sm text-zinc-400 hover:text-zinc-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
