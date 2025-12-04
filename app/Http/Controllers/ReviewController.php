<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // CLIENT: show approved reviews + form
    public function index()
    {
        $reviews = Review::where('is_visible', true)
            ->latest()
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    // CLIENT: submit a new review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'rating'      => ['required', 'integer', 'min:1', 'max:5'],
            'content'     => ['required', 'string', 'max:1000'],
        ]);

        Review::create([
            'client_name' => $validated['client_name'],
            'rating'      => $validated['rating'],
            'content'     => $validated['content'],
            'is_visible'  => false,   // pending, admin must approve
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Thank you for your feedback! Your review is awaiting approval.');
    }

    // ADMIN: list pending + approved reviews
    public function adminIndex()
    {
        $pendingReviews  = Review::where('is_visible', false)->latest()->get();
        $approvedReviews = Review::where('is_visible', true)->latest()->get();

        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    // ADMIN: approve (show on client side)
    public function approve(Review $review)
    {
        $review->update(['is_visible' => true]);

        return back()->with('success', 'Review approved and now visible on the site.');
    }

    // ADMIN: hide (remove from client side)
    public function hide(Review $review)
    {
        $review->update(['is_visible' => false]);

        return back()->with('success', 'Review hidden from the public page.');
    }

    // ADMIN: delete
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
