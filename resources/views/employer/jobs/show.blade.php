<x-employer-layout>

    <div class="space-y-10 px-6 py-10 lg:px-12">

        <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-300/80">Role spotlight</p>

                <h1 class="mt-2 text-3xl font-bold text-white">{{ $job->title }}</h1>

                <p class="mt-2 text-sm text-slate-400">

                    {{ $job->location ?? 'Location flexible' }}

                    <span class="mx-2 text-slate-500">•</span>

                    {{ ucfirst($job->work_type ?? 'hybrid') }}

                    <span class="mx-2 text-slate-500">•</span>

                    <span class="inline-flex items-center rounded-full border border-white/10 px-3 py-1 text-xs font-semibold text-emerald-200">

                        {{ ucfirst($job->status ?? 'draft') }}

                    </span>

                </p>

            </div>

            <div class="flex flex-wrap gap-2">

                <a href="{{ route('employer.jobs.edit', $job) }}"

                    class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20">

                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">

                        <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897Z" />

                    </svg>

                    Edit

                </a>

                <form

                    action="{{ route('employer.jobs.destroy', $job) }}"

                    method="POST"

                    onsubmit="return confirm('Delete this job?')">

                    @csrf

                    @method('DELETE')

                    <button class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-sm font-semibold text-rose-200 transition hover:-translate-y-0.5 hover:border-rose-400/40 hover:text-rose-100">

                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">

                            <path d="M3 6h18M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6m1 0v14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V6" stroke-linecap="round" stroke-linejoin="round" />

                        </svg>

                        Delete

                    </button>

                </form>

            </div>

        </header>

        <section class="rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

            <div class="grid gap-6 lg:grid-cols-12 lg:items-center">

                @if ($job->logo)

                    <div class="lg:col-span-4">

                        <div class="flex items-center justify-center rounded-3xl border border-white/10 bg-slate-950/60 p-6">

                            <img

                                src="{{ \Illuminate\Support\Str::startsWith($job->logo, ['http://', 'https://']) ? $job->logo : asset('storage/'.$job->logo) }}"

                                alt="Company Logo"

                                class="max-h-28 w-auto"

                            >

                        </div>

                    </div>

                @endif

                <dl class="{{ $job->logo ? 'lg:col-span-8' : 'lg:col-span-12' }} grid gap-4 sm:grid-cols-2">

                    <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">

                        <dt class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Category</dt>

                        <dd class="mt-2 text-sm font-semibold text-white">{{ optional($job->category)->name ?? '—' }}</dd>

                    </div>

                    <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">

                        <dt class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Salary range</dt>

                        <dd class="mt-2 text-sm font-semibold text-white">{{ $job->salary_range ?? 'Not specified' }}</dd>

                    </div>

                    <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">

                        <dt class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Deadline</dt>

                        <dd class="mt-2 text-sm font-semibold text-white">

                            {{ $job->application_deadline ? \Illuminate\Support\Carbon::parse($job->application_deadline)->format('F j, Y') : '—' }}

                        </dd>

                    </div>

                    <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">

                        <dt class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Updated</dt>

                        <dd class="mt-2 text-sm font-semibold text-white">

                            {{ optional($job->updated_at)?->diffForHumans() ?? '—' }}

                        </dd>

                    </div>


                </dl>
            </div>

        </section>

        <section class="grid gap-6 lg:grid-cols-2">

            <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

                <h2 class="text-base font-semibold uppercase tracking-[0.3em] text-slate-300">Job description</h2>

                <p class="text-sm leading-relaxed text-slate-200">

                    {!! nl2br(e($job->description ?? 'No description provided.')) !!}

                </p>

            </article>

            <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

                <h2 class="text-base font-semibold uppercase tracking-[0.3em] text-slate-300">Responsibilities</h2>

                <p class="text-sm leading-relaxed text-slate-200">

                    {!! nl2br(e($job->responsibilities ?? '—')) !!}

                </p>

            </article>

            <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

                <h2 class="text-base font-semibold uppercase tracking-[0.3em] text-slate-300">Requirements</h2>

                <p class="text-sm leading-relaxed text-slate-200">

                    {!! nl2br(e($job->requirements ?? '—')) !!}

                </p>

            </article>

            <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

                <h2 class="text-base font-semibold uppercase tracking-[0.3em] text-slate-300">Skills</h2>

                <p class="text-sm leading-relaxed text-slate-200">

                    {!! nl2br(e($job->skills ?? '—')) !!}

                </p>

            </article>

        </section>

        <section class="grid gap-6 lg:grid-cols-2">

            @if ($job->technologies)

                <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

                    <h2 class="text-base font-semibold uppercase tracking-[0.3em] text-slate-300">Technologies</h2>

                    <div class="flex flex-wrap gap-2 text-xs">

                        @foreach (array_filter(array_map('trim', explode(',', $job->technologies))) as $tech)

                            <span class="inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-3 py-1 font-semibold text-cyan-200">

                                {{ $tech }}

                            </span>

                        @endforeach

                    </div>

                </article>

            @endif
            @if ($job->benefits)

                <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">

                    <h2 class="text-base font-semibold uppercase tracking-[0.3em] text-slate-300">Benefits</h2>

                    <p class="text-sm leading-relaxed text-slate-200">

                        {!! nl2br(e($job->benefits)) !!}

                    </p>

                </article>
            @endif
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <article class="space-y-4 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-200/80">Pipeline</p>
                        <h2 class="text-base font-semibold text-white">Applications</h2>
                        <p class="text-sm text-slate-300 mt-1">{{ $applications->count() }} applications for this job</p>
                    </div>

                    <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}"
                    class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400/40 hover:text-cyan-200">
                    View All
                    </a>
                </div>
            </article>

            <article class="space-y-5 rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">  
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-white">Comments</h2>
                        <p class="text-sm text-slate-300 mt-1">{{ $comments->count() }} comments for this job</p>
                    </div>

                    <a href="{{ route('employer.jobs.comments', $job->id) }}"
                    class="text-cyan-400 text-sm font-semibold hover:underline">
                    View Comments
                    </a>

                </div>

            </article>

        <footer class="rounded-3xl border border-white/10 bg-slate-950/60 px-6 py-4 text-xs text-slate-400">

            <p>

                Posted {{ optional($job->created_at)?->diffForHumans() ?? '—' }}

                <span class="mx-2 text-slate-600">•</span>

                ID #{{ $job->id }}

            </p>

        </footer>

    </div>

</x-employer-layout>

