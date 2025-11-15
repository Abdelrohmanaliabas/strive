<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobListingController extends Controller
{

    public function index(Request $request)
    {
        $perPage = 12;

        // Base query — only approved jobs
        $query = JobPost::query()
            ->with(['employer', 'category'])
            ->where('status', 'approved');

        /*
        |--------------------------------------------------------------------------
        | KEYWORD SEARCH
        |--------------------------------------------------------------------------
        */
        if ($q = $request->query('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('skills', 'like', "%{$q}%")
                    ->orWhere('requirements', 'like', "%{$q}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */
        if ($category = $request->query('category')) {
            $query->where('category_id', $category);
        }

        /*
        |--------------------------------------------------------------------------
        | LOCATION FILTER
        |--------------------------------------------------------------------------
        */
        if ($location = $request->query('location')) {
            $query->where('location', 'like', "%{$location}%");
        }

        /*
        |--------------------------------------------------------------------------
        | WORK TYPE FILTER (remote, onsite, hybrid)
        |--------------------------------------------------------------------------
        */
        if ($workType = $request->query('work_type')) {
            $query->where('work_type', $workType);
        }

        /*
        |--------------------------------------------------------------------------
        | TECHNOLOGY FILTER
        | technologies is stored as a comma-separated string
        |--------------------------------------------------------------------------
        */
        if ($tech = $request->query('technology')) {
            $search = trim($tech);

            $query->where(function ($q2) use ($search) {
                $q2->where('technologies', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | SALARY FILTER
        | salary_range is a plain string ("3000-6000 EGP")
        |--------------------------------------------------------------------------
        */
        if ($salary = $request->query('salary')) {
            $query->where('salary_range', 'like', "%{$salary}%");
        }

        /*
        |--------------------------------------------------------------------------
        | DATE POSTED FILTER
        | Values could be: 1 day, 3 days, 7 days, 30 days, etc.
        |--------------------------------------------------------------------------
        */
        if ($posted = $request->query('posted')) {
            if (is_numeric($posted)) {
                $query->where('created_at', '>=', now()->subDays($posted));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SORT & PAGINATE
        |--------------------------------------------------------------------------
        */
        $jobs = $query->latest('created_at')
                      ->paginate($perPage)
                      ->withQueryString();

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






