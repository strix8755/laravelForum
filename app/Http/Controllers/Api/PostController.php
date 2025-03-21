<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Get a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with('user')
            ->withCount(['upvotes', 'downvotes', 'allComments as comments_count'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return response()->json($posts);
    }

    /**
     * Get the specified post.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return response()->json($post);
    }

    /**
     * Store a comment for the post.
     */
    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        $post->comments()->save($comment);
        
        // Load the user relation
        $comment->load('user');
        
        return response()->json($comment);
    }

    /**
     * Vote on a post.
     */
    public function vote(Request $request, Post $post)
    {
        $request->validate([
            'vote' => 'required|integer|in:-1,1',
        ]);
        
        $vote = $post->votes()->where('user_id', Auth::id())->first();
        
        if ($vote) {
            // If user has already voted and is voting the same way, remove the vote
            if ($vote->vote == $request->vote) {
                $vote->delete();
                return response()->json([
                    'success' => true, 
                    'message' => 'Vote removed', 
                    'score' => $post->fresh()->getScoreAttribute()
                ]);
            }
            
            // Otherwise change the vote
            $vote->vote = $request->vote;
            $vote->save();
        } else {
            // Create new vote
            $post->votes()->create([
                'user_id' => Auth::id(),
                'vote' => $request->vote
            ]);
        }
        
        return response()->json([
            'success' => true, 
            'score' => $post->fresh()->getScoreAttribute()
        ]);
    }
}
