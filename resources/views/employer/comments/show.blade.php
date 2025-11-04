<x-employer-layout>
    <div class="space-y-10 px-6 py-8 lg:px-12">
        <header class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Feedback spotlight</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Comment detail</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Attached to {{ $job->title }}
                </p>
            </div>
            <a
                href="{{ route('employer.comments.index') }}"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200"
            >
                Back to comments
            </a>
        </header>

        <section class="grid gap-6 lg:grid-cols-12">
            <article class="space-y-6 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl lg:col-span-8">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <p class="text-sm font-semibold text-white">
                            {{ optional($comment->user)->name ?? 'Anonymous' }}
                        </p>
                        <p class="text-xs text-slate-400">
                            {{ optional($comment->created_at)?->toDayDateTimeString() ?? 'just now' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-emerald-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                        {{ $job->title }}
                    </span>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-6 text-sm leading-relaxed text-slate-200">
                    {!! nl2br(e($comment->content)) !!}
                </div>
            </article>

            <aside class="space-y-6 lg:col-span-4">
                <div class="rounded-3xl border border-white/5 bg-gradient-to-br from-cyan-500/10 via-emerald-500/10 to-transparent p-6 shadow-2xl">
                    <h2 class="text-base font-semibold text-white">Job snapshot</h2>
                    <dl class="mt-4 space-y-3 text-sm text-slate-200">
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Location</dt>
                            <dd class="font-semibold text-white">{{ $job->location ?? 'Global' }}</dd>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Work type</dt>
                            <dd class="font-semibold text-white">{{ ucfirst($job->work_type ?? 'hybrid') }}</dd>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3">
                            <dt class="text-xs uppercase tracking-[0.25em] text-slate-500">Published</dt>
                            <dd class="font-semibold text-white">
                                {{ optional($job->created_at)?->toFormattedDateString() ?? '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="rounded-3xl border border-dashed border-white/10 p-6 text-sm text-slate-400">
                    Bring in your workflow—turn these insights into tasks, follow-ups, or share them with the hiring team.
                </div>
            </aside>
        </section>
    </div>
</x-employer-layout>
