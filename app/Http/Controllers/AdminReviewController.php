<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $pendingReviews = Review::where('is_visible', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedReviews = Review::where('is_visible', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_visible' => true]);

        return back()->with('success', 'Review approved and now visible on the site.');
    }

    public function hide(Review $review)
    {
        $review->update(['is_visible' => false]);

        return back()->with('success', 'Review hidden from the public page.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted permanently.');
    }
}
