@extends('layouts.admin')

@section('title', 'Jobs')

@section('content')
<x-admin.module-frame
    title="Job Posts"
    eyebrow="Jobs"
    description="Review every open role, adjust statuses, and keep postings organized.">
    <div class="space-y-8">
        {{--  Filters --}}
        <form method="GET" action="{{ route('admin.jobpost.index') }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            {{-- Search --}}
            <div class="relative w-full sm:w-1/2">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, location, or description..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700
                              text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Status Filter --}}
            <select name="status"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            {{-- Sort --}}
            <select name="sort"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
            </select>

            <button type="submit"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow transition">
                Apply
            </button>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
            <table class="min-w-full text-left text-sm text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Employer</th>
                        <th class="px-4 py-3">Location</th>
                        <th class="px-4 py-3">Work Type</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Deadline</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($jobPost as $job)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-4 py-3 font-medium">{{ $job->id }}</td>
                            <td class="px-4 py-3 flex items-center gap-3">
                                @if($job->logo)
                                    <img src="{{ asset('storage/' . $job->logo) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <i class="bi bi-briefcase text-indigo-600 text-xl"></i>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $job->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $job->category->name ?? '�?"' }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $job->employer->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $job->location }}</td>
                            <td class="px-4 py-3 capitalize">{{ $job->work_type }}</td>
                            <td class="px-4 py-3">
                                @if($job->status === 'approved')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-700/30 dark:text-green-300">Approved</span>
                                @elseif($job->status === 'pending')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-700/30 dark:text-amber-300">Pending</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-700/30 dark:text-red-300">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right text-sm">{{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('admin.jobpost.show', $job->id) }}"
                                       class="p-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition"
                                       title="View Job">
                                        <i class="bi bi-eye text-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.jobpost.edit', $job->id) }}"
                                       class="p-2 text-amber-500 hover:text-amber-600 dark:text-amber-400 dark:hover:text-amber-300 transition"
                                       title="Edit Job">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.jobpost.destroy', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this job post?')"
                                                class="p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition"
                                                title="Delete Job">
                                            <i class="bi bi-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-6 text-gray-500 dark:text-gray-400">No jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-4 border-t border-white/5">
            {{ $jobPost->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin.module-frame>
@endsection
