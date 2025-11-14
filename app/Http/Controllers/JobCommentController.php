<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\CommentAddedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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

        $comment = Comment::create([
            'user_id' => Auth::id() ?? null, // allow guests if desired
            'commentable_id' => $jobPost->id,
            'commentable_type' => JobPost::class,
            'content' => $validated['content'],
        ]);

        // Load relationships for notification
        $comment->load('user', 'commentable');

        // Notify only the employer (employee) who owns the job post
        // Comments should NOT appear in admin notifications
        $jobPost->load('employer');
        
        // Notify only the employer who owns this job post
        if ($jobPost->employer) {
            $jobPost->employer->notify(new CommentAddedNotification($comment));
        }

        return redirect()->route('jobs.show', $jobPost->id)
                         ->with('success', 'Your comment was added successfully!');
    }
}
