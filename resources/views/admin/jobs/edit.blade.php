@extends('layouts.admin')

@section('title', 'Edit Job Status')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-6">

    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
        Edit Job Status
    </h2>

    <div class="text-gray-600 dark:text-gray-300">
        <p><strong>Job Title:</strong> {{ $jobPost->title }}</p>
        <p><strong>Current Status:</strong>
            <span class="@if($jobPost->status === 'approved') text-green-600 
                          @elseif($jobPost->status === 'pending') text-yellow-600 
                          @else text-red-600 @endif font-medium">
                {{ ucfirst($jobPost->status) }}
            </span>
        </p>
    </div>

    @if ($jobPost->status === 'pending')
        {{-- ✅ Form يظهر فقط إذا كانت الحالة pending --}}
        <form method="POST" action="{{ route('admin.jobpost.update', $jobPost->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Change Status To:
                </label>
                <select id="status" name="status"
                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($allowedStatuses as $status)
                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                    @endforeach
                </select>

                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.jobpost.show', $jobPost->id) }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition">
                    Save Changes
                </button>
            </div>
        </form>
    @else
        {{-- ❌ حالة غير قابلة للتعديل --}}
        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300">
            <p class="mb-2">This job post has already been <strong>{{ ucfirst($jobPost->status) }}</strong>.</p>
            <a href="{{ route('admin.jobpost.show', $jobPost->id) }}"
               class="text-indigo-600 hover:underline">← Back to Job Details</a>
        </div>
    @endif
</div>
@endsection
