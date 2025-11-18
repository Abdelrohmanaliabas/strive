<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Employer dashboard - totals and analysis
     */
    public function index(Request $request)
    {
        $employerId = $request->user()->id;

        // Totals
        $totalJobs = JobPost::where('employer_id', $employerId)->count();
        $openJobs = JobPost::where('employer_id', $employerId)->where('status', 'approved')->count();
        $totalApplications = Application::whereHas('jobPost', fn($q) => $q->where('employer_id', $employerId))->count();

        // Get job ids for comment lookup
        $jobIds = JobPost::where('employer_id', $employerId)->pluck('id')->toArray();

        // Count comments (polymorphic)
        $comments = 0;
        if (!empty($jobIds)) {
            $comments = Comment::whereIn('commentable_id', $jobIds)
                ->where('commentable_type', JobPost::class)
                ->count();
        }

        // New applications last 7 days
        $newApplicationsWeek = Application::whereHas('jobPost', fn($q) => $q->where('employer_id', $employerId))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();

        // Total unique candidates
        $candidateCount = Application::whereHas('jobPost', fn($q) => $q->where('employer_id', $employerId))
            ->distinct('candidate_id')
            ->count('candidate_id');

        // KPI Cards
        $metricCards = [
            [
                'label' => 'Total Posts',
                'value' => $totalJobs,
                'trend' => $openJobs > 0 ? "{$openJobs} currently open" : 'No open roles',
            ],
            [
                'label' => 'Applications Received',
                'value' => $totalApplications,
                'trend' => $newApplicationsWeek > 0 ? "{$newApplicationsWeek} this week" : 'No new applicants this week',
            ],
            [
                'label' => 'Candidates',
                'value' => $candidateCount,
                'trend' => $candidateCount > 0 ? "actively engaged" : 'Awaiting applicants',
            ],
            [
                'label' => 'Total Comments',
                'value' => $comments,
                'trend' => $comments > 0 ? 'Feedbacks received' : 'No comments yet',
            ],
        ];


        // Applications trend (last 14 days)
        $start = Carbon::today()->subDays(13);
        $rawTrend = Application::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as cnt'))
            ->whereHas('jobPost', fn($q) => $q->where('employer_id', $employerId))
            ->where('created_at', '>=', $start)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('cnt', 'date')
            ->toArray();

        $trendLabels = [];
        $trendData = [];
        for ($i = 0; $i < 14; $i++) {
            $d = $start->copy()->addDays($i)->toDateString();
            $trendLabels[] = $d;
            $trendData[] = intval($rawTrend[$d] ?? 0);
        }

        // Applications by status
        $byStatus = Application::select('status', DB::raw('count(*) as cnt'))
            ->whereHas('jobPost', fn($q) => $q->where('employer_id', $employerId))
            ->groupBy('status')
            ->orderByDesc('cnt')
            ->pluck('cnt', 'status')
            ->toArray();

        $statusLabels = array_keys($byStatus);
        $statusSeries = array_values($byStatus);

        // Pipeline stages by status
        $totalPipeline = array_sum($byStatus);
        $pipeline = $totalPipeline > 0
            ? collect($byStatus)->map(function ($count, $status) use ($totalPipeline) {
                $percentage = round(($count / $totalPipeline) * 100);

                return [
                    'name' => ucfirst($status),
                    'description' => "Applications marked as {$status}",
                    'percentage' => $percentage,
                ];
            })->values()->toArray()
            : [];

        // Top job posts by applications
        $topJobsRaw = Application::select('job_post_id', DB::raw('count(*) as cnt'))
            ->whereHas('jobPost', fn($q) => $q->where('employer_id', $employerId))
            ->groupBy('job_post_id')
            ->orderByDesc('cnt')
            ->limit(6)
            ->get();

        $topJobs = $topJobsRaw->map(function ($r) {
            $job = JobPost::with('category')->find($r->job_post_id);
            return [
                'title' => $job->title ?? 'Untitled role',
                'category' => optional($job->category)->name ?? 'General',
                'location' => $job->location ?? 'Remote',
                'applications' => intval($r->cnt),
                'views' => $job->views ?? 0,
            ];
        })->toArray();
        $topJobLabels = collect($topJobs)->pluck('title')->values()->toArray();
        $topJobSeries = collect($topJobs)->pluck('applications')->values()->toArray();

        // Active job snapshots
        $jobSnapshots = JobPost::with('category')
            ->withCount('applications')
            ->where('employer_id', $employerId)
            ->whereIn('status', ['approved'])
            ->where(function ($query) {
                $query->whereNull('application_deadline')
                    ->orWhere('application_deadline', '>=', Carbon::now());
            })
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(function ($job) {
                $jobShowRoute =  route('employer.jobs.show', $job);

                return [
                    'title' => $job->title,
                    'category' => optional($job->category)->name ?? 'General',
                    'location' => $job->location ?? 'Remote',
                    'workplace' => $job->work_type ?? 'Remote',
                    'applications' => $job->applications_count ?? $job->applications()->count(),
                    'comments' => Comment::where('commentable_id', $job->id)
                        ->where('commentable_type', JobPost::class)
                        ->count() ?? 0,
                    'status' => ucfirst($job->status ?? 'open'),
                    'url' => $jobShowRoute,
                ];
            })
            ->toArray();

        // Route links
        $jobCreateLink = route('employer.jobs.create');
        $applicationsLink =route('employer.applications.index');


        return view('employer.dashboard', compact(
            'metricCards',
            'trendLabels',
            'trendData',
            'statusLabels',
            'statusSeries',
            'topJobLabels',
            'topJobSeries',
            'topJobs',
            'jobSnapshots',
            'pipeline',
            'jobCreateLink',
            'applicationsLink'
        ));
    }
}
