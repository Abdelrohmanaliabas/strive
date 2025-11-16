@extends('layouts.public')

@section('title', 'Job Categories — Strive')

@section('content')
<section class="categories-shell container mx-auto px-6 lg:px-20 py-12 text-gray-800 dark:text-white/70">

    <h1 class="text-4xl font-bold mb-8 text-center text-gray-900 dark:text-white">
        Explore Job Categories
    </h1>
    <p class="text-center text-gray-600 dark:text-gray-300 mb-12 max-w-2xl mx-auto">
        Find jobs by category. Browse through our listings to discover the right role for you.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('jobs.index', ['category' => $category->id]) }}"
               class="relative flex flex-col justify-between p-6 h-56 rounded-2xl
                      overflow-hidden text-gray-900 dark:text-white shadow-xl border border-white/10
                      backdrop-blur-xl bg-white/70 dark:bg-white/5 transition-transform duration-300 hover:-translate-y-1 hover:scale-[1.02] hover:border-white/20">

                <!-- Aurora overlay -->
                <div class="absolute inset-0 z-0 opacity-80 mix-blend-screen blur-2xl animate-[aurora_8s_ease-in-out_infinite_alternate]"
                     style="background:linear-gradient(135deg,rgba(0,255,200,0.15),rgba(0,140,255,0.15),rgba(180,100,255,0.15));background-size:200% 200%;">
                </div>

                <!-- Category Name -->
                <div class="relative z-10 flex-1 flex flex-col justify-center items-center text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                        {{ $category->description ?? 'Explore jobs in this category' }}

                    </p>
                </div>

                <!-- Browse Jobs Button -->
                <div class="relative z-10 mt-4">
                    <span class="inline-block px-4 py-1 text-xs font-medium text-white bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 rounded-full shadow-md animate-[gradientShift_6s_ease_infinite_alternate]">
                        Browse Jobs
                    </span>
                </div>
            </a>
        @endforeach
    </div>

</section>

<div class="my-10 flex justify-center">
    {{ $categories->links('pagination::candidatePagination') }}
</div>

<style>
@keyframes aurora {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}

.categories-shell {
  position: relative;
  border-radius: 2.25rem;
  background: rgba(255, 255, 255, 0.65);
  box-shadow: 0 35px 60px rgba(56, 71, 108, 0.15);
  backdrop-filter: blur(18px);
  border: 1px solid rgba(255, 255, 255, 0.7);
}

.dark .categories-shell {
  background: rgba(7, 11, 21, 0.8);
  border-color: rgba(255, 255, 255, 0.1);
  box-shadow: 0 35px 60px rgba(0, 0, 0, 0.65);
}

.categories-shell::before,
.categories-shell::after {
  content: "";
  position: absolute;
  width: 14rem;
  height: 14rem;
  border-radius: 999px;
  filter: blur(70px);
  opacity: 0.35;
  pointer-events: none;
}

.categories-shell::before {
  top: 2rem;
  right: -5rem;
  background: #ffdff8;
}

.categories-shell::after {
  bottom: -4rem;
  left: -4rem;
  background: #c9e7ff;
}
</style>
@endsection
