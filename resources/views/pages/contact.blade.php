@extends('layouts.public')

@section('title', 'Contact Us — Strive')

@section('content')

@php
    $contactHeroImage = asset('images/contact.jpg');
@endphp

<!-- ===== hero ===== -->
<section class="relative contact-hero text-white py-24 overflow-hidden">
    <div class="contact-hero__bg" style="background-image: url('{{ $contactHeroImage }}');"></div>
    <div class="contact-hero__overlay"></div>
    <div class="container relative z-10 mx-auto px-6 lg:px-20 text-center">
        <span class="inline-flex items-center justify-center contact-pill mb-6 text-xs uppercase tracking-[0.3em]">We listen</span>
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Contact Strive</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Have questions or need assistance? We’re here to help. Reach out to us anytime!
        </p>
        <div class="mt-12 grid gap-6 sm:grid-cols-3 contact-stats max-w-5xl mx-auto">
            <div class="contact-stat">
                <p class="text-4xl font-bold">24/7</p>
                <p class="text-sm text-white/80">Support coverage</p>
            </div>
            <div class="contact-stat">
                <p class="text-4xl font-bold">2 hrs</p>
                <p class="text-sm text-white/80">Avg. response time</p>
            </div>
            <div class="contact-stat">
                <p class="text-4xl font-bold">4.9/5</p>
                <p class="text-sm text-white/80">Customer satisfaction</p>
            </div>
        </div>
    </div>
    <div class="contact-hero__blur contact-hero__blur--one"></div>
    <div class="contact-hero__blur contact-hero__blur--two"></div>
</section>

<!-- ===== the form information ===== -->
<section class="py-16 bg-gray-50/90 dark:bg-gray-950/70 relative overflow-hidden">
    <div class="container mx-auto px-6 lg:px-20 grid md:grid-cols-2 gap-12">

        <!-- Contact Form -->
        <div class="contact-card p-8 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1">
            <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Send Us a Message</h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-300">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-300">
                    <ul class="text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-white">Full Name</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 dark:bg-gray-700/40 dark:border-white/10 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-white">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 dark:bg-gray-700/40 dark:border-white/10 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-white">Message</label>
                    <textarea name="message" rows="5" required
                              class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 dark:bg-gray-700/40 dark:border-white/10 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 transition"></textarea>
                </div>
                <button type="submit"

                        class="px-6 py-3 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 text-white  font-semibold rounded-lg  shadow hover:brightness-110 transition">
                    Send Message
                </button>
            </form>
        </div>
<!-- from-indigo-500 via-purple-500 to-pink-500  -->
        <!-- Contact Info -->
        <div class="contact-card p-8 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1">
            <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Contact Info</h2>
            <ul class="space-y-4 text-gray-700 dark:text-gray-300">
                <li class="flex items-center gap-3">
                    <i class="bi bi-envelope text-indigo-500 text-lg"></i>
                    <span>Email: <a href="mailto:info@jobnest.com" class="text-indigo-600 dark:text-indigo-400">info@strive.com</a></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="bi bi-telephone text-indigo-500 text-lg"></i>
                    <span>Phone: <a href="tel:+201234567890" class="hover:underline">+20 123 456 7890</a></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="bi bi-geo-alt text-indigo-500 text-lg"></i>
                    <span>Address: 123 Nile St, Cairo, Egypt</span>
                </li>
            </ul>
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Follow Us</h3>
                <div class="flex gap-4 justify-start">
                    <a href="#" class="text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition"><i class="bi bi-facebook text-2xl"></i></a>
                    <a href="#" class="text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition"><i class="bi bi-twitter text-2xl"></i></a>
                    <a href="#" class="text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 transition"><i class="bi bi-linkedin text-2xl"></i></a>
                </div>
            </div>
        </div>

    </div>
    <div class="contact-bg-accent contact-bg-accent--one"></div>
    <div class="contact-bg-accent contact-bg-accent--two"></div>
</section>

<style>
    .contact-hero {
        background: #0f172a;
    }

    .contact-hero__bg,
    .contact-hero__overlay {
        position: absolute;
        inset: 0;
    }

    .contact-hero__bg {
        background-size: cover;
        background-position: center;
        filter: brightness(0.65);
    }

    .contact-hero__overlay {
        pointer-events: none;
        background: linear-gradient(135deg, rgba(0,0,0,0.7), rgba(0,0,0,0.7));
    }

    .contact-hero__blur {
        position: absolute;
        width: 30rem;
        height: 30rem;
        border-radius: 999px;
        filter: blur(120px);
        opacity: 0.5;
        animation: contact-float 16s ease-in-out infinite;
    }

    .contact-hero__blur--one {
        top: -8rem;
        left: -9rem;
        background: #ffc3f3;
    }

    .contact-hero__blur--two {
        bottom: -9rem;
        right: -7rem;
        background: #b9e0ff;
        animation-delay: 6s;
    }

    .contact-stats .contact-stat {
        border-radius: 1.5rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(20px);
    }

    .contact-pill {
        border-radius: 999px;
        padding: 0.35rem 1.4rem;
        background: rgba(255, 255, 255, 0.2);
        letter-spacing: 0.3em;
    }

    .contact-card {
        position: relative;
    }

    .contact-card::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        border: 1px solid rgba(255, 255, 255, 0.45);
        pointer-events: none;
    }

    .dark .contact-card::after {
        border-color: rgba(255, 255, 255, 0.08);
    }

    .contact-bg-accent {
        position: absolute;
        width: 18rem;
        height: 18rem;
        border-radius: 999px;
        filter: blur(90px);
        opacity: 0.35;
        pointer-events: none;
    }

    .contact-bg-accent--one {
        top: 2rem;
        left: -5rem;
        background: #ffe1f6;
    }

    .contact-bg-accent--two {
        bottom: 1rem;
        right: -5rem;
        background: #d0e8ff;
    }

    @keyframes contact-float {
        0% {
            transform: translate3d(0, 0, 0);
        }

        50% {
            transform: translate3d(0, -14px, 0);
        }

        100% {
            transform: translate3d(0, 0, 0);
        }
    }
</style>
@endsection
