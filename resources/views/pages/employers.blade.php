@extends('layouts.public')

@section('title', 'Employers — Strive')

@section('content')

<!-- ===== hero ===== -->
<section class="relative bg-indigo-500/80 dark:bg-indigo-900/70 text-white py-24">
    <div class="container mx-auto px-6 lg:px-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Our Employers</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Discover top employers and explore the latest job opportunities they offer.
        </p>
    </div>
</section>

<!-- ===== employers grid ===== -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @foreach($employers as $employer)

                <div class="p-6 bg-white/70 dark:bg-white/5 rounded-2xl shadow-xl border border-white/10 backdrop-blur-xl flex flex-col items-center text-center transition hover:scale-[1.03] duration-300">
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

    </div>
</section>

@endsection
