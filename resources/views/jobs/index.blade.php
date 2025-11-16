@extends('layouts.public')

@section('title', 'Find Jobs — Strive')

@section('content')

@php
    $heroImages = collect(range(1, 10))->map(fn ($index) => asset("images/hero ({$index}).jpg"));
@endphp

<!-- ===== hero ===== -->
<section class="jobs-hero relative overflow-hidden text-white py-20 h-96 md:h-[500px] lg:h-[600px] flex items-center">
  <div class="jobs-hero__slider">
    @foreach ($heroImages as $url)
      <div class="jobs-hero__slide @if ($loop->first) is-active @endif" style="background-image: url('{{ $url }}');"></div>
    @endforeach
  </div>
  <div class="jobs-hero__overlay"></div>
  <div class="jobs-hero__blur jobs-hero__blur--one"></div>
  <div class="jobs-hero__blur jobs-hero__blur--two"></div>
  <div class="relative z-10 container mx-auto px-6 lg:px-20 grid lg:grid-cols-2 gap-12 items-center">
    <div class="max-w-2xl">
      <span class="jobs-pill">The right job for you</span>
      <h1 class="text-4xl md:text-5xl font-bold mt-4 mb-4">
        Find Your Next Great Job
      </h1>
      <p class="text-lg text-white/80 mb-8">
        Explore verified openings for developers, designers, and creators in a single cinematic dashboard.
      </p>
      
    </div>

    <!-- Search form -->
    <div class="jobs-search card glass p-6 rounded-3xl bg-transparent text-gray-200 shadow-3xl backdrop-blur-lg border border-white/10">
      <form action="{{ route('jobs.index') }}" method="get" class="grid gap-4">
        <div class="grid gap-3 md:grid-cols-2">
          <input type="search" name="q" value="{{ request('q') }}"
                 placeholder="Job title or keyword"
                 class="jobs-input" />

          <input type="text" name="location" value="{{ request('location') }}"
                 placeholder="Location"
                 class="jobs-input" />
        </div>

        <div class="grid gap-3 md:grid-cols-3">
          <select name="category" class="jobs-input">
            <option value="">All categories</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>

          <select name="posted" class="jobs-input">
              <option value="">Any time</option>
              <option value="1" @selected(request('posted')==1)>Last 24 hours</option>
              <option value="3" @selected(request('posted')==3)>Last 3 days</option>
              <option value="7" @selected(request('posted')==7)>Last 7 days</option>
              <option value="30" @selected(request('posted')==30)>Last 30 days</option>
          </select>

          <select name="work_type" class="jobs-input">
            <option value="">Work type</option>
            <option value="remote" @selected(request('work_type')=='remote')>Remote</option>
            <option value="onsite" @selected(request('work_type')=='onsite')>Onsite</option>
            <option value="hybrid" @selected(request('work_type')=='hybrid')>Hybrid</option>
          </select>
        </div>

        <div class="grid gap-3 md:grid-cols-[1fr_auto]">
          <input type="text" name="technology" value="{{ request('technology') }}"
                 placeholder="Technology (e.g. Laravel)"
                 class="jobs-input" />
          <button class="jobs-cta">
            <span>Search</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </div>
      </form>

      <div class="mt-4 text-sm text-gray-500">
        Popular:
        <a href="{{ route('jobs.index', ['technology'=>'Laravel']) }}" class="underline hover:text-gray-900">Laravel</a>,
        <a href="{{ route('jobs.index', ['work_type'=>'remote']) }}" class="underline hover:text-gray-900">Remote</a>,
        <a href="{{ route('jobs.index', ['q'=>'Junior']) }}" class="underline hover:text-gray-900">Junior</a>
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
                class="jobs-input jobs-chip-input w-auto">
          <option value="">All types</option>
          <option value="remote" @selected(request('work_type')=='remote')>Remote</option>
          <option value="onsite" @selected(request('work_type')=='onsite')>Onsite</option>
          <option value="hybrid" @selected(request('work_type')=='hybrid')>Hybrid</option>
        </select>

        <input type="text" name="technology" value="{{ request('technology') }}"
               placeholder="Technology"
               class="jobs-chip-input" />

        <button type="submit"
                class="jobs-chip-cta">
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
      {{ $jobs->links('pagination::strive') }}
    </div>
  </div>
</section>

<style>

  .jobs-hero__slider,
  .jobs-hero__overlay {
    position: absolute;
    inset: 0;
    top: 0%
  }
  .jobs-hero__slider {
    z-index: 0;
  }
  .jobs-hero__slide {
    position: absolute;
    inset: 0;
    top: 0%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1.5s ease;
  }
  .jobs-hero__slide.is-active {
    opacity: 1;
  }
  .jobs-hero__overlay {
    z-index: 1;
    background:linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0,0, 0.7));
    pointer-events: none;
  }
  .jobs-hero__blur {
    position: absolute;
    width: 30rem;
    height: 30rem;
    border-radius: 999px;
    filter: blur(120px);
    opacity: 0.45;
    animation: jobs-float 18s ease-in-out infinite;
  }
  .jobs-hero__blur--one { top: -6rem; left: -8rem; background: #ffe3ff; }
  .jobs-hero__blur--two { bottom: -6rem; right: -8rem; background: #c0e7ff; animation-delay: 5s; }
  .jobs-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 1.4rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.2);
    font-size: 0.75rem;
    letter-spacing: 0.4em;
  }
  .jobs-stats .jobs-stat {
    border-radius: 1.4rem;
    padding: 1.25rem;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(18px);
    text-align: center;
  }
  .jobs-input {
    width: 100%;
    border-radius: 1rem;
    border: 1px solid rgba(15, 23, 42, 0.15);
    padding: 0.8rem 1rem;
    font-size: 0.95rem;
    background: rgba(255, 255, 255, 0.92);
    color: #0f172a;
    transition: border 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  }
  .jobs-input::placeholder {
    color: #475569;
  }
  .dark .jobs-input {
    background: rgba(15, 23, 42, 0.7);
    border-color: rgba(148, 163, 184, 0.4);
    color: #f8fafc;
  }
  .dark .jobs-input::placeholder {
    color: rgba(226, 232, 240, 0.7);
  }
  .jobs-input:focus {
    outline: none;
    border-color: rgba(99, 102, 241, 0.6);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
  }
  .jobs-cta {
    border: none;
    border-radius: 999px;
    background: linear-gradient(135deg, #06b6d4, #2563eb, #a855f7);
    color: white;
    font-weight: 600;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding: 0.9rem 1.5rem;
    box-shadow: 0 20px 35px rgba(37, 99, 235, 0.3);
    transition: transform 0.2s ease, filter 0.2s ease;
  }
  .jobs-cta:hover {
    transform: translateY(-2px);
    filter: brightness(1.05);
  }
  .jobs-chip-input {
    padding: 0.6rem 1rem;
    border-radius: 999px;
    border: 1px solid rgba(15, 23, 42, 0.2);
    background: rgba(15, 23, 42, 0.03);
  }
  .jobs-chip-cta {
    padding: 0.6rem 1.6rem;
    border-radius: 999px;
    border: none;
    background: linear-gradient(135deg, #a855f7, #6366f1);
    color: white;
    font-weight: 600;
  }
  @keyframes jobs-float {
    0% { transform: translate3d(0,0,0); }
    50% { transform: translate3d(0,-16px,0); }
    100% { transform: translate3d(0,0,0); }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.jobs-hero__slide');
    if (!slides.length) {
      return;
    }
    let current = 0;
    setInterval(() => {
      slides[current].classList.remove('is-active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('is-active');
    }, 1500);
  });
</script>

@endsection
