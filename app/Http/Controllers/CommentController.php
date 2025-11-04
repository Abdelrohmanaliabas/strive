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

    // 👁️ عرض تعليق واحد
    public function show(Comment $comment)
    {
        $comment->load(['user', 'commentable']);
        return view('admin.comments.show', compact('comment'));
    }

    // ❌ حذف تعليق
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
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
    public function store(StoreCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
