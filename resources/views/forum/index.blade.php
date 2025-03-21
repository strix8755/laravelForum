@extends('layouts.app')

@section('title', 'Community Forum')

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section with Improved Design -->
        <div class="relative overflow-hidden bg-gradient-to-r from-primary-700 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-2xl shadow-xl mb-8">
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                    <path d="M435.2,373.5c38.9,37.3,55.2,91.1,35.3,124c-20,32.9-76.2,44.9-131.1,55.9C284.4,564.4,230.8,574.4,180,550.9c-50.7-23.5-98.4-80.7-95.3-135.9c3.1-55.1,57.2-108.3,111.1-128.7c53.9-20.4,107.6-8.1,157.4,11.7C402.9,321.6,396.4,336.2,435.2,373.5z" fill="currentColor" />
                </svg>
            </div>
            
            <!-- Removed the nested div with class "relative px-8 py-12 md:py-16 md:px-12..." -->
            <div class="px-8 py-12 md:py-16 md:px-12">
                <div class="md:w-2/3 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">Welcome to our Community Forum</h1>
                    <p class="text-lg text-white/80 mb-8 max-w-2xl">Join the conversation, share your knowledge, and connect with other community members. Our forum is a place for meaningful discussions and learning.</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-white/20 hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Start a New Discussion
                        </a>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-white/20 hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                                Log In to Join
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-primary-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                </svg>
                                Create Account
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Filters and Search with Enhanced Design -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-smooth mb-8">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Discussions</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Browse and filter community discussions</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <!-- Search bar -->
                        <form action="{{ route('posts.index') }}" method="GET" class="relative flex-1">
                            <input type="search" name="search" placeholder="Search discussions..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" value="{{ request('search') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </form>
                        
                        @auth
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-700 hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            New Post
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 rounded-b-xl">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('posts.index', ['sort' => 'latest']) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 
                       {{ request('sort') == 'latest' || !request('sort') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Latest
                    </a>
                    <a href="{{ route('posts.index', ['sort' => 'popular']) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 
                       {{ request('sort') == 'popular' ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Popular
                    </a>
                    <a href="{{ route('posts.index', ['sort' => 'discussed']) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 
                       {{ request('sort') == 'discussed' ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Most Discussed
                    </a>
                    <a href="{{ route('posts.index', ['sort' => 'unanswered']) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 
                       {{ request('sort') == 'unanswered' ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Unanswered
                    </a>
                </div>
            </div>
        </div>

        <!-- Post List with Enhanced Design -->
        <div class="space-y-4 mb-8">
            @forelse ($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-smooth border border-gray-100 dark:border-gray-700 hover:shadow-card transition-shadow duration-300 overflow-hidden">
                    <div class="flex">
                        <!-- Vote column with improved styling -->
                        <div class="w-24 flex-shrink-0 bg-primary-50 dark:bg-primary-900/30 flex flex-col items-center py-6">
                            <button class="vote-btn upvote transition-transform hover:scale-110" data-post-id="{{ $post->id }}" data-vote="1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ Auth::check() && $post->votes()->where('user_id', Auth::id())->where('vote', 1)->exists() ? 'text-primary-500' : 'text-gray-400 hover:text-primary-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                            
                            <span class="text-xl font-bold my-2 vote-score {{ ($post->upvotes_count - $post->downvotes_count) > 0 ? 'text-primary-600 dark:text-primary-400' : (($post->upvotes_count - $post->downvotes_count) < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300') }}">
                                {{ $post->upvotes_count - $post->downvotes_count }}
                            </span>
                            
                            <button class="vote-btn downvote transition-transform hover:scale-110" data-post-id="{{ $post->id }}" data-vote="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ Auth::check() && $post->votes()->where('user_id', Auth::id())->where('vote', -1)->exists() ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Post content -->
                        <div class="flex-1 p-5">
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                <span class="flex items-center">
                                    <img class="h-5 w-5 rounded-full mr-1" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                                    <span>{{ $post->user->name }}</span>
                                </span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                
                                @if($post->comments_count > 0)
                                <span class="mx-2">•
                                @endif
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="block">
                                <h2 class="text-2xl font-bold text-primary-700 dark:text-primary-400 mb-3 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">{{ $post->title }}</h2>
                                
                                <div class="prose dark:prose-invert max-w-none mb-4 text-gray-700 dark:text-gray-300">
                                    {{ Str::limit($post->content, 180) }}
                                </div>
                                
                                @if($post->image_path)
                                    <div class="mb-4 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="w-full max-h-72 object-cover transform hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endif
                                
                                <div class="flex items-center mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center mr-6 text-gray-600 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="font-medium">{{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}</span>
                                    </div>
                                    
                                    <button class="share-btn flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" data-post-url="{{ route('posts.show', $post) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        <span class="font-medium">Share</span>
                                    </button>

                                    <a href="{{ route('posts.show', $post) }}" class="ml-auto inline-flex items-center px-4 py-2 bg-primary-100 text-primary-700 hover:bg-primary-200 dark:bg-primary-900 dark:text-primary-300 dark:hover:bg-primary-800 rounded-full text-sm font-medium transition-colors">
                                        Read More
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-10 text-center border-2 border-dashed border-gray-300 dark:border-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <p class="text-2xl text-gray-600 dark:text-gray-300 mb-4">No posts yet.</p>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Be the first to start a conversation!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-5 py-3 bg-primary-700 text-white font-medium rounded-lg hover:bg-primary-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create a Post
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-3 bg-primary-700 text-white font-medium rounded-lg hover:bg-primary-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login to Create a Post
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination with improved styling -->
        <div class="mt-10">
            <div class="bg-white dark:bg-gray-800 px-4 py-3 rounded-xl shadow">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle voting
        document.querySelectorAll('.vote-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                @guest
                    window.location.href = "{{ route('login') }}";
                    return;
                @endguest
                
                const postId = this.dataset.postId;
                const vote = this.dataset.vote;
                const scoreElement = this.parentElement.querySelector('.vote-score');
                
                fetch(`/posts/${postId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ vote: vote })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        scoreElement.textContent = data.score;
                        
                        // Update UI to show selected vote
                        const upvoteBtn = this.parentElement.querySelector('.upvote');
                        const downvoteBtn = this.parentElement.querySelector('.downvote');
                        
                        if (vote == 1) {
                            upvoteBtn.querySelector('svg').classList.toggle('text-blue-500');
                            downvoteBtn.querySelector('svg').classList.remove('text-red-500');
                        } else {
                            downvoteBtn.querySelector('svg').classList.toggle('text-red-500');
                            upvoteBtn.querySelector('svg').classList.remove('text-blue-500');
                        }
                    }
                });
            });
        });
        
        // Handle share
        document.querySelectorAll('.share-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.dataset.postUrl;
                
                if (navigator.share) {
                    navigator.share({
                        title: 'Check out this post',
                        url: url
                    })
                    .catch(console.error);
                } else {
                    // Fallback
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
