@extends('layouts.public')

@section('title', 'About Us — Strive')

@section('content')

@php
    $aboutHeroImage = asset('images/about.jpg');
@endphp

<!-- ===== hero ===== -->
<section class="relative about-hero text-white py-24 overflow-hidden">
    <div class="about-hero__bg" style="background-image: url('{{ $aboutHeroImage }}');"></div>
    <div class="about-hero__overlay"></div>
    <div class="container relative z-10 mx-auto px-6 lg:px-20 text-center">
        <span class="inline-flex items-center justify-center about-pill mb-6 text-xs uppercase tracking-[0.3em]">Made for dreamers</span>
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">About Strive</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Connecting top talent with the best employers. Our mission is to make job search and hiring seamless, transparent, and rewarding.
        </p>
        <div class="mt-12 grid gap-6 sm:grid-cols-3 about-stats max-w-4xl mx-auto">
            <div class="about-stat">
                <p class="text-4xl font-bold">500+</p>
                <p class="text-sm text-white/80">Active employers</p>
            </div>
            <div class="about-stat">
                <p class="text-4xl font-bold">12k</p>
                <p class="text-sm text-white/80">CVs reviewed</p>
            </div>
            <div class="about-stat">
                <p class="text-4xl font-bold">48 hrs</p>
                <p class="text-sm text-white/80">Average placement time</p>
            </div>
        </div>
    </div>
    <div class="about-hero__blur about-hero__blur--one"></div>
    <div class="about-hero__blur about-hero__blur--two"></div>
</section>

<!-- ===== about ===== -->
<section class="py-16 bg-gray-100/90 dark:bg-gray-950/60 backdrop-blur-xl relative overflow-hidden">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid md:grid-cols-3 gap-8 text-center relative z-10">
            @foreach([
                ['title' => 'Our Mission', 'text' => 'To connect job seekers and employers with the perfect match for growth and success.'],
                ['title' => 'Our Vision', 'text' => 'To become the most trusted and innovative platform for job opportunities globally.'],
                ['title' => 'Our Values', 'text' => 'Integrity, transparency, inclusivity, and empowerment guide everything we do.']
            ] as $item)
            <div class="about-feature p-8 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1">
                <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white/70">{{ $item['title'] }}</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $item['text'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid lg:grid-cols-2 gap-8 mt-12 relative z-10">
            <div class="about-card">
                <h3 class="text-2xl font-semibold mb-3 text-gray-800 dark:text-white">Why we exist</h3>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    We saw how complicated hiring had become and set out to build a human platform. We mix curated data, expert support,
                    and thoughtful design so teams can hire with confidence and candidates can land roles that feel meaningful.
                </p>
            </div>
            <div class="about-card">
                <h3 class="text-2xl font-semibold mb-3 text-gray-800 dark:text-white">How we partner</h3>
                <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <li class="flex items-center gap-3">
                        <span class="about-dot"></span>
                        Guided onboarding and success playbooks for every employer.
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="about-dot"></span>
                        Candidate concierge that elevates every step of the journey.
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="about-dot"></span>
                        Insight dashboards to track applications, interviews, and hires.
                    </li>
                </ul>
            </div>
        </div>
        <div class="about-bg-accent about-bg-accent--one"></div>
        <div class="about-bg-accent about-bg-accent--two"></div>
    </div>
</section>

