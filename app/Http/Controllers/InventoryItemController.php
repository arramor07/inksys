<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        $items = InventoryItem::orderBy('name')->get();
        return view('admin.inventory.index', compact('items'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'category'           => ['nullable', 'string', 'max:255'],
            'quantity'           => ['required', 'integer', 'min:0'],
            'low_stock_threshold'=> ['required', 'integer', 'min:0'],
            'unit'               => ['required', 'string', 'max:50'],
            'remarks'            => ['nullable', 'string'],
        ]);

        InventoryItem::create($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item added.');
    }

    public function edit(InventoryItem $item)
{
    return view('admin.inventory.edit', compact('item'));
}

    public function update(Request $request, InventoryItem $item)
{
    $validated = $request->validate([
        'name'               => ['required', 'string', 'max:255'],
        'category'           => ['nullable', 'string', 'max:255'],
        'quantity'           => ['required', 'integer', 'min:0'],
        'low_stock_threshold'=> ['required', 'integer', 'min:0'],
        'unit'               => ['required', 'string', 'max:50'],
        'remarks'            => ['nullable', 'string'],
    ]);

    $item->update($validated);

    return redirect()->route('admin.inventory.index')
        ->with('success', 'Inventory item updated.');
}

    public function destroy(InventoryItem $item)
{
    $item->delete();

    return redirect()->route('admin.inventory.index')
        ->with('success', 'Inventory item deleted.');
}
}
