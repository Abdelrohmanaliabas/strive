<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEmployer() || $user->isCandidate();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $user->isEmployer() || $user->isCandidate();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEmployer() || $user->isCandidate();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($comment->user_id === $user->id) {
            return true;
        }
        // If comment is on a JobPost, allow employer of the post to delete
        if ($comment->commentable_type === JobPost::class) {
            $jobPost = $comment->commentable;
            return $user->isEmployer() && $jobPost->employer_id === $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
