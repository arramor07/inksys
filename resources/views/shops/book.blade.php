@extends('layouts.app')

@section('content')

<section class="bg-gradient-to-b from-black via-[#050509] to-black min-h-screen py-10">

<div class="max-w-xl mx-auto bg-[#101015] border border-zinc-800 rounded-2xl p-6 text-white">

<h1 class="text-2xl font-bold mb-2">
Book Appointment
</h1>

<p class="text-zinc-400 text-sm mb-6">
Fill in your details and choose your preferred schedule.
</p>

<form action="{{ route('book.store') }}" method="POST">
@csrf

<input type="hidden" name="shop_id" value="{{ $shop->id }}">

<div class="mb-3">
<input type="text" name="name"
class="w-full px-4 py-2 rounded bg-zinc-900 border border-zinc-700"
placeholder="Full Name" required>
</div>

<div class="mb-3">
<input type="email" name="email"
class="w-full px-4 py-2 rounded bg-zinc-900 border border-zinc-700"
placeholder="Email Address" required>
</div>

<div class="mb-3">
<input type="text" name="phone"
class="w-full px-4 py-2 rounded bg-zinc-900 border border-zinc-700"
placeholder="Phone Number">
</div>

<div class="grid grid-cols-2 gap-3 mb-3">

<input type="date" name="appointment_date"
class="px-4 py-2 rounded bg-zinc-900 border border-zinc-700" required>

<input type="time" name="appointment_time"
class="px-4 py-2 rounded bg-zinc-900 border border-zinc-700" required>

</div>

<textarea name="additional_message"
class="w-full px-4 py-2 rounded bg-zinc-900 border border-zinc-700"
placeholder="Tattoo details, size, placement, etc"></textarea>

<button type="submit"
class="w-full mt-4 py-2 bg-red-600 rounded-full font-semibold">
Submit Booking
</button>

</form>

</div>
</section>

@endsection