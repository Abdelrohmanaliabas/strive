@php
  $logoPath = $job->logo ?? optional($job->employer)->logo ?? null;
  $defaultAvatar = asset('images/avatar.jpg');
  $logoUrl = ($logoPath && file_exists(storage_path('app/public/' . $logoPath)))
    ? asset('storage/' . $logoPath)
    : $defaultAvatar;
@endphp

<div
class="relative flex flex-col justify-between p-5 h-full rounded-2xl overflow-hidden 
         text-gray-900 dark:text-white shadow-xl border border-white/10 
         backdrop-blur-xl bg-white/70 dark:bg-white/5 
         transition-transform duration-300 hover:-translate-y-1 hover:border-white/20">
  <!-- Aurora Overlay -->
  <div
    class="absolute inset-0 z-0 opacity-80 mix-blend-screen blur-3xl animate-[aurora_8s_ease-in-out_infinite_alternate]"
    style="background:linear-gradient(135deg,rgba(0,255,200,0.15),rgba(0,140,255,0.15),rgba(180,100,255,0.15));background-size:200% 200%;">
  </div>

  <!-- Posted time -->
  <div class="absolute top-4 right-4 text-xs text-gray-700 dark:text-white/70 z-10">
    {{ $job->created_at->diffForHumans() }}
  </div>

  <!-- Header -->
  <div class="flex items-center gap-3 mb-3 relative z-10">
    <img src="{{ $logoUrl }}" alt="{{ optional($job->employer)->name }} logo"
         class="w-10 h-10 rounded-md border border-white/30 object-cover shadow-md">
    <h5 class="text-lg font-semibold leading-tight text-gray-700 dark:text-white/70">
      <a href="{{ route('jobs.show', $job->id) }}" class="hover:underline">
        {{ $job->title }}
      </a>
    </h5>
  </div>

  <!-- Employer & Category -->
  <div class="text-sm text-gray-700 dark:text-white/70 mb-3 relative z-10">
    {{ optional($job->employer)->name ?? 'Unknown Employer' }}
    <span class="mx-1">•</span>
    ({{ optional($job->category)->name ?? 'Uncategorized' }})
  </div>

  <!-- Description -->
  <p class="text-sm text-gray-700 dark:text-white/70 mb-4 line-clamp-3 relative z-10">
    {!! \Illuminate\Support\Str::limit(strip_tags($job->description), 100) !!}
  </p>

  <!-- Footer -->
  <div class="flex justify-between items-center mt-auto relative z-10">
    <div class="flex items-center gap-2">
      <span
        class="px-3 py-1 rounded-full text-xs font-medium text-white bg-gradient-to-r from-sky-500 via-indigo-500 to-cyan-400 animate-[gradientShift_6s_ease_infinite_alternate]">
        {{ ucfirst($job->work_type) }}
      </span>
      @if($job->salary_range)
        <span class="text-emerald-400 text-sm drop-shadow-sm">
          ${{ $job->salary_range }}
        </span>
      @endif
    </div>
    <a href="{{ route('jobs.show', $job->id) }}"
       class="px-4 py-1.5 rounded-md text-sm font-medium text-white bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 shadow-lg transition-all duration-300 hover:brightness-110">
       View
    </a>
  </div>
</div>

<!-- Tailwind keyframes -->
<style>
@keyframes aurora {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}
</style>
