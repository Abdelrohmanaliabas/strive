<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with(['user', 'commentable'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }
    public function show(Comment $comment)
    {
        $comment->load(['user', 'commentable']);
        return view('admin.comments.show', compact('comment'));
    }
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
    public function create() {}

    public function store(StoreCommentRequest $request) {}

    public function edit(Comment $comment)
    {
        //
    }

    public function update(UpdateCommentRequest $request, Comment $comment) {}
}
