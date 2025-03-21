<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $request->parent_id
        ]);

        $comment->save();

        // Increment comment count on post
        $post->increment('comment_count');

        if ($request->ajax()) {
            $comment->load('user');
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'username' => $comment->user->name,
                'created_at' => $comment->created_at->diffForHumans()
            ]);
        }

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $request->validate([
            'content' => 'required',
        ]);

        $comment->content = $request->content;
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment
            ]);
        }

        return redirect()->route('posts.show', $comment->post)->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $post = $comment->post;
        
        // Decrement comment count on post
        $post->decrement('comment_count');
        
        $comment->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Comment deleted successfully!');
    }
    
    public function vote(Request $request, Comment $comment)
    {
        $request->validate([
            'vote' => 'required|integer|in:-1,1',
        ]);
        
        $vote = $comment->votes()->where('user_id', Auth::id())->first();
        
        if ($vote) {
            // If user has already voted and is voting the same way, remove the vote
            if ($vote->vote == $request->vote) {
                $vote->delete();
                return response()->json(['success' => true, 'message' => 'Vote removed', 'score' => $comment->fresh()->getScoreAttribute()]);
            }
            
            // Otherwise change the vote
            $vote->vote = $request->vote;
            $vote->save();
        } else {
            // Create new vote
            $comment->votes()->create([
                'user_id' => Auth::id(),
                'vote' => $request->vote
            ]);
        }
        
        return response()->json(['success' => true, 'score' => $comment->fresh()->getScoreAttribute()]);
    }
}
