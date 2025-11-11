@extends('layouts.public')

@section('title', 'Contact Us — Strive')

@section('content')

<!-- ===== hero ===== -->
<section class="relative bg-indigo-500/80 dark:bg-indigo-900/70 text-white py-24">
    <div class="container mx-auto px-6 lg:px-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Contact Strive</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Have questions or need assistance? We’re here to help. Reach out to us anytime!
        </p>
    </div>
</section>

<!-- ===== the form information ===== -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-6 lg:px-20 grid md:grid-cols-2 gap-12">

        <!-- Contact Form -->
        <div class="p-8 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-colors duration-300">
            <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Send Us a Message</h2>
            <form action="#" method="POST" class="space-y-4">
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
        <div class="p-8 bg-white/80 dark:bg-gray-800/40 rounded-2xl shadow-xl border border-white/20 dark:border-white/10 backdrop-blur-xl transition-colors duration-300">
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
</section>

@endsection
