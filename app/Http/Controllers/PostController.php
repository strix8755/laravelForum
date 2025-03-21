<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // We'll use the route middleware approach instead of controller middleware
    }

    public function index()
    {
        $posts = Post::with('user')
            ->withCount(['upvotes', 'downvotes', 'allComments as comments_count'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('forum.index', compact('posts'));
    }

    public function create()
    {
        return view('forum.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
            $post->image_path = $imagePath;
        }

        $post->save();

        return redirect()->route('posts.show', $post)->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'comments.replies.user']);
        
        // Get current user vote if logged in
        $userVote = null;
        if (Auth::check()) {
            $userVote = $post->votes()->where('user_id', Auth::id())->first();
        }
        
        return view('forum.posts.show', compact('post', 'userVote'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        
        return view('forum.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            
            $imagePath = $request->file('image')->store('post-images', 'public');
            $post->image_path = $imagePath;
        }

        $post->save();

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        // Delete the image if it exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
    
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
                return response()->json(['success' => true, 'message' => 'Vote removed', 'score' => $post->fresh()->getScoreAttribute()]);
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
        
        return response()->json(['success' => true, 'score' => $post->fresh()->getScoreAttribute()]);
    }
}
