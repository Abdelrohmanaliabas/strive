<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $employer = auth()->user();

        $jobQuery = JobPost::query()
            ->where('employer_id', $employer->id);

        $jobIds = (clone $jobQuery)->pluck('id');

        $jobs = (clone $jobQuery)
            ->with(['category:id,name', 'analytic'])
            ->withCount('applications')
            ->orderByDesc('created_at')
            ->get();

        $applicationsQuery = Application::query()
            ->whereIn('job_post_id', $jobIds);

        $metrics = $this->buildMetricSummary($jobQuery, $applicationsQuery);
        $applicationsTrend = $this->applicationsTrend($applicationsQuery, 14);
        $applicationsByStatus = $this->applicationsByStatus($applicationsQuery);
        $applicationsByJob = $this->applicationsByJob($jobs);
        $recentApplicants = $this->recentApplicants(
            (clone $applicationsQuery)->with(['candidate:id,name,email', 'jobPost:id,title'])
        );

        $applicationsSample = (clone $applicationsQuery)
            ->with(['jobPost:id,title,category_id', 'jobPost.category:id,name'])
            ->latest('created_at')
            ->limit(200)
            ->get();

        return view('employer.dashboard', [
            'metrics' => $metrics,
            'jobSnapshots' => $applicationsByJob['rows']->take(3),
            'applicationsTrend' => $applicationsTrend,
            'applicationsByStatus' => $applicationsByStatus,
            'applicationsByJob' => $applicationsByJob,
            'recentApplicants' => $recentApplicants,
            'pipeline' => $this->pipelineFromStatuses($applicationsByStatus['series'], $metrics['applications_total']),
            'StriveSignals' => $this->StriveSignals($jobs, $applicationsSample, $applicationsByStatus['series']),
        ]);
    }

    private function buildMetricSummary(Builder $jobQuery, Builder $applicationsQuery): array
    {
        $jobsTotal = (clone $jobQuery)->count();
        $applicationsTotal = (clone $applicationsQuery)->count();
        $candidatesTotal = $this->countUniqueCandidates($applicationsQuery);

        $trendWindow = 7;
        $currentWindowStart = Carbon::today()->subDays($trendWindow - 1)->startOfDay();
        $previousWindowStart = Carbon::today()->subDays(($trendWindow * 2) - 1)->startOfDay();
        $previousWindowEnd = $currentWindowStart->copy()->subSecond();

        $jobsCurrent = (clone $jobQuery)->whereBetween('created_at', [$currentWindowStart, now()])->count();
        $jobsPrevious = (clone $jobQuery)->whereBetween('created_at', [$previousWindowStart, $previousWindowEnd])->count();

        $applicationsCurrent = (clone $applicationsQuery)->whereBetween('created_at', [$currentWindowStart, now()])->count();
        $applicationsPrevious = (clone $applicationsQuery)->whereBetween('created_at', [$previousWindowStart, $previousWindowEnd])->count();

        $candidatesCurrent = $this->countUniqueCandidates(
            (clone $applicationsQuery)->whereBetween('created_at', [$currentWindowStart, now()])
        );
        $candidatesPrevious = $this->countUniqueCandidates(
            (clone $applicationsQuery)->whereBetween('created_at', [$previousWindowStart, $previousWindowEnd])
        );

        $cards = [
            [
                'label' => 'Total job posts',
                'value' => $jobsTotal,
                'trend' => $this->formatTrend($jobsCurrent, $jobsPrevious),
                'trend_copy' => 'New this week',
                'trend_class' => $this->trendClass($jobsCurrent, $jobsPrevious),
            ],
            [
                'label' => 'Applications received',
                'value' => $applicationsTotal,
                'trend' => $this->formatTrend($applicationsCurrent, $applicationsPrevious),
                'trend_copy' => 'Past 7 days',
                'trend_class' => $this->trendClass($applicationsCurrent, $applicationsPrevious),
            ],
            [
                'label' => 'Unique candidates',
                'value' => $candidatesTotal,
                'trend' => $this->formatTrend($candidatesCurrent, $candidatesPrevious),
                'trend_copy' => 'New voices this week',
                'trend_class' => $this->trendClass($candidatesCurrent, $candidatesPrevious),
            ],
            [
                'label' => 'Avg. applications per job',
                'value' => $jobsTotal > 0
                    ? number_format($applicationsTotal / max($jobsTotal, 1), 1)
                    : '0.0',
                'trend' => null,
                'trend_copy' => 'Across all live postings',
                'trend_class' => 'text-secondary',
            ],
        ];

        return [
            'jobs_total' => $jobsTotal,
            'applications_total' => $applicationsTotal,
            'candidates_total' => $candidatesTotal,
            'cards' => $cards,
        ];
    }

    private function applicationsTrend(Builder $applications, int $days): array
    {
        $start = Carbon::today()->subDays($days - 1)->startOfDay();

        $dailyCounts = (clone $applications)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        $period = collect(range(0, $days - 1))->map(
            fn(int $offset) => $start->copy()->addDays($offset)
        );

        return [
            'labels' => $period->map->format('M j'),
            'data' => $period->map(function (Carbon $day) use ($dailyCounts) {
                return (int) ($dailyCounts[$day->format('Y-m-d')] ?? 0);
            }),
        ];
    }

    private function applicationsByStatus(Builder $applications): array
    {
        $statusCounts = (clone $applications)
            ->selectRaw("LOWER(COALESCE(NULLIF(status, ''), 'pending')) as status, COUNT(*) as total")
            ->groupBy('status')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn($row) => [$row->status => (int) $row->total]);

        return [
            'labels' => $statusCounts->keys()->map(fn(string $status) => ucfirst($status)),
            'data' => $statusCounts->values(),
            'series' => $statusCounts,
        ];
    }

    private function applicationsByJob(Collection $jobs): array
    {
        $topJobs = $jobs->sortByDesc('applications_count')->take(6)->values();

        return [
            'labels' => $topJobs->pluck('title'),
            'data' => $topJobs->pluck('applications_count'),
            'rows' => $topJobs->map(function (JobPost $job) {
                $editUrl = null;

                if (\Illuminate\Support\Facades\Route::has('employer.jobs.edit')) {
                    $editUrl = route('employer.jobs.edit', $job);
                } elseif (\Illuminate\Support\Facades\Route::has('jobs.edit')) {
                    $editUrl = route('jobs.edit', $job);
                }

                return [
                    'title' => $job->title,
                    'category' => optional($job->category)->name ?? 'Uncategorized',
                    'location' => $job->location ?? '-',
                    'workplace' => ucfirst($job->work_type ?? 'Hybrid'),
                    'views' => optional($job->analytic)->views_count ?? 0,
                    'applications' => $job->applications_count,
                    'status' => ucfirst($job->status ?? 'draft'),
                    'url' => $editUrl ?? '#',
                ];
            }),
        ];
    }

    private function recentApplicants(Builder $applications): Collection
    {
        return $applications
            ->latest('created_at')
            ->take(6)
            ->get()
            ->map(function (Application $application) {
                $candidateName = $application->name
                    ?? optional($application->candidate)->name
                    ?? 'New applicant';

                return [
                    'name' => $candidateName,
                    'role' => optional($application->jobPost)->title ?? '-',
                    'applied_at' => optional($application->created_at)->diffForHumans() ?? 'just now',
                    'status' => ucfirst($application->status ?? 'pending'),
                ];
            });
    }

    private function pipelineFromStatuses(Collection $statusCounts, int $totalApplications): array
    {
        $normalized = $statusCounts->mapWithKeys(
            fn($count, $status) => [strtolower((string) $status) => (int) $count]
        );

        $pending = $normalized->get('pending', 0);
        $accepted = $normalized->get('accepted', 0);
        $rejected = $normalized->get('rejected', 0);
        $cancelled = $normalized->get('cancelled', 0);

        return [
            [
                'name' => 'New submissions',
                'description' => 'Awaiting your first review.',
                'count' => $pending,
                'percentage' => $this->percentage($pending, $totalApplications),
            ],
            [
                'name' => 'Advancing',
                'description' => 'Candidates you moved forward.',
                'count' => $accepted,
                'percentage' => $this->percentage($accepted, $totalApplications),
            ],
            [
                'name' => 'Declined',
                'description' => 'Applications you turned down.',
                'count' => $rejected,
                'percentage' => $this->percentage($rejected, $totalApplications),
            ],
            [
                'name' => 'Withdrawn',
                'description' => 'Dropped or cancelled by Strive.',
                'count' => $cancelled,
                'percentage' => $this->percentage($cancelled, $totalApplications),
            ],
        ];
    }

    private function StriveSignals(Collection $jobs, Collection $applicationsSample, Collection $statusCounts): array
    {
        $topCategory = $jobs
            ->filter(fn(JobPost $job) => $job->category !== null)
            ->groupBy(fn(JobPost $job) => $job->category->name)
            ->map->count()
            ->sortDesc();

        $topLocation = $jobs
            ->filter(fn(JobPost $job) => $job->location)
            ->groupBy('location')
            ->map->count()
            ->sortDesc();

        $acceptedRatio = $this->percentage(
            $statusCounts->get('accepted', 0),
            max($statusCounts->sum(), 1)
        );

        $signalTags = $applicationsSample
            ->map(fn(Application $application) => optional($application->jobPost)->category?->name)
            ->filter()
            ->countBy()
            ->sortDesc()
            ->keys()
            ->take(3);

        return [
            [
                'label' => $topCategory->isEmpty()
                    ? 'Diversify categories'
                    : $topCategory->keys()->first() . ' Strive surge',
                'trend' => $topCategory->isEmpty() ? '+0%' : '+' . $topCategory->first() . ' roles',
                'description' => $topCategory->isEmpty()
                    ? 'Publish in more categories to attract fresh profiles.'
                    : 'Most engagement is happening within this category recently.',
                'tags' => $topCategory->keys()->take(3),
            ],
            [
                'label' => $topLocation->isEmpty()
                    ? 'Remote-first interest'
                    : 'Candidates eyeing ' . $topLocation->keys()->first(),
                'trend' => $topLocation->isEmpty() ? '+0%' : '+' . $topLocation->first(),
                'description' => $topLocation->isEmpty()
                    ? 'Remote listings continue to be the most explored option.'
                    : 'This location is capturing the majority of role views.',
                'tags' => $topLocation->keys()->take(3),
            ],
            [
                'label' => 'Offer conversion pulse',
                'trend' => $acceptedRatio . '%',
                'description' => 'Share timely follow-ups to lift interview-to-offer momentum.',
                'tags' => $signalTags,
            ],
        ];
    }

    private function countUniqueCandidates(Builder $applications): int
    {
        $ids = (clone $applications)
            ->whereNotNull('candidate_id')
            ->distinct()
            ->count('candidate_id');

        $emails = (clone $applications)
            ->whereNull('candidate_id')
            ->whereNotNull('email')
            ->distinct()
            ->count('email');

        return $ids + $emails;
    }

    private function formatTrend(int $current, int $previous): string
    {
        $delta = $this->trendDelta($current, $previous);
        $sign = $delta > 0 ? '+' : '';

        return $sign . number_format($delta, 0) . '%';
    }

    private function trendClass(int $current, int $previous): string
    {
        $delta = $this->trendDelta($current, $previous);

        return $delta >= 0 ? 'text-success' : 'text-danger';
    }

    private function trendDelta(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    private function percentage(int $count, int $total): int
    {
        if ($total === 0) {
            return 0;
        }

        return (int) round(($count / $total) * 100);
    }
}
