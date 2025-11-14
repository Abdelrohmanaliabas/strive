<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobPost::with(['employer', 'category']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('sort') && $request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
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

    public function edit(JobPost $post)
    {
        $allowedStatuses = [];
        if ($post->status === 'pending') {
            $allowedStatuses = ['approved', 'rejected'];
        }

        return view('admin.jobs.edit', [
            'jobPost' => $post,
            'allowedStatuses' => $allowedStatuses,
        ]);
    }

    public function update(Request $request, JobPost $post)
    {
        // لو الحالة الحالية مش pending → ممنوع التعديل
        if ($post->status !== 'pending') {
            return redirect()->route('admin.jobpost.show', $post->id)
                ->with('error', 'You cannot change the status after it has been approved or rejected.');
        }

        // السماح فقط بـ approved أو rejected
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $post->update(['status' => $validated['status']]);

        return redirect()->route('admin.jobpost.show', $post->id)
            ->with('success', 'Job status updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $jobPost)
    {
        //delete logic here
        $jobPost->delete();
        return redirect()->route('admin.jobpost.index')
            ->with('success', 'Job post deleted successfully.');
    }
}
