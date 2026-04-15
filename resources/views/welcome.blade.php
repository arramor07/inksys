@extends('layouts.app')

@section('content')
{{-- FULLSCREEN HERO --}}
<section
    class="relative min-h-[calc(100vh-4rem)] flex items-center justify-center text-center text-white"
    style="background-image: url('{{ asset('images/bg.jpg') }}'); background-size: cover; background-position: center;">
    
    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/20"></div>

    {{-- Centered glass card --}}
    <div class="relative max-w-4xl mx-auto px-6">
        <div class="bg-black/50 backdrop-blur-l rounded-3xl px-10 py-16 shadow-2xl border border-white/10">
            
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6
                bg-gradient-to-r from-red-700 to-red-300
                bg-clip-text text-transparent text-center">
                Welcome to InkTech
            </h1>

            <p class="text-base md:text-lg text-slate-200 max-w-2xl mx-auto mb-10 leading-relaxed text-center">
                Where art meets skin – precision, passion, and ink.
                Explore our curated tattoo portfolio and book your session with your preferred tattoo shop with ease.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
    <a href="{{ route('portfolio') }}"
       class="inline-flex items-center justify-center px-10 py-4 rounded-full text-sm font-semibold
              bg-gradient-to-r from-red-700 to-red-400
              hover:from-red-800 hover:to-red-500
              shadow-lg shadow-red-500/30 transition">
        Browse Portfolio
    </a>

    <a href="{{ route('book.create') }}"
       class="inline-flex items-center justify-center px-10 py-4 rounded-full text-sm font-semibold border border-white/60 bg-white/5 hover:bg-white/10 transition">
        Book Now
    </a>

    <a href="{{ route('shops.register.form') }}"
       class="inline-flex items-center justify-center px-10 py-4 rounded-full text-sm font-semibold border border-white/60 bg-white/5 hover:bg-white/10 transition">
        Register Your Shop
    </a>
</div>
        </div>
    </div>
</section>

{{-- SHOPS GRID --}}
<section class="py-16 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Our Tattoo Shops</h2>

        {{-- Search --}}
        <form method="GET" action="/" class="mb-6 flex justify-center gap-2">
            <input type="text" name="search" placeholder="Search Shops..." value="{{ request('search') }}"
                   class="px-4 py-2 border rounded-lg w-64">
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Search
            </button>
        </form>

        {{-- Shops Grid --}}
        <div class="shops-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @if($shops->count())
                @foreach($shops as $shop)
                    <div class="shop-card bg-white rounded-2xl shadow-md overflow-hidden text-center">
                        <img src="{{ asset('storage/'.$shop->logo) }}" alt="{{ $shop->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $shop->name }}</h3>

                            {{-- View Details Button --}}
                            <button onclick="openShop({{ $shop->id }})"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition mb-2">
                                View Details
                            </button>

                            {{-- Favorite Button --}}
                            <button onclick="toggleFavorite({{ $shop->id }}, 'shop')"
                                    class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                                ❤️ Favorite
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center col-span-3">No shops available yet.</p>
            @endif
        </div>
    </div>

    {{-- Shop Modal --}}
    <div id="shopModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-50">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 relative">
            <div id="shopContent"></div>
            <button onclick="closeShop()"
                    class="absolute top-4 right-4 text-gray-700 hover:text-red-600 font-bold text-xl">
                &times;
            </button>
        </div>
    </div>
</section>

{{-- JS --}}
<script>
function openShop(shopId) {
    fetch(`/api/shops/${shopId}/featured-tattoos`) // endpoint returning shop + featured tattoos
        .then(res => res.json())
        .then(shop => {
            document.getElementById('shopContent').innerHTML = `
    <h2 class="text-2xl font-bold mb-2">${shop.name}</h2>
    <p class="mb-4">${shop.description}</p>

    <h4 class="font-semibold mb-2">Featured Tattoos</h4>

    <div class="tattoos grid grid-cols-2 gap-4">
        ${shop.featuredTattoos.map(t => `
            <div class="text-center">
                <img src="/storage/${t.image}" alt="${t.name}" class="w-full h-32 object-cover rounded-lg">
                <p>${t.name}</p>
            </div>
        `).join('')}
    </div>

    <div class="mt-6 flex gap-3">

        <a href="/shops/${shop.id}/home"
        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
        Proceed to Shop
        </a>

        <a href="/shops/${shop.id}/book"
        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition">
        Book Appointment
        </a>

    </div>
`;
            document.getElementById('shopModal').classList.remove('hidden');
        });
}

function closeShop() {
    document.getElementById('shopModal').classList.add('hidden');
}

function toggleFavorite(id, type){
    fetch(`/favorites/toggle`, {
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body: JSON.stringify({id,type})
    }).then(res=>res.json())
      .then(data=>{
          alert(data.message);
      });
}
</script>
@endsection