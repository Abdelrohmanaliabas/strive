<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ApplicationEmployerController extends Controller
{
    public function index(): View
    {
        $employerId = Auth::id();

        $applications = Application::query()
            ->whereHas('jobPost', fn($query) => $query->where('employer_id', $employerId))
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

    public function updateStatus(Request $request, Application $application): RedirectResponse
    {
        $this->ensureEmployerOwnsApplication($application);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected'],
        ]);

        $newStatus = $validated['status'];

        if ($application->status !== $newStatus) {
            $application->forceFill(['status' => $newStatus])->save();
        }

        return back()->with('status', __('Application status updated to :status.', ['status' => ucfirst($newStatus)]));
    }

    private function ensureEmployerOwnsApplication(Application $application): void
    {
        $employerId = Auth::id();
        $jobEmployerId = optional($application->jobPost)->employer_id;

        abort_unless($jobEmployerId !== null && (int) $jobEmployerId === $employerId, 403);
    }

    public function download($id)
    {
        $application = Application::findOrFail($id);
        $this->ensureEmployerOwnsApplication($application);

        $resume = $application->resume;

        // If resume is an external URL, redirect the browser there
        if (preg_match('#^https?://#i', $resume)) {
            return redirect()->away($resume);
        }

        // Otherwise assume it's stored in public disk
        $path = 'resumes/' . basename($resume);
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Resume file not found.');
        }

        $filename = basename($resume);
        return response()->streamDownload(function () use ($path) {
            echo Storage::disk('public')->get($path);
        }, $filename, [
            'Content-Type' => Storage::disk('public')->mimeType($path),
        ]);
    }

}
