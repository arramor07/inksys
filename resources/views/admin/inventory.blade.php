@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-extrabold mb-6">Inventory</h1>

    {{-- Add item form (UI only) --}}
    <form class="space-y-3 mb-8">
        <input type="text" placeholder="Item Name"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <input type="number" placeholder="Quantity"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <input type="text" placeholder="Supplier"
               class="w-full text-xs bg-[#111111] border border-[#222] rounded-md px-3 py-2 text-slate-200">

        <button type="button"
                class="w-full bg-[#19c45b] hover:bg-[#16a94d] text-xs font-semibold text-black py-2 rounded-md">
            Add Item
        </button>
    </form>

    {{-- Inventory table --}}
    <div class="bg-[#111111] rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full text-xs text-left text-slate-200">
            <thead class="bg-[#151515] text-slate-300">
                <tr>
                    <th class="px-5 py-3">Item</th>
                    <th class="px-5 py-3">Quantity</th>
                    <th class="px-5 py-3">Supplier</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-[#1c1c1c]">
                    <td class="px-5 py-3">Ink (Black)</td>
                    <td class="px-5 py-3">3</td>
                    <td class="px-5 py-3">Tattoo Supplies Co.</td>
                    <td class="px-5 py-3 text-amber-300 text-xs">⚠ Low Stock</td>
                </tr>
                <tr class="border-t border-[#1c1c1c]">
                    <td class="px-5 py-3">Needles</td>
                    <td class="px-5 py-3">50</td>
                    <td class="px-5 py-3">ProNeedle</td>
                    <td class="px-5 py-3 text-emerald-300 text-xs">✓ OK</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
