<h3>Your Bookings</h3>

@foreach(auth()->user()->bookings as $booking)
    <div class="p-2 border-b">
        {{ $booking->appointment_date }} at
        {{ $booking->appointment_time }}
    </div>
@endforeach
