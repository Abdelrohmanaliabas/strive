<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:candidate'])->only(['store']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'content' => 'required|string|max:2000',
        ]);

        $jobPost = JobPost::findOrFail($validated['job_post_id']);

        Comment::create([
            'user_id' => Auth::id() ?? null, // allow guests if desired
            'commentable_id' => $jobPost->id,
            'commentable_type' => JobPost::class,
            'content' => $validated['content'],
        ]);

        return redirect()->route('jobs.show', $jobPost->id)
                         ->with('success', 'Your comment was added successfully!');
    }
}
