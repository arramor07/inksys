@component('mail::message')
# Hi {{ $booking->name }},

This is an update about your tattoo booking with **InkTech**.

@php
    $status = ucfirst($booking->status);
@endphp

**Current status:** {{ $status }}

@switch($booking->status)
    @case('approved')
        Your booking has been **approved** ✅  
        We’ll be expecting you on:

        **Date:** {{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}  
        **Time:** {{ \Carbon\Carbon::parse($booking->appointment_time)->format('h:i A') }}

        If you need to reschedule, kindly contact us as soon as possible.
        @break

    @case('rejected')
        Unfortunately, your booking has been **rejected** ❌.  
        This may be due to schedule conflicts or other reasons.

        You may try booking again on another available date.
        @break

    @default
        Your booking is currently **pending** ⏳.  
        We’ll notify you once it is approved or rejected.
@endswitch

---

**Booking details**

- **Service / Style:** {{ $booking->service ?? 'Custom Tattoo' }}
- **Tattoo idea / prompt:** {{ $booking->tattoo_prompt ?? 'N/A' }}
- **Email used:** {{ $booking->email }}

Thanks for choosing **InkTech Tattoo Studio**!  
@endcomponent
