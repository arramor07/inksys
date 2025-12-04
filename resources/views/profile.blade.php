<h2>Your Booking History</h2>

@forelse(auth()->user()->bookings as $booking)
    <p>{{ $booking->appointment_date }} - {{ $booking->tattoo_prompt }}</p>
@empty
    <p>No bookings yet.</p>
@endforelse
