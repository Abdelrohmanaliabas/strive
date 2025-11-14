<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:candidate'])->only(['store']);
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

        // Handle file upload
        $path = $request->file('resume')->store('resumes', 'public');

        // Create the application
        Application::create([
            'job_post_id' => $validated['job_post_id'],
            'candidate_id' => Auth::id() ?? null,
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

        return redirect()->route('jobs.show', $validated['job_post_id'])
                         ->with('success', 'Your application was submitted successfully!');
    }


}



