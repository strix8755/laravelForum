<div class="comment-{{ $comment->id }} bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 mb-4 overflow-hidden">
    <div class="p-4">
        <div class="flex justify-between items-start">
            <div class="flex items-center">
                <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                    alt="{{ $comment->user->name }}" class="h-8 w-8 rounded-full mr-2 object-cover border border-gray-200 dark:border-gray-700">
                <div>
                    <div class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                        @if($comment->created_at != $comment->updated_at)
                            <span class="text-xs italic ml-1">(edited)</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Comment Actions Dropdown -->
            @auth
                @if(Auth::id() == $comment->user_id)
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="opacity-0 scale-95" 
                         x-transition:enter-end="opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="opacity-100 scale-100" 
                         x-transition:leave-end="opacity-0 scale-95" 
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-10"
                         x-cloak>
                        <div class="py-1">
                            <button class="edit-comment block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" data-comment-id="{{ $comment->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Comment
                            </button>
                            
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="return confirm('Are you sure you want to delete this comment?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Comment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endauth
        </div>
        
        <!-- Comment content (with edit form) -->
        <div class="mt-3">
            <div class="comment-content-{{ $comment->id }} prose prose-sm dark:prose-invert max-w-none">
                {{ $comment->content }}
            </div>
            
            <form class="edit-form-{{ $comment->id }} hidden mt-2" action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="content" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:text-white text-sm">{{ $comment->content }}</textarea>
                <div class="mt-2 flex justify-end space-x-2">
                    <button type="button" class="cancel-edit px-3 py-1 text-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-3 py-1 text-sm text-white bg-primary-600 rounded-md hover:bg-primary-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Comment actions -->
        <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700 flex items-center text-xs text-gray-500 dark:text-gray-400">
            <!-- Vote section -->
            <div class="comment-vote flex items-center mr-4">
                <button class="comment-vote-btn comment-upvote mr-1" data-comment-id="{{ $comment->id }}" data-vote="1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Auth::check() && $comment->votes()->where('user_id', Auth::id())->where('vote', 1)->exists() ? 'text-primary-500' : 'text-gray-400 hover:text-primary-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
                <span class="text-sm font-bold my-1 comment-vote-score">{{ $comment->upvotes()->count() - $comment->downvotes()->count() }}</span>
                <button class="comment-vote-btn comment-downvote ml-1" data-comment-id="{{ $comment->id }}" data-vote="-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Auth::check() && $comment->votes()->where('user_id', Auth::id())->where('vote', -1)->exists() ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
            
            <!-- Reply button -->
            @auth
                <button class="text-primary-500 hover:text-primary-600 reply-toggle flex items-center" data-comment-id="{{ $comment->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    Reply
                </button>
            @endauth
        </div>
    </div>
    
    <!-- Reply form -->
    @auth
        <div class="mt-3 hidden reply-form-{{ $comment->id }}">
            <form action="{{ route('comments.store', $comment->post) }}" method="POST" class="reply-comment-form">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="mb-2">
                    <textarea name="content" rows="2" 
                        class="w-full px-3 py-2 text-sm text-gray-700 dark:text-gray-200 border rounded-lg focus:outline-none focus:border-primary-500 dark:bg-gray-800 dark:border-gray-700"
                        placeholder="Write your reply here..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white text-sm px-3 py-1 rounded-md">
                        Submit Reply
                    </button>
                </div>
            </form>
        </div>
    @endauth
    
    <!-- Replies -->
    @if($comment->replies->count() > 0)
        <div class="mt-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-4">
            @foreach($comment->replies as $reply)
                @include('forum.comments.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
