<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobPost::with(['employer', 'category']);

        // 🔍 البحث بالعنوان أو الوصف أو الموقع
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ⚙️ الفلترة حسب الحالة (pending / approved / rejected)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // ⏱ الترتيب حسب الأقدم أو الأحدث
        if ($request->filled('sort') && $request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 📄 التقسيم (Pagination)
        $jobPost = $query->paginate(8)->appends($request->all());

        return view('admin.jobs.index', compact('jobPost'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show(JobPost $post)
    {
        $post->load(['employer', 'category', 'applications.candidate', 'comments.user']);

        return view('admin.jobs.show', [
            'jobPost' => $post,
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $jobPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPostRequest $request, JobPost $jobPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $jobPost)
    {
        //
    }
}
