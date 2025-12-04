@extends('layouts.admin')

@section('content')
    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                User Registration Management
            </h1>
            <p class="text-sm text-zinc-400 mt-1">
                Approve or manage assistant admin accounts.
            </p>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="mb-5 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- CONTENT WRAPPER CARD --}}
    <div class="bg-[#090909] border border-zinc-900/80 rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.6)] p-6 md:p-7 space-y-8">

        {{-- PENDING REGISTRATIONS --}}
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-100">
                    Pending Registrations
                </h2>
                <span class="text-xs text-zinc-400">
                    {{ $pendingUsers->count() }} pending
                </span>
            </div>

            @if ($pendingUsers->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-700/70 bg-[#0b0b0f] px-4 py-6 text-sm text-zinc-400 text-center">
                    No pending registrations at the moment.
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($pendingUsers as $user)
                        <div class="rounded-2xl bg-[#101016] border border-zinc-800/80 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <p class="text-base font-semibold text-slate-100">
                                    {{ $user->name }}
                                </p>
                                <p class="text-sm text-zinc-300">
                                    {{ $user->email }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500">
                                    Registered: {{ $user->created_at->format('M d, Y • H:i') }}
                                </p>
                            </div>

                            <div class="flex gap-3">
                                {{-- Approve --}}
                                <form action="{{ route('admin.user-registrations.approve', $user->id) }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-600 text-white shadow-md shadow-emerald-500/30 transition">
                                        Approve
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.user-registrations.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this registration?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-xl text-sm font-semibold bg-red-500 hover:bg-red-600 text-white shadow-md shadow-red-500/30 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- APPROVED ASSISTANT ADMINS --}}
        <section class="pt-4 border-t border-zinc-900/80">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-100">
                    Approved Assistant Admins
                </h2>
                <span class="text-xs text-zinc-400">
                    {{ $approvedAdmins->count() }} active
                </span>
            </div>

            @if ($approvedAdmins->isEmpty())
                <div class="rounded-xl border border-dashed border-zinc-700/70 bg-[#0b0b0f] px-4 py-6 text-sm text-zinc-400 text-center">
                    No assistant admins have been approved yet.
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($approvedAdmins as $assistant)
                        <div class="rounded-2xl bg-[#101016] border border-zinc-800/80 px-5 py-3.5 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <p class="text-sm md:text-base text-slate-100">
                                    {{ $assistant->name }} —
                                    <span class="text-zinc-300">{{ $assistant->email }}</span>
                                </p>
                            </div>

                            <div class="flex gap-3">
                                {{-- Revoke role --}}
                                <form action="{{ route('admin.user-registrations.revoke', $assistant->id) }}" method="POST"
                                      onsubmit="return confirm('Remove Assistant Admin role from this user?');">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-xl text-xs md:text-sm font-semibold bg-amber-400 hover:bg-amber-500 text-black shadow-md shadow-amber-400/40 transition">
                                        Revoke Role
                                    </button>
                                </form>

                                {{-- Delete user --}}
                                <form action="{{ route('admin.user-registrations.destroy', $assistant->id) }}" method="POST"
                                      onsubmit="return confirm('Permanently delete this user account?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-xl text-xs md:text-sm font-semibold bg-red-500 hover:bg-red-600 text-white shadow-md shadow-red-500/30 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
