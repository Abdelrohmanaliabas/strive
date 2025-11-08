<x-employer-layout>
    @php
        $metricCards = $metrics['cards'] ?? [];
        $jobSnapshots = collect($jobSnapshots ?? []);
        $recentApplicants = collect($recentApplicants ?? []);
        $pipeline = collect($pipeline ?? []);

        $trendLabels = collect($applicationsTrend['labels'] ?? [])->values();
        $trendSeries = collect($applicationsTrend['data'] ?? [])->values();

        $statusLabels = collect($applicationsByStatus['labels'] ?? [])->values();
        $statusSeries = collect($applicationsByStatus['data'] ?? [])->values();
        $statusPairs = collect($applicationsByStatus['series'] ?? [])->map(function ($count, $status) {
            return ['status' => ucfirst($status), 'count' => $count];
        });

        $topJobLabels = collect($applicationsByJob['labels'] ?? [])->values();
        $topJobSeries = collect($applicationsByJob['data'] ?? [])->values();
        $topJobRows = collect($applicationsByJob['rows'] ?? []);

        $jobCreateLink = Route::has('employer.jobs.create')
            ? route('employer.jobs.create')
            : (Route::has('jobs.create') ? route('jobs.create') : '#');
        $applicationsLink = Route::has('employer.applications.index')
            ? route('employer.applications.index')
            : (Route::has('applications.index') ? route('applications.index') : '#');
    @endphp

    <div class="relative min-h-full bg-slate-950 text-slate-100">
        <div class="absolute inset-0 pointer-events-none opacity-60 bg-[radial-gradient(circle_at_top,_rgba(45,212,191,0.18),_transparent_55%)]"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 pointer-events-none opacity-[0.22] bg-[radial-gradient(circle_at_center,_rgba(14,165,233,0.3),_transparent_65%)]"></div>

        <div class="relative z-10 px-6 py-10 space-y-12 lg:px-10">
            <header class="flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-300/80">Employer Command Center</p>
                    <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-white">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-3 text-sm text-slate-300/80">
                        Track hiring momentum and stay ahead of every application in one cinematic overview.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ $jobCreateLink }}" class="inline-flex items-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-5 py-2.5 text-sm font-semibold tracking-wide text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-cyan-400/20 text-cyan-200">+</span>
                        New job post
                    </a>
                    <a href="{{ $applicationsLink }}" class="inline-flex items-center gap-2 rounded-full border border-emerald-400/40 bg-emerald-400/10 px-5 py-2.5 text-sm font-semibold tracking-wide text-emerald-200 transition hover:-translate-y-0.5 hover:bg-emerald-400/15">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-300"></span>
                        Review applicants
                    </a>
                    {{-- <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-sm font-semibold tracking-wide text-slate-200 transition hover:-translate-y-0.5 hover:border-rose-400/40 hover:text-rose-100"
                        >
                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-rose-300"></span>
                            Log out
                        </button>
                    </form> --}}
                </div>
            </header>

            <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($metricCards as $card)
                    <article class="group relative overflow-hidden rounded-3xl border border-white/5 bg-white/5 p-6 shadow-[0_20px_45px_-30px_rgba(45,212,191,0.8)] backdrop-blur transition duration-200 hover:-translate-y-1 hover:border-cyan-400/40">
                        <div class="absolute -right-10 top-1/2 hidden h-40 w-40 -translate-y-1/2 rotate-12 rounded-full bg-cyan-400/10 blur-3xl sm:block"></div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $card['label'] }}</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <p class="text-4xl font-extrabold text-white">{{ $card['value'] }}</p>
                        </div>
                        <p class="mt-3 text-xs text-slate-400">{{ $card['trend_copy'] ?? '' }}</p>
                    </article>
                @endforeach
            </section>

            <section class="grid gap-6 lg:grid-cols-12">
                <div class="space-y-6 lg:col-span-8">
                    <article class="overflow-hidden rounded-3xl border border-white/5 bg-gradient-to-br from-slate-900/90 via-slate-900/70 to-slate-900/50 shadow-2xl">
                        <header class="flex items-center justify-between border-b border-white/5 px-6 py-5">
                            <div>
                                <h2 class="text-base font-semibold uppercase tracking-[0.2em] text-slate-300">Active job performance</h2>
                                <p class="mt-1 text-sm text-slate-400">Watch how Strive is engaging with your open roles.</p>
                            </div>
                        </header>
                        <div class="divide-y divide-white/5">
                            @forelse ($jobSnapshots as $job)
                                <div class="flex flex-col gap-4 px-6 py-5 md:flex-row md:items-center md:justify-between">
                                    <div class="w-50 space-y-2">
                                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-200/80">{{ $job['category'] }}</p>
                                        <h3 class="mt-1 text-xl font-bold text-white">{{ $job['title'] }}</h3>
                                        <p class="mt-2 text-sm text-slate-400">{{ $job['location'] }} &middot; {{ $job['workplace'] }}</p>
                                    </div>
                                    <dl class="grid flex-1 grid-cols-3 gap-4 text-center">
                                        <a
                                            href="{{ $job['detail_url'] ?? $job['url'] ?? '#' }}"
                                            class="rounded-2xl border border-white/5 bg-white/5 px-3 py-2 transition hover:-translate-y-0.5 hover:border-cyan-400/40"
                                            title="Read comments for {{ $job['title'] }}"
                                        >
                                            <dt class="text-xs font-semibold uppercase  text-slate-400">Comments</dt>
                                            <dd class="mt-1 text-lg font-semibold text-white">{{ number_format($job['comments']) }}</dd>
                                        </a>
                                        <a
                                            href="{{ $job['detail_url'] ?? $job['url'] ?? '#' }}"
                                            class="rounded-2xl border border-white/5 bg-white/5 px-3 py-2 transition hover:-translate-y-0.5 hover:border-emerald-400/40"
                                            title="Review applicants for {{ $job['title'] }}"
                                        >
                                            <dt class="text-xs font-semibold uppercase  text-slate-400">Applicants</dt>
                                            <dd class="mt-1 text-lg font-semibold text-white">{{ number_format($job['applications']) }}</dd>
                                        </a>
                                        <a
                                            href="{{ $job['detail_url'] ?? $job['url'] ?? '#' }}"
                                            class="rounded-2xl border border-white/5 bg-white/5 px-3 py-2 transition hover:-translate-y-0.5 hover:border-amber-400/40"
                                            title="Manage {{ $job['title'] }} status"
                                        >
                                            <dt class="text-xs font-semibold uppercase  text-slate-400">Status</dt>
                                            <dd class="mt-1 text-lg font-semibold text-white">{{ $job['status'] }}</dd>
                                        </a>
                                    </dl>
                                    {{-- <div class="flex flex-col items-stretch gap-2 text-sm">
                                        <a href="{{ $job['url'] }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-cyan-400/40 bg-cyan-400/10 px-4 py-2 font-semibold text-cyan-200 transition hover:-translate-y-0.5 hover:bg-cyan-400/20">
                                            Manage posting
                                        </a>
                                        <a href="{{ route('employer.jobs.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/10 px-4 py-2 text-slate-300 transition hover:-translate-y-0.5 hover:border-emerald-400/40 hover:text-emerald-200">
                                            Boost visibility
                                        </a>
                                    </div> --}}
                                </div>
                            @empty
                                <div class="px-6 py-12 text-center text-sm text-slate-400">
                                    Publish your first role to see live engagement here.
                                </div>
                            @endforelse
                        </div>
                    </article>

                    <article class="rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
                        <header class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Application flow</p>
                                <h2 class="mt-2 text-2xl font-bold text-white">Daily applicant velocity</h2>
                            </div>
                            <span class="rounded-full bg-emerald-400/10 px-3 py-1 text-xs font-semibold text-emerald-200">Last 14 days</span>
                        </header>
                        <div class="mt-6 h-64 w-full">
                            <canvas id="applicationsTrendChart"></canvas>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
                        <header class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/80">Candidate journey</p>
                                <h2 class="mt-2 text-2xl font-bold text-white">Pipeline health</h2>
                            </div>
                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs text-slate-300">Auto-tracking</span>
                        </header>
                        <ol class="mt-6 space-y-4">
                            @foreach ($pipeline as $stage)
                                <li class="grid gap-4 rounded-2xl border border-white/5 bg-slate-950/60 p-4 sm:grid-cols-[auto,1fr]">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-emerald-400 text-lg font-bold text-slate-900">
                                            {{ $loop->iteration }}
                                        </div>
                                        <div>
                                            <h3 class="text-base font-semibold text-white">{{ $stage['name'] }}</h3>
                                            <p class="text-xs text-slate-400">{{ $stage['description'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex-1">
                                            <div class="h-2 overflow-hidden rounded-full bg-white/10">
                                                <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-emerald-300" style="width: {{ $stage['percentage'] }}%;"></div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold text-emerald-200">{{ $stage['percentage'] }}%</span>
                                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs text-slate-300">{{ number_format($stage['count']) }} candidates</span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </article>
                </div>

                <aside class="space-y-6 lg:col-span-4">
                    <section class="rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
                        <header class="flex items-center justify-between">
                            <h2 class="text-base font-semibold uppercase tracking-[0.28em] text-slate-300">Status breakdown</h2>
                            <span class="text-xs text-slate-400">Live mix</span>
                        </header>
                        <div class="mt-5">
                            <canvas id="applicationsStatusChart" class="h-56 w-full text-center"></canvas>
                        </div>
                        <ul class="mt-6 space-y-2 text-xs text-slate-300">
                            @foreach ($statusPairs as $row)
                                <li class="flex items-center justify-between rounded-full border border-white/10 bg-white/5 px-3 py-2">
                                    <span>{{ $row['status'] }}</span>
                                    <span class="font-semibold text-white">{{ number_format($row['count']) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <section class="rounded-3xl border border-white/5 bg-white/5 p-6 shadow-2xl">
                        <header class="flex items-center justify-between">
                            <h2 class="text-base font-semibold uppercase tracking-[0.28em] text-slate-300">Applications by role</h2>
                            <span class="text-xs text-slate-400">Top performers</span>
                        </header>
                        <div class="mt-5">
                            <canvas id="applicationsByJobChart" class="h-64 w-full"></canvas>
                        </div>
                        <ul class="mt-6 space-y-3 text-sm text-slate-200">
                            @foreach ($topJobRows as $row)
                                <li class="flex items-start justify-between gap-3 rounded-2xl border border-white/10 bg-slate-950/60 p-3">
                                    <div>
                                        <p class="text-sm font-semibold text-white">{{ $row['title'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $row['category'] }} &middot; {{ $row['location'] }}</p>
                                    </div>
                                    <div class="text-right text-xs text-slate-400">
                                        <p class="font-semibold text-white">{{ number_format($row['applications']) }} applicants</p>
                                        <p>{{ number_format($row['views']) }} views</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>



                    {{-- <section class="rounded-3xl border border-white/5 bg-slate-950/60 p-6 shadow-2xl">
                        <header class="flex items-center justify-between">
                            <h2 class="text-base font-semibold uppercase tracking-[0.28em] text-slate-300">Recent applicants</h2>
                            <a href="{{ $applicationsLink }}" class="text-xs font-semibold text-cyan-200 hover:text-cyan-100">See all</a>
                        </header>
                        <ul class="mt-5 space-y-3">
                            @forelse ($recentApplicants as $applicant)
                                <li class="flex items-center gap-3 rounded-2xl border border-white/5 bg-white/5 p-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 text-sm font-semibold text-white">
                                        {{ strtoupper(substr($applicant['name'], 0, 2)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-white">{{ $applicant['name'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $applicant['role'] }} &middot; {{ $applicant['applied_at'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-400/15 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-emerald-200">
                                        {{ $applicant['status'] }}
                                    </span>
                                </li>
                            @empty
                                <li class="rounded-2xl border border-dashed border-white/10 p-6 text-center text-xs text-slate-400">
                                    Applicants will appear here as soon as you start receiving submissions.
                                </li>
                            @endforelse
                        </ul>
                    </section> --}}
                </aside>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.5/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const trendLabels = @json($trendLabels);
            const trendSeries = @json($trendSeries);
            const statusLabels = @json($statusLabels);
            const statusSeries = @json($statusSeries);
            const jobLabels = @json($topJobLabels);
            const jobSeries = @json($topJobSeries);

            const trendTarget = document.getElementById('applicationsTrendChart');
            if (trendTarget && trendLabels.length) {
                new Chart(trendTarget, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: [
                            {
                                label: 'Applications',
                                data: trendSeries,
                                fill: true,
                                tension: 0.35,
                                borderColor: '#22d3ee',
                                backgroundColor: 'rgba(14, 165, 233, 0.15)',
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                pointBackgroundColor: '#34d399',
                            },
                        ],
                    },
                    options: {
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                ticks: { precision: 0, color: '#cbd5f5' },
                                grid: { color: 'rgba(148, 163, 184, 0.12)' },
                            },
                            x: {
                                ticks: { color: '#94a3b8' },
                                grid: { display: false },
                            },
                        },
                    },
                });
            }

            const statusTarget = document.getElementById('applicationsStatusChart');
            if (statusTarget && statusLabels.length) {
                new Chart(statusTarget, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [
                            {
                                data: statusSeries,
                                backgroundColor: ['#34d399', '#f59e0b', '#38bdf8', '#f87171', '#a855f7'],
                                borderWidth: 0,
                            },
                        ],
                    },
                    options: {
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: '#cbd5f5', usePointStyle: true },
                            },
                        },
                    },
                });
            }

            const jobsTarget = document.getElementById('applicationsByJobChart');
            if (jobsTarget && jobLabels.length) {
                new Chart(jobsTarget, {
                    type: 'bar',
                    data: {
                        labels: jobLabels,
                        datasets: [
                            {
                                label: 'Applicants',
                                data: jobSeries,
                                borderRadius: 14,
                                backgroundColor: 'rgba(16, 185, 129, 0.45)',
                                borderColor: '#10b981',
                            },
                        ],
                    },
                    options: {
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: {
                            x: {
                                ticks: { precision: 0, color: '#94a3b8' },
                                grid: { color: 'rgba(148, 163, 184, 0.1)' },
                            },
                            y: {
                                ticks: { color: '#cbd5f5' },
                                grid: { display: false },
                            },
                        },
                    },
                });
            }
        });
    </script>
</x-employer-layout>
