@extends('layouts.admin')

@section('title', 'Comments')

@section('content')
<x-admin.module-frame
    title="All Comments"
    eyebrow="Comments"
    description="Audit engagement across the platform and step into any conversation when needed.">
    <div class="space-y-8">
        {{-- Table --}}
        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
            <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">User</th>
                        <th class="px-4 py-3 text-left">Comment On</th>
                        <th class="px-4 py-3 text-left">Content</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($comments as $comment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-4 py-3">{{ $comment->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=6366f1&color=fff&size=48"
                                         class="w-8 h-8 rounded-full object-cover border border-gray-300 dark:border-gray-600">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $comment->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if ($comment->commentable)
                                    <a href="{{ route('admin.jobpost.show', $comment->commentable->id) }}"
                                       class="text-indigo-600 hover:text-indigo-400">
                                        {{ class_basename($comment->commentable_type) }} #{{ $comment->commentable->id }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Deleted</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 line-clamp-2">{{ Str::limit($comment->content, 80) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.comments.show', $comment->id) }}"
                                   class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                                    View
                                </a>
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-md hover:bg-red-500"
                                            onclick="return confirm('Are you sure you want to delete this comment?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                No comments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-4 border-t border-white/5">
            {{ $comments->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin.module-frame>
@endsection
