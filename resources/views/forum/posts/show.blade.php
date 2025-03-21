@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-5 flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('forum.index') }}" class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Forum
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-500 dark:text-gray-400 ml-1 md:ml-2 text-sm font-medium">{{ Str::limit($post->title, 40) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Post Card -->
            <x-card class="mb-8">
                <div class="flex">
                    <!-- Vote column -->
                    <div class="w-16 flex-shrink-0 flex flex-col items-center pr-4 border-r border-gray-100 dark:border-gray-700">
                        <button class="vote-btn upvote transition hover:scale-110" data-post-id="{{ $post->id }}" data-vote="1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 {{ Auth::check() && $userVote && $userVote->vote == 1 ? 'text-primary-500' : 'text-gray-400 hover:text-primary-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>
                        
                        <span class="text-2xl font-bold my-2 vote-score {{ ($post->upvotes()->count() - $post->downvotes()->count()) > 0 ? 'text-primary-600 dark:text-primary-400' : (($post->upvotes()->count() - $post->downvotes()->count()) < 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300') }}">
                            {{ $post->upvotes()->count() - $post->downvotes()->count() }}
                        </span>
                        
                        <button class="vote-btn downvote transition hover:scale-110" data-post-id="{{ $post->id }}" data-vote="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 {{ Auth::check() && $userVote && $userVote->vote == -1 ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Post content -->
                    <div class="flex-1 pl-4">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>
                        
                        <div class="flex flex-wrap items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                            <div class="flex items-center mr-4 mb-2">
                                <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                    alt="{{ $post->user->name }}" class="h-8 w-8 rounded-full mr-2 object-cover border border-gray-200 dark:border-gray-700">
                                <div>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $post->user->name }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center mr-4 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $post->created_at->format('M j, Y') }} at {{ $post->created_at->format('g:i A') }}</span>
                                <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @can('update', $post)
                            <div class="flex space-x-2 ml-auto mb-2">
                                <x-button :href="route('posts.edit', $post)" as="a" type="light" size="sm" class="flex items-center">
                                    <x-slot:iconLeft>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </x-slot:iconLeft>
                                    Edit
                                </x-button>
                                
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="danger" size="sm" class="flex items-center">
                                        <x-slot:iconLeft>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </x-slot:iconLeft>
                                        Delete
                                    </x-button>
                                </form>
                            </div>
                            @endcan
                        </div>
                        
                        <div class="prose prose-lg dark:prose-invert max-w-none mb-6">
                            {{ $post->content }}
                        </div>
                        
                        @if($post->image_path)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-lg max-h-96 mx-auto shadow-md hover:shadow-lg transition-shadow">
                        </div>
                        @endif
                        
                        <div class="flex items-center pt-4 mt-4 border-t border-gray-100 dark:border-gray-700 text-sm">
                            <div class="flex items-center mr-6 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>{{ $post->allComments->count() }} {{ Str::plural('comment', $post->allComments->count()) }}</span>
                            </div>
                            
                            <button class="share-btn flex items-center text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors" data-post-url="{{ route('posts.show', $post) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Comment Form -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    Leave a Comment
                </h2>
                
                @auth
                    <x-card>
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" rows="3" 
                                    class="w-full px-3 py-2 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:focus:ring-primary-500"
                                    placeholder="Share your thoughts..."></textarea>
                            </div>
                            <div class="flex justify-end">
                                <x-button type="primary">
                                    Submit Comment
                                </x-button>
                            </div>
                        </form>
                    </x-card>
                @else
                    <x-card>
                        <div class="text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You need to be logged in to comment.</p>
                            <div class="flex justify-center space-x-3">
                                <x-button :href="route('login')" as="a" type="primary">
                                    Log In
                                </x-button>
                                <x-button :href="route('register')" as="a" type="outline-primary">
                                    Register
                                </x-button>
                            </div>
                        </div>
                    </x-card>
                @endauth
            </div>

            <!-- Comments -->
            <div class="comments-section">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                    Comments ({{ $post->allComments->count() }})
                </h2>
                
                @if($post->comments->count() > 0)
                    <div class="space-y-4" id="comments-container">
                        @foreach($post->comments as $comment)
                            @include('forum.comments.comment', ['comment' => $comment])
                        @endforeach
                    </div>
                @else
                    <x-card class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-2">No comments yet.</p>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Be the first to share your thoughts!</p>
                    </x-card>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle voting for posts
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
                            upvoteBtn.querySelector('svg').classList.toggle('text-primary-500');
                            downvoteBtn.querySelector('svg').classList.remove('text-red-500');
                        } else {
                            downvoteBtn.querySelector('svg').classList.toggle('text-red-500');
                            upvoteBtn.querySelector('svg').classList.remove('text-primary-500');
                        }
                    }
                });
            });
        });
        
        // Handle comment voting
        document.addEventListener('click', function(e) {
            if (e.target.closest('.comment-vote-btn')) {
                e.preventDefault();
                
                @guest
                    window.location.href = "{{ route('login') }}";
                    return;
                @endguest
                
                const button = e.target.closest('.comment-vote-btn');
                const commentId = button.dataset.commentId;
                const vote = button.dataset.vote;
                const scoreElement = button.closest('.comment-vote').querySelector('.comment-vote-score');
                
                fetch(`/comments/${commentId}/vote`, {
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
                        const upvoteBtn = button.closest('.comment-vote').querySelector('.comment-upvote');
                        const downvoteBtn = button.closest('.comment-vote').querySelector('.comment-downvote');
                        
                        if (vote == 1) {
                            upvoteBtn.querySelector('svg').classList.toggle('text-primary-500');
                            downvoteBtn.querySelector('svg').classList.remove('text-red-500');
                        } else {
                            downvoteBtn.querySelector('svg').classList.toggle('text-red-500');
                            upvoteBtn.querySelector('svg').classList.remove('text-primary-500');
                        }
                    }
                });
            }
        });
        
        // Handle reply form toggling
        document.addEventListener('click', function(e) {
            if (e.target.closest('.reply-toggle')) {
                e.preventDefault();
                const commentId = e.target.closest('.reply-toggle').dataset.commentId;
                const replyForm = document.querySelector(`.reply-form-${commentId}`);
                replyForm.classList.toggle('hidden');
            }
        });
        
        // Handle sharing
        document.querySelector('.share-btn').addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.dataset.postUrl;
            
            if (navigator.share) {
                navigator.share({
                    title: '{{ $post->title }}',
                    url: url
                })
                .catch(console.error);
            } else {
                // Fallback
                navigator.clipboard.writeText(url).then(() => {
                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 bg-gray-900 dark:bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
                    toast.textContent = 'Link copied to clipboard!';
                    document.body.appendChild(toast);
                    
                    // Remove after 3 seconds
                    setTimeout(() => {
                        toast.classList.add('animate-fade-out');
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 300);
                    }, 300);
                });
            }
        });
        
        // Handle AJAX comment submission
        document.querySelector('.comment-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Create new comment HTML
                    const commentsContainer = document.getElementById('comments-container');
                    const commentTemplate = createCommentElement(data);
                    
                    // If there are no comments, change the empty state
                    if (!commentsContainer.children.length || commentsContainer.querySelector('.text-center')) {
                        commentsContainer.innerHTML = '';
                    }
                    
                    // Add the new comment to the top
                    commentsContainer.insertAdjacentHTML('afterbegin', commentTemplate);
                    
                    // Clear the form
                    form.reset();
                    
                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
                    toast.textContent = 'Comment posted successfully!';
                    document.body.appendChild(toast);
                    
                    // Remove after 3 seconds
                    setTimeout(() => {
                        toast.classList.add('animate-fade-out');
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 300);
                    }, 3000);
                }
            });
        });
        
        // Helper function to create comment HTML
        function createCommentElement(data) {
            return `
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-4 border border-gray-100 dark:border-gray-700 animate-slide-up">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.username)}&color=7F9CF5&background=EBF4FF" alt="${data.username}" class="h-8 w-8 rounded-full mr-2 object-cover border border-gray-200 dark:border-gray-700">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">${data.username}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">${data.created_at}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-gray-700 dark:text-gray-300">
                        ${data.comment.content}
                    </div>
                </div>
            `;
        }
    });
</script>
@endpush
@endsection
