@extends('layouts.public')

@section('title', $jobPost->title . ' — JobNest')
{{-- success & error messages --}}
@section('content')
<section class="container mx-auto px-6 lg:px-20 py-12 text-gray-800 dark:text-white/70">
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

  <!-- ===== Job Header ===== -->
  <div class="relative p-8 rounded-2xl border border-white/10 shadow-xl 
              bg-white/60 dark:bg-white/5 backdrop-blur-xl mb-10">
    
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 relative z-10">
      <a href="{{ route('companies.show', $jobPost->employer) }}">
      <img src="{{ optional($jobPost->employer)->avatar_url ?? asset('images/avatar.jpg') }}"
           alt="Company Logo"
           class="w-20 h-20 rounded-xl border border-white/30 object-cover shadow-md">
      </a>

      <div class="flex-1">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $jobPost->title }}</h1>
        <div class="space-y-1 text-sm text-gray-700 dark:text-white/70">
          <p><strong>Employer:</strong> {{ optional($jobPost->employer)->name ?? 'Unknown Employer' }}</p>
          <p><strong>Category:</strong> {{ optional($jobPost->category)->name ?? 'Uncategorized' }}</p>
          <p><strong>Work Type:</strong> {{ ucfirst($jobPost->work_type) }}</p>
          @if($jobPost->salary_range)
            <p><strong>Salary:</strong> ${{ $jobPost->salary_range }}</p>
          @endif
          <p><strong>Location:</strong> {{ $jobPost->location }}</p>
        </div>
      </div>

      <div class="flex flex-col items-end gap-3">
        <p class="text-xs text-gray-500 dark:text-gray-400">
          <i class="bi bi-clock"></i> Posted {{ $jobPost->created_at->diffForHumans() }}
        </p>
        <button class="px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 rounded-md shadow-md hover:brightness-110 transition"
                data-bs-toggle="modal" data-bs-target="#applyModal">
          <i class="bi bi-send-fill mr-1"></i> Apply Now
        </button>
      </div>
    </div>
  </div>

  <!-- ===== Job Details & Sidebar ===== -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- ===== Main Content ===== -->
    <div class="lg:col-span-2 space-y-8">

      <div class="p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl">
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
      <div class="p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl">
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

    <!-- ===== Sidebar ===== -->
    <aside class="p-8 rounded-2xl border border-white/10 shadow-lg bg-white/70 dark:bg-white/5 backdrop-blur-xl h-fit">
      <h4 class="text-xl font-semibold mb-4">Company Info</h4>
      <ul class="space-y-2 text-sm">
        <li><i class="bi bi-building text-blue-400 mr-2"></i>{{ optional($jobPost->employer)->name ?? 'Unknown Employer' }}</li>
        <li><i class="bi bi-envelope text-blue-400 mr-2"></i>{{ optional($jobPost->employer)->email ?? 'N/A' }}</li>
        <li><i class="bi bi-geo-alt text-blue-400 mr-2"></i>{{ $jobPost->location }}</li>
      </ul>
      <button class="w-full mt-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 rounded-md shadow hover:brightness-110 transition"
              data-bs-toggle="modal" data-bs-target="#applyModal">
        Apply Now
      </button>
    </aside>
  </div>
</section>

<!-- ===== Apply Modal ===== -->
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
            <input type="text" name="name" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 focus:ring-2 focus:ring-blue-500" required>
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
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}
</style>
@endsection

<!-- <script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 4000);
</script> -->
