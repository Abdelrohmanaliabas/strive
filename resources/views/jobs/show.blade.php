@extends('layouts.public')

@section('title', $jobPost->title . ' — Strive')

@section('content')
@php
$applied = $jobPost->applicationForCurrentUser;
@endphp

<section class="job-show-shell container mx-auto px-6 lg:px-20 py-12 text-gray-800 dark:text-white/70">
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ===== hero ===== -->
<div class="job-hero relative overflow-hidden rounded-3xl mb-10 text-white">
  <div class="job-hero__blur job-hero__blur--one"></div>
  <div class="job-hero__blur job-hero__blur--two"></div>
  <div class="relative z-10 grid gap-8 lg:grid-cols-3 p-8">
    <div class="flex items-center gap-4 lg:col-span-2">
      <a href="{{ route('companies.show', $jobPost->employer) }}">
        <img src="{{ optional($jobPost->employer)->avatar_url ?? asset('images/avatar.jpg') }}"
             alt="Company Logo"
             class="w-20 h-20 rounded-2xl border border-white/40 object-cover shadow-2xl">
      </a>
      <div>
        <span class="job-pill text-xs uppercase tracking-[0.3em]">Featured role</span>
        <h1 class="text-3xl font-bold mt-3">{{ $jobPost->title }}</h1>
        <p class="text-white/80 text-sm">{{ optional($jobPost->employer)->name ?? 'Unknown Employer' }} • {{ ucfirst($jobPost->work_type) }}</p>
      </div>
    </div>
    <div class="flex flex-col items-start lg:items-end gap-3">
      <p class="text-xs text-white/70">
        <i class="bi bi-clock"></i> Posted {{ $jobPost->created_at->diffForHumans() }}
      </p>
      @if(auth()->check() && auth()->user()->role === 'candidate')
        @if($applied && $applied->status !== 'cancelled')
          <div class="job-applied-badge">Already Applied</div>
          <form action="{{ route('applications.cancel', $applied->id) }}" method="POST" class="mt-2">
            @csrf
            <button class="text-sm text-red-200 hover:text-white">Cancel Application</button>
          </form>
        @else
          <button class="job-cta" data-bs-toggle="modal" data-bs-target="#applyModal">
            <i class="bi bi-send-fill mr-1"></i> Apply Now
          </button>
        @endif
      @endif
    </div>
  </div>
  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 px-8 pb-8 text-sm text-white/80">
    <div class="job-stat-card">
      <p class="text-xs uppercase tracking-wide">Category</p>
      <p class="text-lg font-semibold">{{ optional($jobPost->category)->name ?? 'Uncategorized' }}</p>
    </div>
    <div class="job-stat-card">
      <p class="text-xs uppercase tracking-wide">Salary</p>
      <p class="text-lg font-semibold">{{ $jobPost->salary_range ? '$'.$jobPost->salary_range : 'Not specified' }}</p>
    </div>
    <div class="job-stat-card">
      <p class="text-xs uppercase tracking-wide">Location</p>
      <p class="text-lg font-semibold">{{ $jobPost->location }}</p>
    </div>
    <div class="job-stat-card">
      <p class="text-xs uppercase tracking-wide">Applicants</p>
      <p class="text-lg font-semibold">{{ $jobPost->applications()->count() }}</p>
    </div>
  </div>
</div>

