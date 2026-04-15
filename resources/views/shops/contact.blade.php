@extends('layouts.app')

@section('content')

<section class="bg-black min-h-screen py-10 text-white">

<div class="max-w-4xl mx-auto">

<h1 class="text-3xl font-bold mb-6">
Contact {{ $shop->name }}
</h1>

<div class="bg-[#101015] border border-zinc-800 p-6 rounded-xl">

<p class="mb-3">
<strong>Address:</strong> {{ $shop->address }}
</p>

<p class="mb-3">
<strong>Phone:</strong> {{ $shop->phone }}
</p>

<p class="mb-3">
<strong>Email:</strong> {{ $shop->email }}
</p>

<p class="mb-3">
<strong>Instagram:</strong> {{ $shop->instagram }}
</p>

</div>

</div>
</section>

@endsection