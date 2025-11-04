<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        $employerId = Auth::id();

        $jobs = JobPost::query()
            ->with(['category:id,name', 'analytic'])
            ->withCount('applications')
            ->where('employer_id', $employerId)
            ->latest('created_at')
            ->get();

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create(): View
    {
        $categories = JobCategory::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('employer.jobs.create', compact('categories'));
    }

    public function show(JobPost $job): View
    {
        $this->ensureEmployerOwnsJob($job);

        $job->loadMissing(['category:id,name', 'analytic', 'applications.candidate:id,name,email']);

        return view('employer.jobs.show', [
            'job' => $job,
        ]);
    }

    public function edit(JobPost $job): View
    {
        $this->ensureEmployerOwnsJob($job);

        $categories = JobCategory::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('employer.jobs.edit', [
            'job' => $job->loadMissing(['category:id,name']),
            'categories' => $categories,
        ]);
    }

    /**
     * Guard against accessing another employer's job posting.
     */
    private function ensureEmployerOwnsJob(JobPost $job): void
    {
        abort_unless((int) $job->employer_id === Auth::id(), 403);
    }
}
