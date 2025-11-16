@extends('layouts.public')

@section('title', $employer->name . ' — Employer Profile')

@section('content')
@php
    $companyHeroImage = asset('images/hero (5).jpg');
    $jobPostsCount = method_exists($jobPosts, 'total') ? $jobPosts->total() : $jobPosts->count();
@endphp
<section class="company-shell container mx-auto px-6 lg:px-20 py-12 text-gray-800 dark:text-white/70">
    <div class="company-hero relative text-center overflow-hidden mb-10">
        <div class="company-hero__blur company-hero__blur--one"></div>
        <div class="company-hero__blur company-hero__blur--two"></div>
        <div class="relative z-10 p-8">
            <img src="{{ $employer->avatar_url }}"
                 class="w-24 h-24 mx-auto rounded-full object-cover border border-white/20 shadow mb-4"
                 alt="{{ $employer->name }}">
            <span class="company-pill text-xs uppercase tracking-[0.35em]">Featured employer</span>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mt-3">{{ $employer->name }}</h1>
            <p class="text-gray-600 dark:text-white/70">{{ $employer->email }}</p>
            <div class="grid sm:grid-cols-3 gap-6 mt-10 company-stats max-w-3xl mx-auto">
                <div class="company-stat">
                    <p class="text-3xl font-bold">{{ $jobPostsCount }}</p>
                    <p class="text-sm text-white/80">Active roles</p>
                </div>
                <div class="company-stat">
                    <p class="text-3xl font-bold">{{ $employer->created_at?->format('Y') ?? '—' }}</p>
                    <p class="text-sm text-white/80">On Strive since</p>
                </div>
                <div class="company-stat">
                    <p class="text-3xl font-bold">{{ $jobPostsCount ? '4.8/5' : 'New' }}</p>
                    <p class="text-sm text-white/80">Candidate rating</p>
                </div>
            </div>
        </div>
    </div>

    <div class="company-card p-8 rounded-2xl border border-white/10 shadow-lg bg-white/75 dark:bg-white/5 backdrop-blur-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-2xl font-semibold">Open roles</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">Updated {{ now()->diffForHumans() }}</span>
        </div>

        <div class="space-y-4">
            @forelse($jobPosts as $job)
                <div class="company-job row-start-auto grid gap-4 md:grid-cols-[1fr_auto] items-center border border-white/10 rounded-2xl p-4 bg-white/65 dark:bg-white/5 transition hover:-translate-y-1">
                    <div>
                        <a href="{{ route('jobs.show', $job) }}" class="text-lg font-semibold text-indigo-500 hover:underline">
                            {{ $job->title }}
                        </a>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $job->location }} • {{ ucfirst($job->work_type) }}</p>
                    </div>
                    <div class="text-right text-sm text-gray-500 dark:text-gray-400">
                        Posted {{ $job->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No job posts yet.</p>
            @endforelse
        </div>

        @if(method_exists($jobPosts, 'links'))
            <div class="mt-6">
                {{ $jobPosts->links() }}
            </div>
        @endif
    </div>
</section>

<style>
    .company-shell {
        position: relative;
    }
    .company-hero {
        border-radius: 2rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(236, 72, 153, 0.6));
        color: white;
        box-shadow: 0 35px 60px rgba(79, 70, 229, 0.25);
    }
    .company-hero__blur {
        position: absolute;
        width: 28rem;
        height: 28rem;
        border-radius: 999px;
        filter: blur(120px);
        opacity: 0.4;
        animation: company-float 18s ease-in-out infinite;
    }
    .company-hero__blur--one { top: -6rem; left: -8rem; background: #ffe2ff; }
    .company-hero__blur--two { bottom: -6rem; right: -7rem; background: #c1e5ff; animation-delay: 6s; }
    .company-pill {
        display: inline-block;
        border-radius: 999px;
        padding: 0.4rem 1.4rem;
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }
    .company-stats .company-stat {
        border-radius: 1.5rem;
        background: rgba(255, 255, 255, 0.18);
        padding: 1.4rem;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(15px);
        color: #fff;
    }
    .company-card {
        position: relative;
    }
    .company-card::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        border: 1px solid rgba(255, 255, 255, 0.45);
        pointer-events: none;
    }
    .dark .company-card::after {
        border-color: rgba(255, 255, 255, 0.08);
    }
    .company-job {
        position: relative;
    }
    .company-job::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        border: 1px solid rgba(255, 255, 255, 0.35);
        pointer-events: none;
    }
    .dark .company-job::after {
        border-color: rgba(255, 255, 255, 0.1);
    }
    @keyframes company-float {
        0% { transform: translate3d(0,0,0); }
        50% { transform: translate3d(0,-18px,0); }
        100% { transform: translate3d(0,0,0); }
    }
</style>
@endsection
