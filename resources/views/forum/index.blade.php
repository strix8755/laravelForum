@extends('layouts.app')

@section('title', 'Forum - ' . config('app.name'))

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Forum Discussions</h1>
            @auth
                <a href="{{ route('posts.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Post
                </a>
            @else
                <a href="{{ url('login') }}"
                   class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                    Login to create posts
                </a>
            @endauth
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-4">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" 
                                    src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                    alt="{{ $post->user->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $post->user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Posted {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('posts.show', $post) }}" class="block hover:text-primary-600 dark:hover:text-primary-400">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h2>
                        </a>
                        
                        <div class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 200) }}
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                {{ $post->upvotes_count ?? 0 }} upvotes
                            </div>
                            <div class="flex items-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                                {{ $post->comments_count ?? 0 }} comments
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="ml-auto text-primary-600 dark:text-primary-400 hover:underline">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        <p class="mb-4">No posts found.</p>
                        @auth
                            <p>Be the first to create a post!</p>
                        @else
                            <p>Login to create the first post!</p>
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
