<div class="sidebar w-60 p-4 bg-neutral-900 min-h-screen">

    <h1 class="text-pink-400 text-xl font-bold mb-6">InkTech</h1>

    <ul class="space-y-3">

        {{-- Shared links (admin + assistant admin) --}}
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.portfolio') }}">Portfolio Manager</a></li>
        <li><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>

        {{-- Admin-only links --}}
        @if(auth()->user()->role === 'admin')
            <li><a href="{{ route('admin.inventory.index') }}">Inventory</a></li>
            <li><a href="{{ route('admin.user-registrations.index') }}">User Registrations</a></li>
        @endif

        {{-- Logout --}}
        <li class="pt-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500">Logout</button>
            </form>
        </li>

    </ul>
</div>
