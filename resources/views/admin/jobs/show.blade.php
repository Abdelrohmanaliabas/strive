@extends('layouts.admin')

@section('title', 'Job Details')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-6xl mx-auto space-y-8">

    {{-- 🎯 Job Details --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">{{ $jobPost->title }}</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $jobPost->description }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-gray-700 dark:text-gray-300">
            <p><strong>Employer:</strong> {{ $jobPost->employer->name ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $jobPost->category->name ?? '—' }}</p>
            <p><strong>Location:</strong> {{ $jobPost->location }}</p>
            <p><strong>Work Type:</strong> {{ ucfirst($jobPost->work_type) }}</p>
            <p><strong>Status:</strong>
                <span class="font-medium 
                    @if($jobPost->status === 'approved') text-green-600 
                    @elseif($jobPost->status === 'pending') text-yellow-600 
                    @else text-red-600 @endif">
                    {{ ucfirst($jobPost->status) }}
                </span>
            </p>
            <p><strong>Deadline:</strong> {{ $jobPost->application_deadline }}</p>
        </div>
    </div>

    {{-- 🧾 Applications Section --}}
    <div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white border-b border-gray-300 dark:border-gray-600 pb-2 mb-4">
            Applications ({{ $jobPost->applications->count() }})
        </h3>

        @if ($jobPost->applications->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">No applications yet.</p>
        @else
            <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Candidate</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">Resume</th>
                            <th class="px-4 py-3 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($jobPost->applications as $app)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-4 py-3">{{ $app->candidate->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $app->candidate->email ?? $app->email ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $app->phone ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if ($app->resume)
                                        <a href="{{ asset('storage/' . $app->resume) }}" target="_blank" 
                                           class="text-indigo-600 hover:text-indigo-500">
                                            <i class="bi bi-file-earmark-arrow-down"></i> Download
                                        </a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">{{ $app->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- 💬 Comments Section --}}
    <div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white border-b border-gray-300 dark:border-gray-600 pb-2 mb-4">
            Comments ({{ $jobPost->comments->count() }})
        </h3>

        @if ($jobPost->comments->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">No comments yet.</p>
        @else
            <div class="space-y-4">
                @foreach ($jobPost->comments as $comment)
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'User') }}&background=6366f1&color=fff"
                                     class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name ?? 'Anonymous' }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-200">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
