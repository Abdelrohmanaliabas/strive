<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\JobPost;
use App\Notifications\JobAppliedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:candidate'])->only(['store', 'cancel']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'resume' => 'required|file|mimes:pdf|max:2048', // PDF only, max 2MB
        ]);

        $candidateId = Auth::id();

        // Handle file upload
        $path = $request->file('resume')->store('resumes', 'public');

        // Check if the candidate already applied
        $application = Application::where('job_post_id', $validated['job_post_id'])
            ->where('candidate_id', $candidateId)
            ->first();

        if ($application) {
            // Delete old resume
            if (Storage::disk('public')->exists($application->resume)) {
                Storage::disk('public')->delete($application->resume);
            }

            // Update existing application
            $application->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'resume' => $path,
                'status' => 'pending',
            ]);
        } else {
            // Create new application
            $application = Application::create([
                'job_post_id' => $validated['job_post_id'],
                'candidate_id' => $candidateId,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'resume' => $path,
                'status' => 'pending',
            ]);

            // Increment application analytics
            $job = JobPost::findOrFail($validated['job_post_id']);
            $job->analytic()->updateOrCreate(
                ['job_post_id' => $job->id],
                [
                    'applications_count' => ($job->analytic->applications_count ?? 0) + 1,
                    'last_viewed_at' => now()
                ]
            );
        }

        // Notify employer
        $application->load('jobPost.employer');
        if ($application->jobPost && $application->jobPost->employer) {
            $application->jobPost->employer->notify(new JobAppliedNotification($application));
        }

        return redirect()->route('jobs.show', $validated['job_post_id'])
                         ->with('success', 'Your application was submitted successfully!');
    }

    public function cancel($id)
    {
        $application = Application::where('id', $id)
            ->where('candidate_id', Auth::id())
            ->firstOrFail();

        if (in_array($application->status, ['accepted', 'rejected'])) {
            return back()->with('error', 'You cannot cancel an application that is already accepted or rejected.');
        }

        $application->update(['status' => 'cancelled']);

        return back()->with('success', 'Your application has been cancelled.');
    }

}
