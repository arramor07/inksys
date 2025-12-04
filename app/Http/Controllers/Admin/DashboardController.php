<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $year  = $today->year;

        /* =======================
         * TOP METRICS
         * ======================= */

        // Unique client emails
        $totalClients = Booking::distinct('email')->count('email');

        // Bookings scheduled for TODAY
        $bookingsToday = Booking::whereDate('appointment_date', $today)->count();

        // ---------- PENDING CLIENT REVIEWS ----------
// Try several common column setups so the count is accurate.
if (Schema::hasColumn('reviews', 'status')) {
    // status column, e.g. 'pending' / 'approved'
    $pendingReviews = Review::where('status', 'pending')->count();

} elseif (Schema::hasColumn('reviews', 'is_approved')) {
    // boolean is_approved column
    $pendingReviews = Review::where(function ($q) {
        $q->where('is_approved', false)
          ->orWhereNull('is_approved');
    })->count();

} elseif (Schema::hasColumn('reviews', 'approved')) {
    // sometimes people use 'approved' tinyint(1)
    $pendingReviews = Review::where(function ($q) {
        $q->where('approved', false)
          ->orWhereNull('approved');
    })->count();

} else {
    // Unknown schema – safer to show 0 than a wrong number
    $pendingReviews = 0;
}


        // Upcoming sessions (today and later)
        $upcomingSessions = Booking::whereDate('appointment_date', '>=', $today)->count();


        /* =======================
         * SALES / EARNINGS
         * ======================= */

        // Completed sessions = “sales”
        $totalCompletedSessions = Booking::where('status', 'completed')->count();

        $completedThisMonth = Booking::where('status', 'completed')
            ->whereYear('appointment_date', $year)
            ->whereMonth('appointment_date', $today->month)
            ->count();

        // TOTAL earnings (all time)
        $totalEarnings = Booking::select(
            DB::raw("SUM(COALESCE(downpayment_amount,0) + COALESCE(final_payment_amount,0)) as total")
        )->value('total') ?? 0;

        // Earnings for current month
        $currentMonthEarnings = Booking::whereYear('appointment_date', $year)
            ->whereMonth('appointment_date', $today->month)
            ->sum(DB::raw("COALESCE(downpayment_amount,0) + COALESCE(final_payment_amount,0)"));

        // 🔹 NEW: Today’s earnings
        $todayEarnings = Booking::whereDate('appointment_date', $today)
            ->sum(DB::raw("COALESCE(downpayment_amount,0) + COALESCE(final_payment_amount,0)"));

        // 🔹 NEW: This week’s earnings (Mon–Sun by default)
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek   = $today->copy()->endOfWeek();

        $weekEarnings = Booking::whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
            ->sum(DB::raw("COALESCE(downpayment_amount,0) + COALESCE(final_payment_amount,0)"));


        /* =======================
         * MONTHLY ANALYTICS
         * ======================= */

        // Initialize 12 months with zeros
        $monthlyBookings   = array_fill(1, 12, 0);
        $monthlySales      = array_fill(1, 12, 0);   // count of completed sessions
        $monthlySalesPeso  = array_fill(1, 12, 0.0); // earnings in ₱

        // All bookings per month
        $bookingsPerMonth = Booking::selectRaw('MONTH(appointment_date) as month, COUNT(*) as total')
            ->whereYear('appointment_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($bookingsPerMonth as $month => $count) {
            $monthlyBookings[$month] = $count;
        }

        // Completed sessions per month (count)
        $salesPerMonth = Booking::selectRaw('MONTH(appointment_date) as month, COUNT(*) as total')
            ->whereYear('appointment_date', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($salesPerMonth as $month => $count) {
            $monthlySales[$month] = $count;
        }

        // Earnings per month (₱)
        $salesPesoPerMonth = Booking::selectRaw('
                MONTH(appointment_date) as month,
                SUM(COALESCE(downpayment_amount,0) + COALESCE(final_payment_amount,0)) as total
            ')
            ->whereYear('appointment_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($salesPesoPerMonth as $month => $total) {
            $monthlySalesPeso[$month] = (float) $total;
        }

        /* =======================
         * RETURN VIEW
         * ======================= */

        return view('admin.dashboard', [
            // clients / bookings
            'totalClients'         => $totalClients,
            'bookingsToday'        => $bookingsToday,
            'pendingReviews'       => $pendingReviews,
            'upcomingSessions'     => $upcomingSessions,

            // sales (count)
            'totalSales'           => $totalCompletedSessions,
            'salesThisMonth'       => $completedThisMonth,

            // earnings
            'totalEarnings'        => $totalEarnings,
            'currentMonthEarnings' => $currentMonthEarnings,
            'todayEarnings'        => $todayEarnings,   // 🔹 new
            'weekEarnings'         => $weekEarnings,    // 🔹 new

            // chart data
            'monthlyBookings'      => array_values($monthlyBookings),
            'monthlySales'         => array_values($monthlySales),     // still there if view uses it
            'monthlySalesPeso'     => array_values($monthlySalesPeso), // ₱ line (blue)
            'currentYear'          => $year,
        ]);
    }
}
