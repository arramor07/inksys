<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        // Completed sessions (for final payment / overview)
        $completedBookings = Booking::where('status', 'completed')
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        // Approved sessions (for downpayment)
        $approvedBookings = Booking::where('status', 'approved')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Stats for cards at the top
        $totalCompletedSessions = $completedBookings->count();

        $today = now()->toDateString();

        $completedToday = Booking::where('status', 'completed')
            ->whereDate('appointment_date', $today)
            ->count();

        $completedThisMonth = Booking::where('status', 'completed')
            ->whereYear('appointment_date', now()->year)
            ->whereMonth('appointment_date', now()->month)
            ->count();

        return view('admin.sales.index', compact(
            'completedBookings',
            'approvedBookings',
            'totalCompletedSessions',
            'completedToday',
            'completedThisMonth'
        ));
    }

    // Save / update downpayment for APPROVED bookings
    public function storeDownpayment(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'payment_method'      => ['required', 'in:cash,gcash'],
            'downpayment_amount'  => ['required', 'numeric', 'min:0'],
        ]);

        $booking->payment_method     = $data['payment_method'];
        $booking->downpayment_amount = $data['downpayment_amount'];
        $booking->save();

        return back()->with('success', 'Downpayment saved for ' . $booking->name . '.');
    }

    // Save / update final payment for COMPLETED bookings
    public function storeFinalPayment(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'final_payment_amount' => ['required', 'numeric', 'min:0'],
        ]);

        // Optional: allow payment method override here if needed
        if ($request->filled('payment_method')) {
            $request->validate([
                'payment_method' => ['in:cash,gcash'],
            ]);
            $booking->payment_method = $request->payment_method;
        }

        $booking->final_payment_amount = $data['final_payment_amount'];
        $booking->save();

        return back()->with('success', 'Final payment saved for ' . $booking->name . '.');
    }
}
