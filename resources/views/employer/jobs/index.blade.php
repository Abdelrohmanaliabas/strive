<x-employer-layout>
    <div class="space-y-10 px-6 py-10 lg:px-12">
        <header class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-300/80">Job portfolio</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Your job posts</h1>
                <p class="mt-2 text-sm text-slate-400">
                    Monitor every listing, tune the story, and keep the hiring journey aligned.
                </p>
            </div>
            <a
                href="{{ route('employer.jobs.create') }}"
                class="inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-6 py-2.5 text-sm font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20"
            >
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-cyan-400/20 text-cyan-200">+</span>
                Post new job
            </a>
        </header>

        <section class="rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
            <form method="GET" action="{{ route('employer.jobs.index') }}" class="grid gap-4 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-4">
                    <label for="search" class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                        Search
                    </label>
                    <div class="mt-2 flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-950/40 px-3 py-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="m21 21-3.5-3.5m0-6.5a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Title or location"
                            class="w-full bg-transparent text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none"
                        >
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <label for="category" class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                        Category
                    </label>
                    <div class="mt-2">
                        <select
                            name="category"
                            id="category"
                            class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-slate-200 focus:border-cyan-400/50 focus:outline-none"
                        >
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <label for="status" class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">
                        Status
                    </label>
                    <div class="mt-2">
                        <select
                            name="status"
                            id="status"
                            class="w-full rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-2.5 text-sm text-slate-200 focus:border-emerald-400/50 focus:outline-none"
                        >
                            <option value="">All statuses</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                            <option value="approved" @selected(request('status') == 'approved')>Approved</option>
                            <option value="rejected" @selected(request('status') == 'rejected')>Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:border-cyan-400/50 hover:bg-white/10"
                    >
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 5h16m-4 0v14l-4-3-4 3V5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </section>

        @forelse ($jobs as $job)
            @php
                $postedAgo = optional($job->created_at)?->diffForHumans();
            @endphp
            <article class="group rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl transition duration-200 hover:-translate-y-1 hover:border-cyan-400/40">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/80">
                            {{ optional($job->category)->name ?? 'Uncategorized' }}
                        </p>
                        <h2 class="text-2xl font-bold text-white">{{ $job->title }}</h2>
                        <p class="text-sm text-slate-400">
                            {{ $job->location ?? 'Location flexible' }}
                            <span class="mx-2 text-slate-600">•</span>
                            {{ ucfirst($job->work_type ?? 'hybrid') }}
                        </p>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">
                            Posted {{ $postedAgo ?? '—' }}
                        </p>
                    </div>
                    <dl class="grid w-full gap-4 text-center sm:grid-cols-3 lg:max-w-lg">
                        <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Applications</dt>
                            <dd class="mt-1 text-lg font-semibold text-white">{{ number_format($job->applications()->count()) }}</dd>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</dt>
                            <dd class="mt-1 text-sm font-semibold text-cyan-200">{{ ucfirst($job->status ?? 'pending') }}</dd>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">
                            <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Deadline</dt>
                            <dd class="mt-1 text-sm font-semibold text-white">
                                {{ $job->application_deadline ? \Illuminate\Support\Carbon::parse($job->application_deadline)->format('M j, Y') : '—' }}
                            </dd>
                        </div>
                    </dl>
                    <div class="flex flex-col items-stretch gap-2 text-sm sm:flex-row sm:items-center sm:justify-end lg:flex-col lg:items-end">
                        <a
                            href="{{ route('employer.jobs.show', $job) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-white/10 px-5 py-2 font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200"
                        >
                            View details
                        </a>
                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('employer.jobs.edit', $job) }}"
                                class="inline-flex items-center justify-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-4 py-2 font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20"
                            >
                                Edit
                            </a>
                            <form
                                action="{{ route('employer.jobs.destroy', $job) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this job post?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    class="inline-flex items-center justify-center gap-2 rounded-full border border-white/10 px-4 py-2 font-semibold text-rose-200 transition hover:-translate-y-0.5 hover:border-rose-400/40 hover:text-rose-100"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-white/15 bg-slate-950/60 p-12 text-center text-sm text-slate-300">
                <p class="text-lg font-semibold text-white">No job posts yet</p>
                <p class="mt-2 text-slate-400">
                    Publish your first listing to see performance insights and applicant flow here.
                </p>
                <a
                    href="{{ route('employer.jobs.create') }}"
                    class="mt-4 inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-5 py-2.5 text-sm font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20"
                >
                    Create job
                </a>
            </div>
        @endforelse

        @if ($jobs->hasPages())
            <div class="pt-2">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</x-employer-layout>
