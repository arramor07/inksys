<div class="sidebar">
    <ul>

        {{-- Always visible to admin + assistant admin --}}
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.portfolio') }}">Portfolio Manager</a></li>
        <li><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>

        {{-- Visible to ADMIN ONLY --}}
        @if(auth()->user()->role === 'admin')
            <li><a href="{{ route('admin.inventory.index') }}">Inventory</a></li>
            <li><a href="{{ route('admin.user-registrations.index') }}">User Registrations</a></li>
        @endif

        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-500">Logout</button>
            </form>
        </li>

    </ul>
</div>
