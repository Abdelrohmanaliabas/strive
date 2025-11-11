<x-employer-layout>
    <section class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
            @forelse ($comments as $comment)
                <article class="space-y-4 rounded-2xl border border-white/10 bg-slate-950/60 p-5">
                    <header class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                        <div>
                            <p class="text-sm font-semibold text-white">
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
                            <a
                                href="{{ route('employer.comments.show', $comment) }}"
                                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-3 py-1 font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200"
                            >
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
                    No comments yet for this Job.
                </div>
            @endforelse
        </section>

        @if ($comments instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="pt-4">
                {{ $comments->links() }}
            </div>
        @endif
</x-employer-layout>
