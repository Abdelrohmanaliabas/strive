@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">User Management</h1>
    <p class="text-gray-600 dark:text-gray-300 mb-8">
        Manage all registered users in the system below.
    </p>

    {{-- 🔍 Search & Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex-1">
            <input type="text" name="search" placeholder="Search by name or email..."
                   value="{{ request('search') }}"
                   class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <select name="role" class="rounded-md border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Employer</option>
                <option value="candidate" {{ request('role') == 'candidate' ? 'selected' : '' }}>Candidate</option>
            </select>
        </div>

        <div>
            <button type="submit"
                    class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white font-medium transition">
                Filter
            </button>
        </div>
    </form>

    {{-- 🧍 Users Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($users as $user)
            <div class="block rounded-lg border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-center mb-4">
                    {{-- Avatar --}}
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=96"
                         alt="{{ $user->name }}"
                         class="size-16 rounded-full object-cover border border-gray-300 dark:border-gray-600">

                    {{-- Join date --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <i class="bi bi-calendar2-date"></i>
                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $user->name }}
                </h3>

                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                    <i class="bi bi-envelope me-1"></i> {{ $user->email }}
                </p>

                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 capitalize">
                    <i class="bi bi-person-badge me-1"></i> {{ $user->role ?? 'User' }}
                </p>

                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                    <a href="{{ $user->linkedin_url }}">
                         <i class="bi bi-linkedin me-1 ">  </i>{{ $user->linkedin_url ?? 'N/A' }}
                    </a>
                </p>

                <div class="flex gap-3">
                    <a href="{{ route('admin.users.show', $user->id) }}"
                       class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-md transition">
                        <i class="bi bi-eye"></i> View
                    </a>

                    <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-500 rounded-md transition">
                        <i class="bi bi-pencil-square"></i> Edit    
                       
                    </a>


                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-red-600 hover:bg-red-500 rounded-md transition">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 col-span-full text-center">No users found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>
@endsection