<!-- ===== job Details and sidebar ===== -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

  <!-- ===== main content ===== -->
  <div class="lg:col-span-2 space-y-8">

    <div class="job-card p-8 rounded-2xl border border-white/10 shadow-lg bg-white/75 dark:bg-white/5 backdrop-blur-xl">
      <h3 class="text-xl font-semibold mb-3">Description</h3>
      <p class="text-gray-700 dark:text-white/70 leading-relaxed">{!! nl2br(e($jobPost->description)) !!}</p>

      @if($jobPost->responsibilities)
        <h4 class="text-lg font-semibold mt-6 mb-2">Responsibilities</h4>
        <p class="text-gray-700 dark:text-white/70 leading-relaxed">{!! nl2br(e($jobPost->responsibilities)) !!}</p>
      @endif

      @if($jobPost->requirements)
        <h4 class="text-lg font-semibold mt-6 mb-2">Requirements</h4>
        <p class="text-gray-700 dark:text-white/70 leading-relaxed">{!! nl2br(e($jobPost->requirements)) !!}</p>
      @endif

      @if($jobPost->benefits)
        <h4 class="text-lg font-semibold mt-6 mb-2">Benefits</h4>
        <p class="text-gray-700 dark:text-white/70 leading-relaxed">{!! nl2br(e($jobPost->benefits)) !!}</p>
      @endif

      @if($jobPost->technologies_array)
        <div class="mt-6">
          <h4 class="text-lg font-semibold mb-2">Technologies</h4>
          <div class="flex flex-wrap gap-2">
            @foreach($jobPost->technologies_array as $tech)
              <span class="px-3 py-1 text-xs font-medium rounded-full text-white bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-400 animate-[gradientShift_6s_ease_infinite_alternate] shadow">
                {{ $tech }}
              </span>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <!-- ===== Comments ===== -->
    <div class="job-card p-8 rounded-2xl border border-white/10 shadow-lg bg-white/75 dark:bg-white/5 backdrop-blur-xl">
      <h4 class="text-xl font-semibold mb-4">Comments ({{ $jobPost->comments()->count() }})</h4>

      <form action="{{ route('comments.store') }}" method="POST" class="mb-6 space-y-3">
        @csrf
        <input type="hidden" name="job_post_id" value="{{ $jobPost->id }}">
        <textarea name="content" rows="3" placeholder="Write a comment..."
                  class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-gray-800 dark:text-white/80 placeholder-gray-500 focus:ring-2 focus:ring-blue-500"></textarea>
        <button class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-purple-500 rounded-md shadow hover:brightness-110 transition">
          Post Comment
        </button>
      </form>

      @forelse($comments as $comment)
        <div class="border-t border-white/10 pt-4 mt-4">
          <div class="flex items-start gap-3">
            <img src="{{ optional($comment->user)->avatar_url ?? asset('images/avatar.jpg') }}"
                 class="w-10 h-10 rounded-full object-cover">
            <div>
              <p class="font-semibold">{{ $comment->user->name }}
                <span class="text-xs text-gray-500">· {{ $comment->created_at->diffForHumans() }}</span>
              </p>
              <p class="text-sm text-gray-700 dark:text-white/70">{{ $comment->content }}</p>

              @if($comment->replies)
                <div class="ml-5 mt-2 border-l border-white/10 pl-3 space-y-2">
                  @foreach($comment->replies as $reply)
                    <div class="flex items-start gap-2">
                      <img src="{{ optional($reply->user)->avatar_url ?? asset('images/avatar.jpg') }}"
                           class="w-8 h-8 rounded-full object-cover">
                      <div>
                        <p class="text-sm font-semibold">{{ $reply->user->name }}
                          <span class="text-xs text-gray-500">· {{ $reply->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-sm text-gray-700 dark:text-white/70">{{ $reply->content }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      @empty
        <p class="text-sm text-gray-500">No comments yet. Be the first to comment!</p>
      @endforelse
    </div>
  </div>

  <!-- ===== sidebar ===== -->
  <aside class="job-card p-8 rounded-2xl border border-white/10 shadow-lg bg-white/75 dark:bg-white/5 backdrop-blur-xl h-fit">
    <h4 class="text-xl font-semibold mb-4">Company Info</h4>
    <ul class="space-y-2 text-sm">
      <li><i class="bi bi-building text-blue-400 mr-2"></i>{{ optional($jobPost->employer)->name ?? 'Unknown Employer' }}</li>
      <li><i class="bi bi-envelope text-blue-400 mr-2"></i>{{ optional($jobPost->employer)->email ?? 'N/A' }}</li>
      <li><i class="bi bi-geo-alt text-blue-400 mr-2"></i>{{ $jobPost->location }}</li>
    </ul>

    @if(auth()->check() && auth()->user()->role === 'candidate')
        @if($applied && $applied->status !== 'cancelled')
            <span class="block text-center text-green-500 font-semibold mt-6">Already Applied</span>
            <form action="{{ route('applications.cancel', $applied->id) }}" method="POST" class="mt-3">
                @csrf
                <button class="w-full py-2 text-red-500 font-semibold hover:text-red-700">
                    Cancel Application
                </button>
            </form>
        @else
            <button class="w-full mt-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 rounded-md shadow hover:brightness-110 transition"
                    data-bs-toggle="modal" data-bs-target="#applyModal">
                Apply Now
            </button>
        @endif
    @endif
  </aside>
</div>
</section>

<!-- ===== apply modal ===== -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-2xl">
      <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="job_post_id" value="{{ $jobPost->id }}">
        <div class="modal-header border-0">
          <h5 class="text-lg font-semibold" id="applyModalLabel">Apply for {{ $jobPost->title }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body space-y-3">
          <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', optional($applied)->name) }}"
                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', optional($applied)->email) }}"
                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', optional($applied)->phone) }}"
                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Upload Resume (PDF)</label>
            <input type="file" name="resume" accept="application/pdf" class="w-full text-sm" required>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button class="w-full py-2 text-white bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg font-semibold hover:brightness-110 transition">
            Submit Application
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .job-show-shell {
    position: relative;
  }
  .job-hero {
    background: radial-gradient(circle at top left, rgba(52, 201, 235, 0.5), transparent 60%),
      radial-gradient(circle at top right, rgba(168, 85, 247, 0.35), transparent 55%),
      linear-gradient(135deg, #312e81, #111827 70%);
    color: white;
    box-shadow: 0 35px 55px rgba(49, 46, 129, 0.35);
  }
  .job-hero__blur {
    position: absolute;
    width: 32rem;
    height: 32rem;
    border-radius: 999px;
    filter: blur(130px);
    opacity: 0.4;
    animation: job-float 18s ease-in-out infinite;
  }
  .job-hero__blur--one { top: -8rem; left: -8rem; background: #ffd5ff; }
  .job-hero__blur--two { bottom: -8rem; right: -8rem; background: #c3e5ff; animation-delay: 6s; }
  .job-pill {
    border-radius: 999px;
    padding: 0.3rem 1.2rem;
    background: rgba(255, 255, 255, 0.2);
    letter-spacing: 0.3em;
  }
  .job-cta {
    border: none;
    border-radius: 999px;
    padding: 0.85rem 1.6rem;
    font-weight: 600;
    background: linear-gradient(135deg, #06b6d4, #3b82f6, #a855f7);
    color: white;
    box-shadow: 0 25px 45px rgba(37, 99, 235, 0.35);
  }
  .job-applied-badge {
    padding: 0.6rem 1.4rem;
    border-radius: 999px;
    background: rgba(34, 197, 94, 0.2);
    color: #86efac;
    font-weight: 600;
  }
  .job-stat-card {
    border-radius: 1.3rem;
    padding: 1rem;
    background: rgba(17, 24, 39, 0.45);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
  }
  .job-card {
    position: relative;
  }
  .job-card::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    border: 1px solid rgba(255, 255, 255, 0.4);
    pointer-events: none;
  }
  .dark .job-card::after {
    border-color: rgba(255, 255, 255, 0.1);
  }
  @keyframes job-float {
    0% { transform: translate3d(0,0,0); }
    50% { transform: translate3d(0,-18px,0); }
    100% { transform: translate3d(0,0,0); }
  }
  @keyframes gradientShift {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
  }
</style>
@endsection
