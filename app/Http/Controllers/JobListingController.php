<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    

    /**
     * Display a listing of approved job posts with filters.
     */
    public function index(Request $request)
    {
        $perPage = 12;

        // Base query: only approved posts
        $query = JobPost::query()
            ->with(['employer', 'category'])
            ->where('status', 'approved');

        // Keyword search.
        if ($q = $request->query('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('skills', 'like', "%{$q}%")
                    ->orWhere('requirements', 'like', "%{$q}%");
            });
        }

        // Category filter (assume category id passed).
        if ($category = $request->query('category')) {
            $query->where('category_id', $category);
        }

        // Location filter
        if ($location = $request->query('location')) {
            $query->where('location', 'like', "%{$location}%");
        }

        // Work type
        if ($workType = $request->query('work_type')) {
            $query->where('work_type', $workType);
        }

        // Technology filter (job_posts.technologies contains the tech string)
        if ($tech = $request->query('technology')) {
            // assume technologies stored as comma-separated text like "PHP, Laravel, MySQL"
            // Use LIKE to find tech; wrap with separators to reduce false positives.
            $search = trim($tech);
            $query->where(function($q2) use ($search) {
                $q2->where('technologies', 'like', "{$search},%")
                   ->orWhere('technologies', 'like', "%, {$search},%")
                   ->orWhere('technologies', 'like', "%, {$search}")
                   ->orWhere('technologies', 'like', "%{$search}%"); // fallback
            });
        }

        // filter by salary_range string (simple contains)
        if ($salary = $request->query('salary')) {
            $query->where('salary_range', 'like', "%{$salary}%");
        }

        // Sorting: newest first
        $jobs = $query->latest('created_at')->paginate($perPage)->withQueryString();

        // For filters UI: list of categories
        $categories = JobCategory::orderBy('name')->get();

        return view('jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Display a single job post.
     */
    // public function show(JobPost $jobPost)
    // {
    //     $jobPost->load(['employer','category','applications']);

    //     // Optionally record analytics (increment view count) — careful: do not alter schema here if you need to.
    //     // If you have an analytics table, update or create record here.

    //     return view('jobs.show', compact('jobPost'));
    // }

    public function show(JobPost $jobPost)
    {
        $jobPost->load([
            'employer',
            'category',
            'comments.user',
            'applications',
            'analytic'
        ]);

        // Record view analytics
        $analytic = $jobPost->analytic()->firstOrCreate(['job_post_id' => $jobPost->id]);
        $analytic->increment('views_count');
        $analytic->update(['last_viewed_at' => now()]);

        // Fetch comments with nested replies
        // $comments = $jobPost->comments()->whereNull('parent_id')->with('user')->latest()->get();
        $comments = $jobPost->comments()->with('user')->latest()->get();


        return view('jobs.show', compact('jobPost', 'comments'));
    }


}






