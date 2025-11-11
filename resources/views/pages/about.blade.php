@extends('layouts.public')

@section('title', 'About Us — Strive')

@section('content')

<!-- ===== hero ===== -->
<section class="relative bg-blue-500/80 dark:bg-blue-900/70 text-white py-24">
    <div class="container mx-auto px-6 lg:px-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">About JobNest</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Connecting top talent with the best employers. Our mission is to make job search and hiring seamless, transparent, and rewarding.
        </p>
    </div>
</section>

<!-- ===== about ===== -->
<section class="py-16 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid md:grid-cols-3 gap-8 text-center">
            @foreach([
                ['title' => 'Our Mission', 'text' => 'To connect job seekers and employers with the perfect match for growth and success.'],
                ['title' => 'Our Vision', 'text' => 'To become the most trusted and innovative platform for job opportunities globally.'],
                ['title' => 'Our Values', 'text' => 'Integrity, transparency, inclusivity, and empowerment guide everything we do.']
            ] as $item)
            <div class="p-8 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-colors duration-300">
                <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white/70">{{ $item['title'] }}</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $item['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== team members ===== -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-6 lg:px-20 text-center">
        <h2 class="text-3xl font-bold mb-12 text-gray-800 dark:text-white/70">Meet the Team</h2>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach([
                ['name'=>'Abdelrahman Ali','role'=>'Team Leader'],
                ['name'=>'Aya Basheer','role'=>'Team Member'],
                ['name'=>'Basel Esam','role'=>'Team Member'],
                ['name'=>'Amira Mahmoud','role'=>'Team Member'],
                ['name'=>'Asmaa Othman','role'=>'Team Member'],
            ] as $member)
            <div class="p-6 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-colors duration-300">
                <img src="{{ asset('images/avatar.jpg') }}" 
                     alt="{{ $member['name'] }}" 
                     class="w-32 h-32 mx-auto rounded-full mb-4 object-cover border border-white/20 dark:border-white/10 shadow-md">
                <h4 class="font-semibold text-lg text-gray-800 dark:text-white/70">{{ $member['name'] }}</h4>
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $member['role'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== footer ===== -->
<section class="py-16 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 text-white text-center rounded-t-3xl">
    <h2 class="text-3xl font-bold mb-4">Ready to Find Your Next Opportunity?</h2>
    <p class="mb-6">Join thousands of job seekers and employers today!</p>
    <a href="{{ route('jobs.index') }}" class="inline-block px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-lg hover:brightness-110 transition">
        Browse Jobs
    </a>
</section>

@endsection
