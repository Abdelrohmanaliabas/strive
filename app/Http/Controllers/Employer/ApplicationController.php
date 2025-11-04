<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $employerId = Auth::id();

        $applications = Application::query()
            ->whereHas('jobPost', fn ($query) => $query->where('employer_id', $employerId))
            ->with([
                'jobPost:id,title',
                'candidate:id,name,email',
            ])
            ->latest('created_at')
            ->paginate(12);

        return view('employer.applications.index', [
            'applications' => $applications,
        ]);
    }

    public function show(Application $application): View
    {
        $this->ensureEmployerOwnsApplication($application);

        $application->loadMissing([
            'jobPost.category:id,name',
            'candidate:id,name,email',
        ]);

        return view('employer.applications.show', [
            'application' => $application,
        ]);
    }

    private function ensureEmployerOwnsApplication(Application $application): void
    {
        $employerId = Auth::id();
        $jobEmployerId = optional($application->jobPost)->employer_id;

        abort_unless($jobEmployerId !== null && (int) $jobEmployerId === $employerId, 403);
    }
}
