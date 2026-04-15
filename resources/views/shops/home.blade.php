@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-black via-[#050509] to-black min-h-[calc(100vh-4rem)] py-10">
<div class="max-w-6xl mx-auto px-4 text-white">

<h1 class="text-4xl font-extrabold mb-2">
    {{ $shop->name }}
</h1>

<p class="text-zinc-400 mb-6">
    {{ $shop->description }}
</p>

{{-- FEATURED TATTOOS --}}
<h2 class="text-2xl font-bold mb-4">Featured Tattoos</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
@foreach($featuredTattoos as $tattoo)

<div class="bg-[#0d0d0f] border border-zinc-800 rounded-xl overflow-hidden">
<img src="{{ asset('storage/'.$tattoo->image) }}" class="w-full h-48 object-cover">

<div class="p-4">
<h3 class="font-semibold text-lg">{{ $tattoo->name }}</h3>

<button
onclick="openBookingModal('{{ $tattoo->name }}')"
class="mt-3 px-4 py-2 bg-red-600 rounded-full text-sm">
Book this design
</button>

</div>
</div>

@endforeach
</div>

</div>
</section>
@endsection