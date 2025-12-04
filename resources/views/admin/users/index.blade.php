@extends('layouts.admin')

@section('content')
<section class="bg-black min-h-[calc(100vh-4rem)] pt-8 pb-16">
    <div class="w-full max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-white mb-8">User Registration Management</h1>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-900/30 border border-green-700 text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-900/30 border border-red-700 text-red-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- PENDING REGISTRATIONS SECTION --}}
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-4">Pending Registrations</h2>

            @if($pendingUsers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($pendingUsers as $user)
                        <div class="bg-gray-900 border border-red-950 rounded-lg p-6 shadow-lg">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-white mb-1">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500 mt-2">
                                    Registered: {{ $user->created_at->format('M d, Y H:i') }}
                                </p>
                            </div>

                            <div class="flex gap-3">
                                {{-- APPROVE BUTTON --}}
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                        Approve
                                    </button>
                                </form>

                                {{-- DELETE BUTTON --}}
                                <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                    <p class="text-gray-400">No pending registrations at the moment.</p>
                </div>
            @endif
        </div>

        {{-- APPROVED USERS SECTION --}}
        <div>
            <h2 class="text-2xl font-bold text-white mb-4">Approved Assistant Admins</h2>

            @if($approvedUsers->count() > 0)
                <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-red-950 border-b border-red-900">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Role</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Approved Date</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedUsers as $user)
                                    <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                                        <td class="px-6 py-4 text-white">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-gray-300">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full bg-green-900/30 border border-green-700 text-green-200 text-xs font-semibold">
                                                {{ ucfirst($user->role ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->updated_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded transition">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                    <p class="text-gray-400">No approved assistant admins yet.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
