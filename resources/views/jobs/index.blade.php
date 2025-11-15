@extends('layouts.public')

@section('title', 'Find Jobs — Strive')

@section('content')

<!-- ===== hero ===== -->
<section class="relative min-h-[100vh] flex items-center text-white overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero.jpg') }}');"></div>
  <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

  <div class="relative container mx-auto px-6 lg:px-20 py-16">
    <div class="max-w-3xl">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
        Find Your Next Great Job
      </h1>
      <p class="text-lg text-gray-200 mb-8">
        Explore verified openings for developers, designers, and creators.
      </p>

      <!-- Search form -->
      <form action="{{ route('jobs.index') }}" method="get"
            class="flex flex-col md:flex-row gap-3">
        <input type="search" name="q" value="{{ request('q') }}"
               placeholder="Job title or keyword"
               class="w-full md:w-1/3 px-4 py-3 rounded-lg border-0 shadow text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500">

        <input type="text" name="location" value="{{ request('location') }}"
               placeholder="Location"
               class="w-full md:w-1/4 px-4 py-3 rounded-lg border-0 shadow text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500">

        <select name="category"
                class="w-full md:w-1/4 px-4 py-3 rounded-lg border-0 shadow text-gray-900 focus:ring-2 focus:ring-blue-500">
          <option value="">All categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>

        <select name="posted"
            class="w-full md:w-1/4 px-4 py-3 rounded-lg border-0 shadow text-gray-900 focus:ring-2 focus:ring-blue-500">
            <option value="">Any time</option>
            <option value="1" @selected(request('posted')==1)>Last 24 hours</option>
            <option value="3" @selected(request('posted')==3)>Last 3 days</option>
            <option value="7" @selected(request('posted')==7)>Last 7 days</option>
            <option value="30" @selected(request('posted')==30)>Last 30 days</option>
        </select>


        <button class="px-6 py-3 rounded-lg bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 text-white font-semibold shadow-md hover:brightness-110 transition">
          Go
        </button>
      </form>

      <div class="mt-4 text-sm text-gray-300">
        Popular:
        <a href="{{ route('jobs.index', ['technology'=>'Laravel']) }}" class="underline hover:text-white">Laravel</a>,
        <a href="{{ route('jobs.index', ['work_type'=>'remote']) }}" class="underline hover:text-white">Remote</a>,
        <a href="{{ route('jobs.index', ['q'=>'Junior']) }}" class="underline hover:text-white">Junior</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== category mini cards ===== -->
<section class="py-10 border-b border-white/10">
  <div class="container mx-auto px-6 lg:px-20">
    <div class="flex justify-between items-center mb-6">
      <h5 class="text-lg font-semibold text-gray-700 dark:text-white/70">Explore Categories</h5>
      <a href="{{ route('public_categories.index') }}" class="text-sm text-blue-400 hover:underline">View all →</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
      @foreach($categories->take(6) as $cat)
        <a href="{{ route('jobs.index', ['category' => $cat->id]) }}"
           class="bg-white/10 backdrop-blur-md rounded-xl p-4 text-center hover:scale-[1.03] transition transform shadow-md">
          <div class="text-gray-700 dark:text-white/70 font-semibold mb-1">{{ $cat->name }}</div>
          <div class="text-gray-400 dark:text-white/70 text-sm">Browse Jobs</div>
        </a>
      @endforeach
    </div>
  </div>
</section>

<!-- ===== job listings ===== -->
<section class="py-12">
  <div class="container mx-auto px-6 lg:px-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
      <div class="text-gray-700 dark:text-white/70 text-sm mb-4 md:mb-0">
        <strong>{{ $jobs->total() }}</strong> jobs found
        <span class="text-gray-400">— Page {{ $jobs->currentPage() }} of {{ $jobs->lastPage() }}</span>
      </div>

      <!-- filter form -->
      <form action="{{ route('jobs.index') }}" method="get" class="flex flex-wrap items-center gap-2 text-sm">
        <input type="hidden" name="q" value="{{ request('q') }}">
        <input type="hidden" name="location" value="{{ request('location') }}">
        <input type="hidden" name="category" value="{{ request('category') }}">

        <select name="work_type"
                class="px-3 py-2 rounded-lg bg-white/10 text-gray-400 dark:text-white/70 focus:ring-2 focus:ring-blue-500">
          <option value="">All types</option>
          <option value="remote" @selected(request('work_type')=='remote')>Remote</option>
          <option value="onsite" @selected(request('work_type')=='onsite')>Onsite</option>
          <option value="hybrid" @selected(request('work_type')=='hybrid')>Hybrid</option>
        </select>

        <input type="text" name="technology" value="{{ request('technology') }}"
               placeholder="Technology"
               class="px-3 py-2 rounded-lg bg-white/10 text-gray-700 dark:text-white/70 placeholder-gray-400 focus:ring-2 focus:ring-blue-500">

        <button type="submit"
                class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-gray-700 dark:text-white/70 hover:brightness-110">
          Filter
        </button>
        <a href="{{ route('jobs.index') }}" class="text-gray-700 dark:text-white/70 hover:underline">Clear</a>
      </form>
    </div>

    <!-- cards grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse($jobs as $job)
        @include('jobs._card', ['job' => $job])
      @empty
        <div class="col-span-full text-center text-gray-700 dark:text-white/70 py-10">
          No jobs found. Try adjusting your filters.
        </div>
      @endforelse
    </div>

    <div class="flex justify-center mt-10">
      {{ $jobs->links() }}
    </div>
  </div>
</section>

@endsection
