@extends('layouts.admin')

@section('title', $user->name)

@section('content')
<x-admin.module-frame
    title="{{ $user->name }}"
    eyebrow="Users"
    description="Detailed overview of the account, associated posts, and recent activity.">
    <div class="max-w-6xl mx-auto space-y-10">

        {{-- Basic Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=128"
                 alt="{{ $user->name }}"
                 class="mx-auto rounded-full border-4 border-indigo-500 size-32 object-cover mb-3">

            <span class="inline-block bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                {{ ucfirst($user->role ?? 'User') }}
            </span>

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">{{ $user->name }}</h2>
            <p class="text-gray-500 dark:text-gray-300 text-sm">{{ $user->email }}</p>

            <div class="mt-4 text-sm space-y-1 text-gray-600 dark:text-gray-300">
                @if($user->phone)
                    <p><i class="bi bi-telephone"></i> {{ $user->phone }}</p>
                @endif
                @if($user->linkedin_url)
                    <p>
                        <i class="bi bi-linkedin text-blue-500"></i>
                        <a href="{{ $user->linkedin_url }}" target="_blank" class="text-blue-500 hover:underline">
                            LinkedIn Profile
                        </a>
                    </p>
                @endif
            </div>

            <div class="flex justify-center gap-4 mt-6">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                   class="px-5 py-2 text-sm bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md transition text-gray-800 dark:text-white">
                    Edit
                </a>
                <a href="mailto:{{ $user->email }}"
                   class="px-5 py-2 text-sm bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md transition text-gray-800 dark:text-white">
                    Contact
                </a>
            </div>
        </div>

        {{-- Job Posts --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Job Posts ({{ $user->jobPosts->count() }})
            </h3>

            @if ($user->jobPosts->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No job posts found.</p>
            @else
                <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                    <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($user->jobPosts as $post)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-4 py-3">{{ $post->id }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.jobpost.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-400">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">{{ $post->category->name ?? '�?"' }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $post->status }}</td>
                                    <td class="px-4 py-3 text-right">{{ $post->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Applications --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Applications ({{ $user->applications->count() }})
            </h3>

            @if ($user->applications->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No job applications found.</p>
            @else
                <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                    <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Job Title</th>
                                <th class="px-4 py-3">Location</th>
                                <th class="px-4 py-3">Applied At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($user->applications as $app)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-4 py-3">{{ $app->id }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.jobpost.show', $app->jobPost->id) }}"
                                           class="text-indigo-600 hover:text-indigo-400">
                                           {{ $app->jobPost->title ?? '�?"' }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">{{ $app->jobPost->location ?? '�?"' }}</td>
                                    <td class="px-4 py-3">{{ $app->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{--  Comments --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                Comments ({{ $user->comments->count() }})
            </h3>

            @if ($user->comments->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No comments found.</p>
            @else
                <div class="space-y-4">
                    @foreach ($user->comments as $comment)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between mb-2">
                                <p class="text-gray-800 dark:text-gray-100 font-medium">{{ $comment->commentable->title ?? 'Comment' }}</p>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-200 text-sm">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-admin.module-frame>
@endsection
