<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    /**
     * Show pending + approved reviews for admin/assistant admin.
     */
    public function index()
    {
        $pendingReviews = Review::where('is_visible', false)
            ->orderByDesc('created_at')
            ->get();

        $approvedReviews = Review::where('is_visible', true)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    /**
     * Approve a pending review (make it visible on public page).
     */
    public function approve(Review $review)
    {
        $review->is_visible = true;
        $review->save();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review has been approved and published.');
    }

    /**
     * Hide a published review (keep it in DB but not visible publicly).
     */
    public function hide(Review $review)
    {
        $review->is_visible = false;
        $review->save();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review has been hidden from the public page.');
    }

    /**
     * Permanently delete a review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review has been deleted.');
    }
}
