<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // We'll handle auth middleware in the routes instead
    }

    public function index()
    {
        $posts = Post::with('user')
            ->withCount(['upvotes', 'downvotes', 'allComments as comments_count'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('forum.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        return view('forum.posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id();
        
        if ($request->hasFile('image')) {
            $post->image_path = $request->file('image')->store('post-images', 'public');
        }
        
        $post->save();
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'comments.replies.user']);
        
        // Get the user's vote on this post if authenticated
        $userVote = null;
        if (Auth::check()) {
            $userVote = Vote::where('user_id', Auth::id())
                ->where('votable_type', Post::class)
                ->where('votable_id', $post->id)
                ->first();
        }
        
        return view('forum.posts.show', compact('post', 'userVote'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        
        return view('forum.posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $post->title = $request->title;
        $post->content = $request->content;
        
        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }
            
            $post->image_path = $request->file('image')->store('post-images', 'public');
        } elseif ($request->has('remove_image') && $request->remove_image) {
            // Remove image if requested
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->image_path = null;
        }
        
        $post->save();
        
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        // Delete the post image if it exists
        if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
            Storage::disk('public')->delete($post->image_path);
        }
        
        $post->delete();
        
        return redirect()->route('forum.index')
            ->with('success', 'Post deleted successfully!');
    }
    
    /**
     * Handle post voting
     */
    public function vote(Request $request, Post $post)
    {
        $request->validate([
            'vote' => 'required|integer|in:-1,1',
        ]);
        
        $vote = Vote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_id' => $post->id,
                'votable_type' => Post::class,
            ],
            ['vote' => $request->vote]
        );
        
        // If the new vote is the same as the old one, remove it (toggle behavior)
        if ($vote->wasRecentlyCreated === false && $vote->wasChanged() === false) {
            $vote->delete();
        }
        
        // Return updated score
        $score = $post->upvotes()->count() - $post->downvotes()->count();
        
        return response()->json([
            'success' => true,
            'score' => $score
        ]);
    }
}
