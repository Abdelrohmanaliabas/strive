@extends('layouts.public')

@section('title', 'Employers — Strive')

@section('content')

@php
    $employersHeroImage = asset('images/hero (8).jpg');
@endphp

<!-- ===== hero ===== -->
<section class="relative employers-hero text-white py-24 overflow-hidden">
    <div class="employers-hero__bg" style="background-image: url('{{ $employersHeroImage }}');"></div>
    <div class="employers-hero__overlay"></div>
    <div class="employers-hero__blur employers-hero__blur--one"></div>
    <div class="employers-hero__blur employers-hero__blur--two"></div>
    <div class="relative z-10 container mx-auto px-6 lg:px-20 text-center">
        <span class="inline-flex items-center justify-center employers-pill mb-6 text-xs uppercase tracking-[0.3em]">Trusted partners</span>
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Our Employers</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Discover top employers and explore the latest job opportunities they offer.
        </p>
        <div class="mt-12 grid gap-6 sm:grid-cols-3 employers-stats max-w-5xl mx-auto">
            <div class="employers-stat">
                <p class="text-4xl font-bold">{{ $employers->total() }}</p>
                <p class="text-sm text-white/80">Active employers</p>
            </div>
            <div class="employers-stat">
                <p class="text-4xl font-bold">{{ number_format(collect($employers->items())->sum(fn($e) => $e->jobPosts()->count())) }}</p>
                <p class="text-sm text-white/80">Jobs published</p>
            </div>
            <div class="employers-stat">
                <p class="text-4xl font-bold">98%</p>
                <p class="text-sm text-white/80">Recommend Strive</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== employers grid ===== -->
<section class="py-16 bg-gray-50/95 dark:bg-gray-950/70 relative overflow-hidden">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 relative z-10">

            @foreach($employers as $employer)

                <div class="employer-card p-6 bg-white/70 dark:bg-white/5 rounded-2xl shadow-xl border border-white/10 backdrop-blur-xl flex flex-col items-center text-center transition hover:-translate-y-1 duration-300">
                    <img src="{{ $employer->avatar_url }}" alt="{{ $employer->name }} Logo"
                         class="w-24 h-24 rounded-full mb-4 object-cover border border-white/20 shadow-md">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">{{ $employer->name }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $employer->email ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                        {{ $employer->jobPosts()->count() }} job(s) posted
                    </p>
                    <a href="{{ route('companies.show', $employer) }}"
                       class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 rounded-lg shadow hover:brightness-110 transition">
                        View Profile
                    </a>
                </div>
            @endforeach
            <!-- bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 -->

        </div>

        <div class="employers-bg-accent employers-bg-accent--one"></div>
        <div class="employers-bg-accent employers-bg-accent--two"></div>

    </div>
</section>

<div class="my-10 flex justify-center">
    {{ $employers->links('pagination::candidatePagination') }}
</div>

<style>
    .employers-hero {
        background: #0f172a;
    }

    .employers-hero__bg,
    .employers-hero__overlay {
        position: absolute;
        inset: 0;
    }

    .employers-hero__bg {
        background-size: cover;
        background-position: center;
        filter: brightness(0.65);
    }

    .employers-hero__overlay {
        background:
            linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.5));
        pointer-events: none;
    }

    .employers-hero__blur {
        position: absolute;
        width: 34rem;
        height: 34rem;
        border-radius: 999px;
        filter: blur(130px);
        opacity: 0.5;
        animation: employers-float 18s ease-in-out infinite;
    }

    .employers-hero__blur--one {
        top: -10rem;
        left: -12rem;
        background: #ffc4ff;
    }

    .employers-hero__blur--two {
        bottom: -9rem;
        right: -9rem;
        background: #c2e6ff;
        animation-delay: 5s;
    }

    .employers-stats .employers-stat {
        border-radius: 1.6rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(18px);
    }

    .employers-pill {
        border-radius: 999px;
        padding: 0.35rem 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        letter-spacing: 0.3em;
    }

    .employer-card {
        position: relative;
    }

    .employer-card::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        border: 1px solid rgba(255, 255, 255, 0.4);
        pointer-events: none;
    }

    .dark .employer-card::after {
        border-color: rgba(255, 255, 255, 0.08);
    }

    .employers-bg-accent {
        position: absolute;
        width: 22rem;
        height: 22rem;
        border-radius: 999px;
        filter: blur(90px);
        opacity: 0.4;
        pointer-events: none;
    }

    .employers-bg-accent--one {
        top: 3rem;
        right: -6rem;
        background: #ffe3f5;
    }

    .employers-bg-accent--two {
        bottom: 0;
        left: -5rem;
        background: #d6e6ff;
    }

    @keyframes employers-float {
        0% {
            transform: translate3d(0, 0, 0);
        }

        50% {
            transform: translate3d(0, -18px, 0);
        }

        100% {
            transform: translate3d(0, 0, 0);
        }
    }
</style>
@endsection
