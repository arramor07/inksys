@extends('layouts.admin')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                Inventory Manager
            </h1>
            <p class="text-sm text-zinc-400 mt-1">
                Track needles, inks, equipment, and other studio items.
            </p>
        </div>

        <a href="{{ route('admin.inventory.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#2563eb] hover:bg-[#1d4ed8]
                  text-sm font-semibold text-white px-4 py-2.5 shadow-md shadow-blue-500/30 transition">
            <span class="text-lg leading-none">＋</span>
            <span>Add Item</span>
        </a>
    </div>

    {{-- MAIN CARD --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] p-5 md:p-6">

        @if ($items->isEmpty())
            <div class="rounded-xl border border-dashed border-zinc-700/70 bg-[#0b0b0f] px-4 py-10 text-center">
                <p class="text-sm text-zinc-400">
                    No inventory records yet.
                </p>
                <p class="text-xs text-zinc-500 mt-1">
                    Click <span class="font-semibold text-slate-200">“Add Item”</span> to create your first stock entry.
                </p>
            </div>
        @else
            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
    <tr class="text-xs uppercase tracking-[0.16em] text-zinc-400 border-b border-zinc-800">
        
        <th class="text-left py-3 pr-4">Item</th>
        <th class="text-left py-3 px-4">Category</th>
        <th class="text-left py-3 px-4">Quantity</th>
        <th class="text-left py-3 px-4">Status</th>
        <th class="text-left py-3 px-4">Last Updated</th>
        <th class="text-right py-3 pl-4 pr-2">Actions</th>
    </tr>
</thead>

                    <tbody class="divide-y divide-zinc-900/80">
                        @foreach ($items as $item)
    @php
        $isLow = $item->low_stock_threshold !== null
                  && $item->quantity <= $item->low_stock_threshold;
    @endphp

    <tr class="hover:bg-[#101018] transition">
        {{-- NAME --}}
        <td class="py-3 pr-4">
            <div class="font-semibold text-slate-100">
                {{ $item->name }}
            </div>
            @if ($item->remarks)
                <div class="text-[11px] text-zinc-500 mt-0.5 line-clamp-1">
                    {{ $item->remarks }}
                </div>
            @endif
        </td>

        {{-- CATEGORY --}}
        <td class="py-3 px-4 text-zinc-300">
            {{ $item->category ?? '—' }}
        </td>

        {{-- QUANTITY --}}
        <td class="py-3 px-4 text-zinc-200">
            {{ $item->quantity }}
            <span class="text-zinc-400 text-xs">{{ $item->unit }}</span>
        </td>

        {{-- STATUS --}}
        <td class="py-3 px-4">
            @if ($isLow)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                            bg-amber-500/15 text-amber-300 border border-amber-500/50">
                    Low stock
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                            bg-emerald-500/10 text-emerald-300 border border-emerald-500/40">
                    In stock
                </span>
            @endif
        </td>

        {{-- LAST UPDATED --}}
        <td class="py-3 px-4 text-zinc-400 text-sm">
            {{ $item->updated_at->format('M d, Y — h:i A') }}
        </td>

        {{-- ACTIONS --}}
        <td class="py-3 pl-4 pr-2 text-right">
            <div class="inline-flex gap-2">
                <a href="{{ route('admin.inventory.edit', $item->id) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold
                          bg-zinc-800 hover:bg-zinc-700 text-slate-100 border border-zinc-700/80 transition">
                    Edit
                </a>

                <form action="{{ route('admin.inventory.destroy', $item->id) }}"
                      method="POST" onsubmit="return confirm('Delete this item?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                   bg-red-500 hover:bg-red-600 text-white shadow-sm shadow-red-500/40 transition">
                        Delete
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach

                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
