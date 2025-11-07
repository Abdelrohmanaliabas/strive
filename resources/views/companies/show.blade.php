@extends('layouts.app')

@section('title', $employer->name . ' — Employer Profile')

@section('content')
<section class="container mx-auto px-6 lg:px-20 py-12 text-gray-800 dark:text-white/70">
    <div class="p-8 rounded-2xl border border-white/10 shadow-xl bg-white/60 dark:bg-white/5 backdrop-blur-xl mb-10 text-center">
        <img src="{{ $employer->avatar ?? asset('images/avatar.jpg') }}" 
             class="w-24 h-24 mx-auto rounded-full object-cover border border-white/20 shadow mb-4" 
             alt="{{ $employer->name }}">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $employer->name }}</h1>
        <p class="text-gray-600 dark:text-white/60">{{ $employer->email }}</p>
    </div>

    <div class="p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl">
        <h2 class="text-xl font-semibold mb-4">Job Posts by {{ $employer->name }}</h2>

        @forelse($jobPosts as $job)
            <div class="border-b border-white/10 py-3">
                <a href="{{ route('jobs.show', $job) }}" class="text-blue-500 hover:underline font-medium">
                    {{ $job->title }}
                </a>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $job->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">No job posts yet.</p>
        @endforelse
    </div>
</section>
@endsection