<!-- ===== team members ===== -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-6 lg:px-20 text-center">
        <h2 class="text-3xl font-bold mb-12 text-gray-800 dark:text-white/70">Meet the Team</h2>
        @php
            $teamMembers = [
                ['name'=>'Abdelrahman Ali','role'=>'Team Leader','image'=>asset('images/abdelrahman.jpg')],
                ['name'=>'Asmaa Othman','role'=>'Team Member','image'=>asset('images/asmaa.jpg')],
                ['name'=>'Aya Basheer','role'=>'Team Member','image'=>asset('images/aya.jpg')],
                ['name'=>'Basel Esam','role'=>'Team Member','image'=>asset('images/basel.jpg')],
                ['name'=>'Amira Mahmoud','role'=>'Team Member','image'=>asset('images/amira.jpg')],
            ];
        @endphp
        <div class="space-y-10">
            <div class="grid gap-8 md:grid-cols-3">
                @foreach(array_slice($teamMembers, 0, 3) as $member)
                    <div class="p-5 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-colors duration-300">
                        <img src="{{ $member['image']  }}"
                             alt="{{ $member['name'] }}"
                             class=" w-60 h-60 mx-auto rounded-full mb-4 object-cover border border-white/20 dark:border-white/10 shadow-md">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-white/70">{{ $member['name'] }}</h3>
                        <h4 class="text-sm text-gray-700 dark:text-gray-300">{{ $member['role'] }}</h4>
                    </div>
                @endforeach
            </div>
            <div class="grid gap-8 md:grid-cols-2 md:max-w-3xl mx-auto">
                @foreach(array_slice($teamMembers, 3) as $member)
                    <div class="p-9 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-colors duration-300">
                        <img src="{{ $member['image']  }}"
                             alt="{{ $member['name'] }}"
                             class="h-52 w-52 mx-auto rounded-full mb-4 object-cover border border-white/20 dark:border-white/10 shadow-md">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-white/70">{{ $member['name'] }}</h3>
                        <h4 class="text-sm text-gray-700 dark:text-gray-300">{{ $member['role'] }}</h4>
                    </div>
                @endforeach
            </div>
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

<style>
    .about-hero {
        background: #0f172a;
    }

    .about-hero__bg,
    .about-hero__overlay {
        position: absolute;
        inset: 0;
    }

    .about-hero__bg {
        background-size: cover;
        background-position: center;
        filter: brightness(0.65);
    }

    .about-hero__overlay {
        background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.5));
        pointer-events: none;
    }

    .about-hero__blur {
        position: absolute;
        width: 32rem;
        height: 32rem;
        filter: blur(120px);
        opacity: 0.5;
        border-radius: 999px;
        animation: about-float 16s ease-in-out infinite;
    }

    .about-hero__blur--one {
        top: -8rem;
        left: -10rem;
        background: #faccff;
    }

    .about-hero__blur--two {
        bottom: -10rem;
        right: -8rem;
        background: #c3e4ff;
        animation-delay: 6s;
    }

    .about-stats .about-stat {
        border-radius: 1.5rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.15);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(18px);
    }

    .about-pill {
        border-radius: 999px;
        padding: 0.35rem 1.2rem;
        background: rgba(255, 255, 255, 0.2);
        letter-spacing: 0.2em;
    }

    .about-card {
        border-radius: 1.75rem;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 25px 50px rgba(47, 58, 95, 0.15);
        backdrop-filter: blur(18px);
    }

    .dark .about-card {
        background: rgba(16, 21, 39, 0.85);
        border-color: rgba(255, 255, 255, 0.08);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
    }

    .about-dot {
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #f472b6, #c084fc);
        box-shadow: 0 0 0 6px rgba(244, 114, 182, 0.15);
    }

    .about-bg-accent {
        position: absolute;
        width: 20rem;
        height: 20rem;
        border-radius: 999px;
        filter: blur(80px);
        opacity: 0.4;
    }

    .about-bg-accent--one {
        top: 4rem;
        left: -6rem;
        background: #ffe3f6;
    }

    .about-bg-accent--two {
        bottom: 2rem;
        right: -4rem;
        background: #d5e4ff;
    }

    @keyframes about-float {
        0% {
            transform: translate3d(0, 0, 0);
        }

        50% {
            transform: translate3d(0, -15px, 0);
        }

        100% {
            transform: translate3d(0, 0, 0);
        }
    }
</style>

@endsection
