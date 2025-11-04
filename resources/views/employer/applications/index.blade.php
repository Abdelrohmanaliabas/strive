<x-employer-layout>
    <div class="space-y-10 px-6 py-8 lg:px-12">
        <header class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Strive pipeline</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Applications</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Review every applicant, track their stage, and dive into detailed submissions.
                </p>
            </div>
            <a
                href="{{ route('employer.jobs.index') }}"
                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200"
            >
                Back to jobs
            </a>
        </header>

        <section class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
            <div class="hidden grid-cols-[2fr,2fr,1fr,1fr,auto] items-center gap-4 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 md:grid">
                <span>Candidate</span>
                <span>Role</span>
                <span>Status</span>
                <span>Applied</span>
                <span></span>
            </div>
            <div class="space-y-4">
                @forelse ($applications as $application)
                    <article class="grid gap-3 rounded-2xl border border-white/10 bg-slate-950/60 p-4 md:grid-cols-[2fr,2fr,1fr,1fr,auto] md:items-center">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                {{ $application->name ?? optional($application->candidate)->name ?? 'New applicant' }}
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $application->email ?? optional($application->candidate)->email ?? '—' }}
                            </p>
                        </div>
                        <div class="text-sm text-slate-300">
                            {{ optional($application->jobPost)->title ?? 'Role archived' }}
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-emerald-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                                {{ ucfirst($application->status ?? 'pending') }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ optional($application->created_at)?->diffForHumans() ?? 'just now' }}
                        </div>
                        <div class="flex justify-end">
                            <a
                                href="{{ route('employer.applications.show', $application) }}"
                                class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200"
                            >
                                View
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-white/10 p-12 text-center text-sm text-slate-300">
                        No applications yet. Once candidates apply to your postings, they will appear in this journey view.
                    </div>
                @endforelse
            </div>
        </section>

        @if ($applications instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="pt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</x-employer-layout>
