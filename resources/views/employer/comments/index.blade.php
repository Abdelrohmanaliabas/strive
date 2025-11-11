<x-employer-layout>
    <div 
        class="space-y-10 px-6 py-8 lg:px-12" 
        x-data="candidateModal()" 
        x-cloak
    >
        <!-- Page Header -->
        <header class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/80">Candidate feedback</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Comments</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Capture notes and signals attached to each job posting to keep the hiring team aligned.
                </p>
            </div>
            <a href="{{ route('employer.jobs.index') }}"
               class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200">
                Back to jobs
            </a>
        </header>

        <!-- Comments List -->
        <section class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
            @forelse ($comments as $comment)
                <article class="space-y-4 rounded-2xl border border-white/10 bg-slate-950/60 p-5">
                    <header class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                        <div>
                            <!-- Candidate Name (clickable) -->
                            <p 
                                class="text-sm font-semibold text-white cursor-pointer hover:text-cyan-400"
                                @click="openModal('{{ optional($comment->user)->id }}')"
                            >
                                {{ optional($comment->user)->name ?? 'Anonymous' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ optional($comment->created_at)?->diffForHumans() ?? 'just now' }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-300">
                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1">
                                {{ $jobTitles[$comment->commentable_id] ?? 'Job removed' }}
                            </span>
                            <a href="{{ route('employer.comments.show', $comment) }}"
                               class="inline-flex items-center gap-2 rounded-full border border-white/10 px-3 py-1 font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200">
                                View thread
                            </a>
                        </div>
                    </header>
                    <p class="text-sm leading-relaxed text-slate-200">
                        {!! nl2br(e($comment->content)) !!}
                    </p>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 p-12 text-center text-sm text-slate-300">
                    No comments yet. Encourage teammates to leave structured feedback directly on each job post.
                </div>
            @endforelse
        </section>

        <!-- Pagination -->
        @if ($comments instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="pt-4">
                {{ $comments->links() }}
            </div>
        @endif

        <!-- Candidate Modal -->
        <div 
            x-show="open" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
            style="display: none;"
        >
            <div 
                @click.away="open = false" 
                class="rounded-2xl bg-slate-950 p-6 w-96 shadow-xl"
            >
                <h2 class="text-xl font-semibold text-white mb-4">Candidate Details</h2>

                <!-- Display loading message until data is fetched -->
                <template x-if="!candidate">
                    <p class="text-slate-400 text-sm">Loading...</p>
                </template>

                <!-- Display candidate data -->
                <template x-if="candidate">
                    <div class="space-y-2 text-sm text-slate-200">
                        <p><span class="font-semibold">Name:</span> <span x-text="candidate.name"></span></p>
                        <p><span class="font-semibold">Email:</span> <span x-text="candidate.email"></span></p>
                        <p><span class="font-semibold">Phone:</span> <span x-text="candidate.phone || 'N/A'"></span></p>
                        <p>
                            <span class="font-semibold">LinkedIn:</span> 
                            <template x-if="candidate.linkedin_url">
                                <a :href="candidate.linkedin_url" target="_blank" class="text-cyan-400 hover:underline" x-text="candidate.linkedin_url"></a>
                            </template>
                            <template x-if="!candidate.linkedin_url">
                                <span>N/A</span>
                            </template>
                        </p>
                        <p><span class="font-semibold">Registered:</span> <span x-text="new Date(candidate.created_at).toLocaleDateString()"></span></p>
                    </div>
                </template>

                <div class="mt-4 flex justify-end">
                    <button 
                        @click="open = false" 
                        class="rounded bg-cyan-500 px-4 py-2 text-white hover:bg-cyan-400"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Logic -->
    <script>
        function candidateModal() {
            return {
                open: false,
                candidate: null,

                async openModal(userId) {
                    if (!userId) return;

                    this.open = true;
                    this.candidate = null; // reset while loading

                    try {
                        const res = await fetch(`/employer/candidates/${userId}`);
                        if (!res.ok) throw new Error('Failed to fetch candidate data');
                        this.candidate = await res.json();
                    } catch (err) {
                        console.error(err);
                        this.candidate = { name: 'Error loading data' };
                    }
                }
            }
        }
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>
</x-employer-layout>
