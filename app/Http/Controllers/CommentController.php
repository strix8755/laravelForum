<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // We'll handle auth middleware in the routes instead
    }
    
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        
        if ($request->has('parent_id')) {
            $comment->parent_id = $request->parent_id;
        }
        
        $comment->save();
        
        // If the request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'username' => Auth::user()->name,
                'created_at' => $comment->created_at->diffForHumans()
            ]);
        }
        
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
    
    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $request->validate([
            'content' => 'required|string'
        ]);
        
        $comment->content = $request->content;
        $comment->save();
        
        return redirect()->back()->with('success', 'Comment updated successfully!');
    }
    
    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
    
    /**
     * Handle comment voting.
     */
    public function vote(Request $request, Comment $comment)
    {
        $request->validate([
            'vote' => 'required|integer|in:-1,1',
        ]);
        
        $vote = Vote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_id' => $comment->id,
                'votable_type' => Comment::class,
            ],
            ['vote' => $request->vote]
        );
        
        // If the new vote is the same as the old one, remove it (toggle behavior)
        if ($vote->wasRecentlyCreated === false && $vote->wasChanged() === false) {
            $vote->delete();
        }
        
        // Return updated score
        $score = $comment->upvotes()->count() - $comment->downvotes()->count();
        
        return response()->json([
            'success' => true,
            'score' => $score
        ]);
    }
}
