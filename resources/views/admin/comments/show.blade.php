@extends('layouts.admin')

@section('title', 'Comment Details')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">

    {{-- 🧍 User Info --}}
    <div class="flex items-center gap-4 mb-6">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=6366f1&color=fff&size=96"
             class="w-16 h-16 rounded-full border-2 border-indigo-500 object-cover">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $comment->user->email }}</p>
        </div>
    </div>

    {{-- 💬 Comment Info --}}
    <div class="space-y-3 mb-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500 uppercase">Comment Content</h3>
            <p class="mt-1 text-gray-800 dark:text-gray-200">{{ $comment->content }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 uppercase">Commented On</h3>
            @if ($comment->commentable)
                <a href="{{ route('admin.jobpost.show', $comment->commentable->id) }}"
                   class="text-indigo-600 hover:underline">
                    {{ class_basename($comment->commentable_type) }} #{{ $comment->commentable->id }}
                </a>
            @else
                <p class="text-gray-400 italic">Deleted Item</p>
            @endif
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 uppercase">Created At</h3>
            <p class="mt-1 text-gray-600 dark:text-gray-300">{{ $comment->created_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>

    {{-- ❌ Delete --}}
    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this comment?')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="w-full py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-md transition">
            Delete Comment
        </button>
    </form>
</div>
@endsection
