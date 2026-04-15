@extends('layouts.app')

@section('content')

<section class="bg-black min-h-screen py-10 text-white">

<div class="max-w-4xl mx-auto">

<h1 class="text-3xl font-bold mb-6">
Customer Reviews
</h1>

@if($reviews->count())

@foreach($reviews as $review)

<div class="bg-[#101015] border border-zinc-800 rounded-xl p-4 mb-4">

<h3 class="font-semibold">
{{ $review->name }}
</h3>

<p class="text-zinc-400 text-sm mb-2">
Rating: ⭐ {{ $review->rating }}/5
</p>

<p>
{{ $review->comment }}
</p>

</div>

@endforeach

@else

<p class="text-zinc-500">
No reviews yet.
</p>

@endif

</div>

</section>

@endsection