@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<x-admin.module-frame
    class="max-w-4xl mx-auto"
    title="System Settings"
    eyebrow="Settings"
    description="Tune the visual experience for admins without touching code.">
    <div class="space-y-8">
        {{-- Theme Mode --}}
        <div class="border-b border-gray-200 dark:border-gray-700 pb-5">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-3">Appearance</h2>

            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <p class="text-gray-700 dark:text-gray-300">Theme Mode</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Switch between Light and Dark themes.</p>
                </div>
                <button id="themeToggle"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition">
                    <i class="bi bi-moon"></i> Toggle Mode
                </button>
            </div>
        </div>

        {{--  Font Selection --}}
        <div class="border-b border-gray-200 dark:border-gray-700 pb-5">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-3">Font Style</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Choose your preferred font for the dashboard.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button data-font="Inter"
                        class="font-[Inter] p-3 border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium transition font-option">
                    Inter
                </button>
                <button data-font="Poppins"
                        class="font-[Poppins] p-3 border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium transition font-option">
                    Poppins
                </button>
                <button data-font="Roboto"
                        class="font-[Roboto] p-3 border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium transition font-option">
                    Roboto
                </button>
            </div>
        </div>

        {{-- Primary Color --}}
        <div class="border-b border-gray-200 dark:border-gray-700 pb-5">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-3">Primary Color</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Choose a highlight color for buttons and links.</p>

            <div class="flex gap-4 flex-wrap">
                <div class="color-choice w-8 h-8 rounded-full bg-indigo-600 cursor-pointer border-2 border-transparent hover:scale-110 transition" data-color="indigo"></div>
                <div class="color-choice w-8 h-8 rounded-full bg-green-600 cursor-pointer border-2 border-transparent hover:scale-110 transition" data-color="green"></div>
                <div class="color-choice w-8 h-8 rounded-full bg-rose-600 cursor-pointer border-2 border-transparent hover:scale-110 transition" data-color="rose"></div>
                <div class="color-choice w-8 h-8 rounded-full bg-yellow-500 cursor-pointer border-2 border-transparent hover:scale-110 transition" data-color="yellow"></div>
            </div>
        </div>

        {{-- Notifications --}}
        <div>
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-3">Notifications</h2>
            <div class="flex items-center justify-between flex-wrap gap-4">
                <p class="text-gray-700 dark:text-gray-300">Enable system alerts and job updates.</p>
                <label class="inline-flex items-center cursor-pointer relative">
                    <input type="checkbox" id="notificationsToggle" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700
                                peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                peer-checked:bg-indigo-600"></div>
                </label>
            </div>
        </div>
    </div>
</x-admin.module-frame>

{{--  Scripts --}}
<script>
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');

    //  Dark / Light toggle
    themeToggle.addEventListener('click', () => {
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        themeToggle.innerHTML = isDark
            ? '<i class="bi bi-sun"></i> Light Mode'
            : '<i class="bi bi-moon"></i> Dark Mode';
    });

    // Load saved theme
    window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            html.classList.add('dark');
            themeToggle.innerHTML = '<i class="bi bi-sun"></i> Light Mode';
        } else {
            html.classList.remove('dark');
            themeToggle.innerHTML = '<i class="bi bi-moon"></i> Dark Mode';
        }

        // Font & color
        const savedFont = localStorage.getItem('font');
        const savedColor = localStorage.getItem('color');
        if (savedFont) document.body.style.fontFamily = savedFont;
        if (savedColor) document.documentElement.style.setProperty('--primary-color', savedColor);
    });

    // Font switcher
    document.querySelectorAll('.font-option').forEach(btn => {
        btn.addEventListener('click', () => {
            const font = btn.dataset.font;
            document.body.style.fontFamily = font;
            localStorage.setItem('font', font);

            document.querySelectorAll('.font-option').forEach(b => b.classList.remove('ring-2', 'ring-indigo-500'));
            btn.classList.add('ring-2', 'ring-indigo-500');
        });
    });

    // Color switcher
    document.querySelectorAll('.color-choice').forEach(colorEl => {
        colorEl.addEventListener('click', () => {
            const color = colorEl.dataset.color;
            localStorage.setItem('color', color);
            document.documentElement.style.setProperty('--primary-color', color);
            document.querySelectorAll('.color-choice').forEach(c => c.classList.remove('ring-2', 'ring-white'));
            colorEl.classList.add('ring-2', 'ring-white');
        });
    });
</script>

@endsection
