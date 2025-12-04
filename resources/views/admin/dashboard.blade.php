@extends('layouts.admin')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
            Welcome to InkTech Admin Dashboard
        </h1>
        <p class="text-sm text-zinc-400 mt-1">
            Quick overview of bookings, clients, sales, and feedback across the system.
        </p>
    </div>

    {{-- TOP CARDS: 4-column on large screens --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total Clients --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-5 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <div class="text-xs uppercase tracking-[0.16em] text-zinc-400 mb-2">
                Total Clients
            </div>
            <div class="text-3xl font-extrabold text-[#ff2455]">
                {{ $totalClients }}
            </div>
            <p class="mt-2 text-xs text-zinc-400">
                Based on unique client emails from bookings.
            </p>
            <a href="{{ route('admin.bookings.index') }}"
               class="mt-3 inline-flex items-center text-xs text-zinc-400 hover:text-zinc-200">
                View all bookings →
            </a>
        </div>

        {{-- Bookings Today --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-5 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <div class="text-xs uppercase tracking-[0.16em] text-zinc-400 mb-2">
                Bookings Today
            </div>
            <div class="text-3xl font-extrabold text-emerald-400">
                {{ $bookingsToday }}
            </div>
            <p class="mt-2 text-xs text-zinc-400">
                Sessions scheduled for today’s date.
            </p>
            <a href="{{ route('admin.bookings.index') }}"
               class="mt-3 inline-flex items-center text-xs text-zinc-400 hover:text-zinc-200">
                Check today’s schedule →
            </a>
        </div>

        {{-- Pending Client Reviews --}}
        <a href="{{ route('admin.reviews.index') }}"
   class="block bg-[#090909] border border-zinc-900/80 rounded-2xl 
          shadow-[0_18px_50px_rgba(0,0,0,0.65)] px-5 py-4
          hover:border-sky-500/60 hover:shadow-[0_22px_60px_rgba(56,189,248,0.25)]
          transition-colors duration-150">
    <p class="text-[11px] tracking-[0.16em] uppercase text-zinc-400">
        Pending Client Reviews
    </p>

    <p class="mt-2 text-3xl font-bold text-white">
        {{ $pendingReviews }}
    </p>

    <p class="mt-1 text-xs text-zinc-400">
        Reviews waiting for your approval before showing on the website.
    </p>

    <p class="mt-3 text-xs font-semibold text-sky-300 inline-flex items-center gap-1">
        Manage client feedback →
    </p>
</a>


        {{-- Sales (Completed Sessions) --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-5 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <div class="text-xs uppercase tracking-[0.16em] text-zinc-400 mb-2">
                Sales (Completed Sessions)
            </div>
            <div class="text-3xl font-extrabold text-sky-400">
                {{ $totalSales }}
            </div>
            <p class="mt-2 text-xs text-zinc-400">
                Total completed bookings counted as successful sales.
            </p>
            <p class="mt-1 text-[11px] text-sky-300/80">
                This month: <span class="font-semibold">{{ $salesThisMonth }}</span> completed.
            </p>
        </div>
    </div>

    {{-- DAILY & WEEKLY EARNINGS --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    {{-- Today’s Earnings --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl px-5 py-4 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
        <div class="text-[11px] tracking-[0.18em] uppercase text-zinc-400 mb-2">
            Today’s Earnings
        </div>
        <div class="flex items-end justify-between">
            <div>
                <div class="text-2xl font-bold text-emerald-400">
                    {{ '₱' . number_format($todayEarnings ?? 0, 2) }}
                </div>
                <p class="text-[11px] text-zinc-500 mt-1">
                    Based on payments from sessions dated today.
                </p>
            </div>
        </div>
    </div>

    {{-- This Week’s Earnings --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl px-5 py-4 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
        <div class="text-[11px] tracking-[0.18em] uppercase text-zinc-400 mb-2">
            This Week’s Earnings
        </div>
        <div class="flex items-end justify-between">
            <div>
                <div class="text-2xl font-bold text-sky-400">
                    {{ '₱' . number_format($weekEarnings ?? 0, 2) }}
                </div>
                <p class="text-[11px] text-zinc-500 mt-1">
                    Total earnings for the current week (Mon–Sun).
                </p>
            </div>
        </div>
    </div>
</div>


    {{-- LOWER GRID: Upcoming Sessions + Monthly Analytics --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Upcoming Sessions --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-5 md:p-6 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base md:text-lg font-semibold">
                    Upcoming Sessions
                </h2>
                <span class="text-xs text-zinc-400">
                    {{ $upcomingSessions }} total
                </span>
            </div>
            <p class="text-xs text-zinc-400 mb-4">
                This counts all bookings dated today and later. Use the Bookings page to view full details.
            </p>
            <a href="{{ route('admin.bookings.index') }}"
               class="inline-flex w-full md:w-auto justify-center items-center px-4 py-2.5 rounded-full
                      bg-zinc-100/5 hover:bg-zinc-100/10 text-xs font-semibold text-zinc-100
                      border border-zinc-700/80 transition">
                Go to Bookings Table
            </a>
        </div>

        {{-- Monthly Analytics (Bookings + Sales) --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-5 md:p-6 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="text-base md:text-lg font-semibold">
                        Monthly Analytics
                    </h2>
                    <p class="text-xs text-zinc-400">
                        Bookings & sales per month ({{ $currentYear }}), based on appointment dates.
                    </p>
                </div>
                <div class="flex items-center gap-3 text-[11px] text-zinc-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block w-3 h-1.5 rounded-full bg-[#ff2455]"></span> Bookings
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block w-3 h-1.5 rounded-full bg-sky-400"></span> Sales
                    </span>
                </div>
            </div>

            <div class="h-64">
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bookingsChart').getContext('2d');

        const monthlyBookings = @json($monthlyBookings); // [Jan..Dec]
        const monthlySales    = @json($monthlySales);    // [Jan..Dec]

        const labels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Bookings',
                        data: monthlyBookings,
                        borderColor: '#ff2455',
                        backgroundColor: 'rgba(255,36,85,0.18)',
                        borderWidth: 2,
                        tension: 0.35,
                        fill: true,
                        pointRadius: 3,
                        pointHoverRadius: 4
                    },
                    {
                        label: 'Sales (Completed)',
                        data: monthlySales,
                        borderColor: '#38bdf8', // blue / sky
                        backgroundColor: 'rgba(56,189,248,0.18)',
                        borderWidth: 2,
                        tension: 0.35,
                        fill: true,
                        pointRadius: 3,
                        pointHoverRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false  // we show our own mini legend in the header
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#020617',
                        titleColor: '#e5e7eb',
                        bodyColor: '#e5e7eb',
                        borderColor: '#1f2937',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 10 }
                        },
                        grid: {
                            color: 'rgba(55,65,81,0.35)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(31,41,55,0.6)'
                        }
                    }
                }
            }
        });
    </script>
@endpush
