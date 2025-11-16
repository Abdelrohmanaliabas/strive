@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<x-admin.module-frame
    title="Job Analytics Overview"
    eyebrow="Analytics"
    description="Track views, applications, and engagement signals across every posting.">
    <div class="space-y-8">
        {{--Table --}}
        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
            <table class="min-w-full text-sm text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Job Title</th>
                        <th class="px-4 py-3 text-center">Views</th>
                        <th class="px-4 py-3 text-center">Applications</th>
                        <th class="px-4 py-3 text-right">Last Viewed</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($analytics as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>

                            {{-- Title --}}
                            <td class="px-4 py-3">
                                @if($item->jobPost)
                                    <a href="{{ route('admin.jobpost.show', $item->jobPost->id) }}"
                                       class="text-indigo-600 hover:text-indigo-400 font-medium">
                                       {{ $item->jobPost->title }}
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $item->jobPost->location ?? '�?"' }}
                                    </p>
                                @else
                                    <span class="text-gray-400 italic">Job Deleted</span>
                                @endif
                            </td>

                            {{--  Views --}}
                            <td class="px-4 py-3 text-center font-semibold text-indigo-600 dark:text-indigo-400">
                                {{ $item->views_count }}
                            </td>

                            {{-- Applications --}}
                            <td class="px-4 py-3 text-center font-semibold text-green-600 dark:text-green-400">
                                {{ $item->applications_count }}
                            </td>

                            {{--  Last viewed --}}
                            <td class="px-4 py-3 text-right">
                                @if($item->last_viewed_at)
                                    {{ \Carbon\Carbon::parse($item->last_viewed_at)->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">�?"</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                No analytics data available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--  Pagination --}}
        <div class="pt-4 border-t border-white/5">
            {{ $analytics->links() }}
        </div>
    </div>
</x-admin.module-frame>
@endsection
