@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto py-16">

<h2 class="text-3xl font-bold mb-6 text-center">
Register Your Tattoo Shop
</h2>

<form method="POST" action="{{ route('shops.register') }}" enctype="multipart/form-data" class="space-y-4">

@csrf

<input type="text" name="owner_name" placeholder="Owner Name"
class="w-full border p-3 rounded" required>

<input type="email" name="email" placeholder="Email"
class="w-full border p-3 rounded" required>

<input type="text" name="shop_name" placeholder="Shop Name"
class="w-full border p-3 rounded" required>

<textarea name="description" placeholder="Shop Description"
class="w-full border p-3 rounded"></textarea>

<input type="file" name="logo"
class="w-full border p-3 rounded">

<button type="submit"
class="w-full bg-red-600 text-white p-3 rounded hover:bg-red-700">

Submit Registration

</button>

</form>

</div>

@endsection