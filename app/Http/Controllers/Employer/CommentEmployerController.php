<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CommentEmployerController extends Controller
{
    public function index(): View
    {
        $employerId = Auth::id();

        $jobIds = JobPost::query()
            ->where('employer_id', $employerId)
            ->pluck('id');

        $comments = Comment::query()
            ->where('commentable_type', JobPost::class)
            ->whereIn('commentable_id', $jobIds)
            ->with('user:id,name,email')
            ->latest('created_at')
            ->paginate(12);
        $jobTitles = $this->jobTitlesForComments($comments->getCollection());

        return view('employer.comments.index', [
            'comments' => $comments,
            'jobTitles' => $jobTitles,
        ]);
    }

    public function show(Comment $comment): View
    {
        $job = $this->guardAndResolveCommentJob($comment);

        $comment->loadMissing('user:id,name,email');

        return view('employer.comments.show', [
            'comment' => $comment,
            'job' => $job,
        ]);
    }

    public function showUser(User $user)
    {
        // Make sure it's a candidate
        if ($user->role !== 'candidate') {
            return response()->json(['message' => 'Not a candidate'], 403);
        }

        // Return only useful info
        return response()->json($user->only([
            'id',
            'name',
            'email',
            'phone',
            'linkedin_url',
            'created_at',
        ]));
    }

    public function forJob(JobPost $job): View
    {
        // Make sure the employer owns this job
        abort_unless($job->employer_id === Auth::id(), 403, 'Unauthorized');

        // Fetch only comments linked to this job
        $comments = Comment::query()
            ->where('commentable_type', JobPost::class)
            ->where('commentable_id', $job->id)
            ->with('user:id,name,email')
            ->latest('created_at')
            ->paginate(10);

        return view('employer.comments.for-job', [
            'job' => $job,
            'comments' => $comments,
        ]);
    }
    
    /**
     * Build a lookup of job titles for the provided comments.
     */
    private function jobTitlesForComments(Collection $comments): Collection
    {
        $jobIds = $comments
            ->pluck('commentable_id')
            ->filter()
            ->unique()
            ->values();

        return JobPost::query()
            ->whereIn('id', $jobIds)
            ->pluck('title', 'id');
    }

    /**
     * Make sure the employer owns the job tied to this comment.
     */
    private function guardAndResolveCommentJob(Comment $comment): JobPost
    {
        abort_unless($comment->commentable_type === JobPost::class, 404);

        $job = JobPost::query()->find($comment->commentable_id);

        abort_unless(
            $job !== null && (int) $job->employer_id === Auth::id(),
            403
        );

        return $job;
    }
}
