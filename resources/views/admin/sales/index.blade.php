@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl md:text-3xl font-extrabold mb-2">
        Sales & Completed Sessions
    </h1>
    <p class="text-sm text-zinc-400 mb-6">
        Overview of completed tattoo sessions, downpayments, and total sales performance.
    </p>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="mb-5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- TOP STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- TOTAL SALES (completed sessions count) --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-4 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <p class="text-[11px] uppercase tracking-[0.16em] text-zinc-400 mb-1">
                Total Sales (Completed Sessions)
            </p>
            <p class="text-3xl font-bold text-slate-50">
                {{ $totalCompletedSessions }}
            </p>
            <p class="text-xs text-zinc-500 mt-1">
                Based on all bookings marked as <span class="text-emerald-400 font-semibold">completed</span>.
            </p>
        </div>

        {{-- TODAY --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-4 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <p class="text-[11px] uppercase tracking-[0.16em] text-zinc-400 mb-1">
                Today
            </p>
            <p class="text-3xl font-bold text-slate-50">
                {{ $completedToday }}
            </p>
            <p class="text-xs text-zinc-500 mt-1">
                Sessions completed for today’s appointment date.
            </p>
        </div>

        {{-- THIS MONTH --}}
        <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl p-4 shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
            <p class="text-[11px] uppercase tracking-[0.16em] text-zinc-400 mb-1">
                This Month
            </p>
            <p class="text-3xl font-bold text-slate-50">
                {{ $completedThisMonth }}
            </p>
            <p class="text-xs text-zinc-500 mt-1">
                Completed sessions for {{ now()->format('F Y') }}.
            </p>
        </div>
    </div>

    {{-- APPROVED SESSIONS (DOWNPAYMENTS) --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)] mb-8">
        <div class="flex items-center justify-between px-5 pt-4 pb-3 border-b border-zinc-800/80">
            <div>
                <h2 class="text-sm font-semibold text-slate-100">
                    Approved Sessions (Downpayments)
                </h2>
                <p class="text-[11px] text-zinc-500 mt-1">
                    Once a booking is approved, record the downpayment and payment method here.
                </p>
            </div>
        </div>

        @if($approvedBookings->isEmpty())
            <div class="px-5 py-4 text-sm text-zinc-500">
                No approved bookings yet.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-[0.16em] text-zinc-400 border-b border-zinc-800">
                            <th class="text-left py-3 px-5">Client</th>
                            <th class="text-left py-3 px-5">Contact</th>
                            <th class="text-left py-3 px-5">Date &amp; Time</th>
                            <th class="text-left py-3 px-5">Service / Prompt</th>
                            <th class="text-left py-3 px-5">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-900/80">
                        @foreach($approvedBookings as $booking)
                            <tr class="hover:bg-[#101018] transition">
                                <td class="py-3 px-5 align-top text-slate-100 font-semibold">
                                    {{ $booking->name }}
                                </td>
                                <td class="py-3 px-5 align-top text-zinc-300">
                                    {{ $booking->email }}
                                </td>
                                <td class="py-3 px-5 align-top text-zinc-200">
                                    {{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}<br>
                                    <span class="text-xs text-zinc-500">
                                        {{ \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A') }}
                                    </span>
                                </td>
                                <td class="py-3 px-5 align-top">
                                    <div class="text-slate-100 text-sm font-semibold">
                                        {{ $booking->service ?? 'Custom Tattoo' }}
                                    </div>
                                    @if($booking->tattoo_prompt)
                                        <p class="text-xs text-zinc-400 mt-1 line-clamp-3">
                                            "{{ $booking->tattoo_prompt }}"
                                        </p>
                                    @endif
                                </td>
                                <td class="py-3 px-5 align-top">
                                    <p class="text-[11px] text-zinc-500 mb-1">
                                        Set payment method and downpayment amount.
                                    </p>

                                    <form action="{{ route('admin.sales.downpayment', $booking) }}" method="POST"
                                          class="flex flex-col sm:flex-row sm:items-center gap-2">
                                        @csrf

                                        <select name="payment_method"
                                                class="bg-[#101018] border border-zinc-700 rounded-lg px-2.5 py-1.5 text-xs text-slate-100 focus:outline-none focus:ring-1 focus:ring-[#ff2455]">
                                            <option value="cash"  {{ $booking->payment_method === 'cash'  ? 'selected' : '' }}>Cash</option>
                                            <option value="gcash" {{ $booking->payment_method === 'gcash' ? 'selected' : '' }}>GCash</option>
                                        </select>

                                        <div class="flex items-center bg-[#101018] border border-zinc-700 rounded-lg px-2.5 py-1.5">
                                            <span class="text-xs text-zinc-400 mr-1">₱</span>
                                            <input type="number" step="0.01" min="0" name="downpayment_amount"
                                                   value="{{ old('downpayment_amount', $booking->downpayment_amount) }}"
                                                   class="bg-transparent border-0 text-xs text-slate-100 focus:outline-none w-24"
                                                   placeholder="0.00">
                                        </div>

                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-[11px] font-semibold
                                                       bg-emerald-500 hover:bg-emerald-600 text-white
                                                       shadow-sm shadow-emerald-500/40 transition">
                                            Save
                                        </button>
                                    </form>

                                    @if($booking->downpayment_amount)
                                        <p class="text-[11px] text-emerald-300 mt-1">
                                            Existing downpayment: ₱ {{ number_format($booking->downpayment_amount, 2) }}
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- COMPLETED SESSIONS (SALES LIST) --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_18px_50px_rgba(0,0,0,0.65)]">
        <div class="flex items-center justify-between px-5 pt-4 pb-3 border-b border-zinc-800/80">
            <div>
                <h2 class="text-sm font-semibold text-slate-100">
                    Completed Sessions (Sales List)
                </h2>
                <p class="text-[11px] text-zinc-500 mt-1">
                    Showing latest completed bookings. Use this to review full payments and sales totals.
                </p>
            </div>
        </div>

        @if($completedBookings->isEmpty())
            <div class="px-5 py-4 text-sm text-zinc-500">
                No completed bookings yet.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-[0.16em] text-zinc-400 border-b border-zinc-800">
                            <th class="text-left py-3 px-5">Client</th>
                            <th class="text-left py-3 px-5">Contact</th>
                            <th class="text-left py-3 px-5">Date &amp; Time</th>
                            <th class="text-left py-3 px-5">Service / Prompt</th>
                            <th class="text-left py-3 px-5">Payment Method</th>
                            <th class="text-left py-3 px-5">Payments</th>
                            <th class="text-left py-3 px-5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-900/80">
                        @foreach($completedBookings as $booking)
                            @php
                                $down  = $booking->downpayment_amount ?? 0;
                                $final = $booking->final_payment_amount ?? 0;
                                $total = $down + $final;
                            @endphp

                            <tr class="hover:bg-[#101018] transition">
                                <td class="py-3 px-5 align-top text-slate-100 font-semibold">
                                    {{ $booking->name }}
                                </td>
                                <td class="py-3 px-5 align-top text-zinc-300">
                                    {{ $booking->email }}
                                </td>
                                <td class="py-3 px-5 align-top text-zinc-200">
                                    {{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}<br>
                                    <span class="text-xs text-zinc-500">
                                        {{ \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A') }}
                                    </span>
                                </td>
                                <td class="py-3 px-5 align-top">
                                    <div class="text-slate-100 text-sm font-semibold">
                                        {{ $booking->service ?? 'Custom Tattoo' }}
                                    </div>
                                    @if($booking->tattoo_prompt)
                                        <p class="text-xs text-zinc-400 mt-1 line-clamp-3">
                                            "{{ $booking->tattoo_prompt }}"
                                        </p>
                                    @endif
                                </td>

                                {{-- PAYMENT METHOD --}}
                                <td class="py-3 px-5 align-top">
                                    @if($booking->payment_method)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                                                   bg-sky-500/10 text-sky-300 border border-sky-500/40">
                                            {{ strtoupper($booking->payment_method) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-zinc-500">Not set</span>
                                    @endif
                                </td>

                                {{-- PAYMENTS --}}
                                <td class="py-3 px-5 align-top">
                                    @if($down)
                                        <p class="text-[11px] text-emerald-300">
                                            Downpayment: ₱ {{ number_format($down, 2) }}
                                        </p>
                                    @else
                                        <p class="text-[11px] text-zinc-500">
                                            No downpayment recorded for this booking.
                                        </p>
                                    @endif

                                    @if($final)
                                        <p class="text-[11px] text-emerald-300 mt-1">
                                            Paid on completion: ₱ {{ number_format($final, 2) }}
                                        </p>
                                        <p class="text-[11px] text-slate-100 mt-1">
                                            <span class="text-zinc-400">Total from this client:</span>
                                            ₱ {{ number_format($total, 2) }}
                                        </p>
                                    @else
                                        <p class="text-[11px] text-zinc-500 mt-1">
                                            Type the amount paid on the day this session was completed.
                                            @if($down)
                                                Existing downpayment: <span class="text-emerald-300">
                                                    ₱ {{ number_format($down, 2) }}
                                                </span>
                                            @endif
                                        </p>

                                        <form action="{{ route('admin.sales.final-payment', $booking) }}"
                                              method="POST"
                                              class="mt-2 flex flex-col sm:flex-row sm:items-center gap-2">
                                            @csrf

                                            <div class="flex items-center bg-[#101018] border border-zinc-700 rounded-lg px-2.5 py-1.5">
                                                <span class="text-xs text-zinc-400 mr-1">₱</span>
                                                <input type="number" step="0.01" min="0" name="final_payment_amount"
                                                       class="bg-transparent border-0 text-xs text-slate-100 focus:outline-none w-24"
                                                       placeholder="0.00">
                                            </div>

                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg text-[11px] font-semibold
                                                           bg-emerald-500 hover:bg-emerald-600 text-white
                                                           shadow-sm shadow-emerald-500/40 transition">
                                                Save
                                            </button>
                                        </form>
                                    @endif
                                </td>

                                {{-- STATUS PILL --}}
                                <td class="py-3 px-5 align-top">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px]
                                                bg-emerald-500/10 text-emerald-300 border border-emerald-500/50">
                                        Completed
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
