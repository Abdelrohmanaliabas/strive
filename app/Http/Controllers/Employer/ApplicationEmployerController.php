<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Notifications\ApplicationStatusNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ApplicationEmployerController extends Controller
{
    
    public function index(Request $request): View
    {
        $employerId = Auth::id();
        $jobId = $request->query('job_id');

        $applicationsQuery = Application::query()
            ->whereHas('jobPost', fn($query) => $query->where('employer_id', $employerId))
            ->with(['jobPost:id,title', 'candidate:id,name,email'])
            ->latest('created_at');

        if ($jobId) {
            $applicationsQuery->where('job_post_id', $jobId);
        }

        $applications = $applicationsQuery->paginate(12);

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
            
            // Notify candidate about status change (only for accepted/rejected, not pending)
            if (in_array($newStatus, ['accepted', 'rejected'])) {
                // Ensure jobPost relationship is loaded for the notification
                $application->load('jobPost');
                if ($application->candidate) {
                    $application->candidate->notify(new ApplicationStatusNotification($application, $newStatus));
                }
            }
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
        $resumePath = $application->resume;

        if (preg_match('#^https?://#i', $resumePath)) {
            return redirect()->away($resumePath);
        }

        $fullPath = storage_path('app/public/' . ltrim($resumePath, '/'));
        if (!file_exists($fullPath)) {
            abort(404, 'Resume file not found.');
        }

        return response()->download($fullPath, basename($resumePath));
    }



    public function preview($id)
    {
        $application = Application::findOrFail($id);
        $this->ensureEmployerOwnsApplication($application);

        $resume = $application->resume;

        // External link
        if (preg_match('#^https?://#i', $resume)) {
            return redirect()->away($resume);
        }

        // Local file in public storage
        $path = 'resumes/' . basename($resume);
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Resume file not found.');
        }

        $filePath = Storage::disk('public')->path($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        // Show file inline (inside iframe)
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($resume) . '"',
        ]);
    }

}
