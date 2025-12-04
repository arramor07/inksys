<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioItemController extends Controller
{

    // Central list of categories
    private array $categories = [
        'Minimalist/Fine Line',
        'Portrait',
        'Realism',
        'Traditional',
        'Japanese',
        'Script/Lettering',
        'Full Sleeve',
        'Full Back',
        'Geometric',
        'Polynesian/Tribal',
    ];

    // ADMIN: list + create form
    public function index()
    {
        $items = PortfolioItem::latest()->get();

    return view('admin.portfolio.index', [
        'items'      => $items,
        'categories' => $this->categories,
    ]);
    }

    // ADMIN: store new item
    public function store(Request $request)
    {
        $validated = $request->validate([
             'image'       => ['required', 'image', 'max:4096'],
        'title'       => ['required', 'string', 'max:255'],
        'style'       => ['nullable', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:2000'],
        'category'    => ['nullable', 'string', 'max:100'],
        ]);

        // store image in storage/app/public/portfolio
        $path = $request->file('image')->store('portfolio', 'public');

        PortfolioItem::create([
        'title'       => $validated['title'],
        'style'       => $validated['style'] ?? null,
        'description' => $validated['description'] ?? null,
        'image_url'   => $path,
        'category'    => $validated['category'] ?? null,
        ]);

        return redirect()->route('admin.portfolio')->with('success', 'Artwork uploaded.');
    }

    // ADMIN: edit form
    public function edit(PortfolioItem $item)
    {
        return view('admin.portfolio.edit', compact('item'));
    }

    // ADMIN: update item
    public function update(Request $request, PortfolioItem $item)
{
    $validated = $request->validate([
        'title'       => ['required', 'string', 'max:255'],
        'style'       => ['nullable', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:2000'],
        'category'    => ['nullable', 'string', 'max:100'],
        'image'       => ['nullable', 'image', 'max:4096'],
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('portfolio', 'public');
        $item->image_url = $path;
    }

    $item->title       = $validated['title'];
    $item->style       = $validated['style'] ?? null;
    $item->description = $validated['description'] ?? null;
    $item->category    = $validated['category'] ?? null;
    $item->save();

    return redirect()->route('admin.portfolio')->with('success', 'Artwork updated.');
}

    // ADMIN: delete item
    public function destroy(PortfolioItem $item)
    {
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }

        $item->delete();

        return redirect()->route('admin.portfolio')
            ->with('success', 'Portfolio item deleted.');
    }

    // CLIENT: public gallery page


public function publicIndex()
    {
        // Get all items for the client portfolio
        $items = PortfolioItem::orderBy('title', 'asc')->get();

        // IMPORTANT: use "portfolio.index" (resources/views/portfolio/index.blade.php)
        return view('portfolio.index', compact('items'));
    }


}
