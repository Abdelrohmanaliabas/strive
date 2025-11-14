<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\JobPostedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class JobEmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $jobs = JobPost::where('employer_id', $user->id)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = JobCategory::all();

        return view('employer.jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = JobCategory::all();
        return view('employer.jobs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPostRequest $request)
    {
        $data = $this->normalizeJobPayload($request->validated());
        $data['employer_id'] = Auth::id();

        //Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadImage($request->file('logo'));
        }

        $jobPost = JobPost::create($data);
        $jobPost->load('employer');

        // Notify all admins about the new job posting
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new JobPostedNotification($jobPost));
        }

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        abort_if($job->employer_id !== Auth::id(), 403);

        $job->load([
            'applications' => function ($query) {
                $query
                    ->with('candidate:id,name,email')
                    ->latest('created_at');
            },
            'comments' => function ($query) {
                $query
                    ->with('user:id,name,email')
                    ->latest('created_at');
            },
            'analytic',
        ]);

        return view('employer.jobs.show', [
            'job' => $job,
            'applications' => $job->applications,
            'comments' => $job->comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job)
    {
        abort_if($job->employer_id !== Auth::id(), 403);

        $categories = JobCategory::all();

        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPostRequest $request, JobPost $job)
    {
        abort_if($job->employer_id !== Auth::id(), 403);

        $data = $this->normalizeJobPayload($request->validated());

        // Replace logo if a new one is uploaded
        if ($request->hasFile('logo')) {
            // Delete old logo file if exists
            if ($job->logo && Storage::disk('public')->exists($job->logo)) {
                Storage::disk('public')->delete($job->logo);
            }

            $data['logo'] = $this->uploadImage($request->file('logo'));
        }

        $job->update($data);

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        abort_if($job->employer_id !== Auth::id(), 403);

        // Delete logo file if exists
        if ($job->logo && Storage::disk('public')->exists($job->logo)) {
            Storage::disk('public')->delete($job->logo);
        }

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully.');
    }

    /**
     * Ensure payload values are in a database-safe format.
     */
    private function normalizeJobPayload(array $data): array
    {
        if (!empty($data['application_deadline'])) {
            try {
                $data['application_deadline'] = Carbon::parse($data['application_deadline'])->format('Y-m-d');
            } catch (\Throwable $exception) {
                $data['application_deadline'] = null;
            }
        }

        return $data;
    }

    private function uploadImage($imageObject)
    {
        $image_name = now()->format('Ymd_His') . '.' . $imageObject->getClientOriginalExtension();
        $imageObject->storeAs('logos', $image_name, 'public');
        return "logos/{$image_name}";
    }
}
