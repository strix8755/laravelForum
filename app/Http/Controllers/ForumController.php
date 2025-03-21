<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    /**
     * Display the forum index page with all posts.
     */
    public function index(): View
    {
        $posts = Post::with('user')
            ->withCount(['comments', 'upvotes', 'downvotes'])
            ->latest()
            ->paginate(10);

        return view('forum.index', compact('posts'));
    }
}
