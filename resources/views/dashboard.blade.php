<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ __('Dashboard') }}" description="Welcome back to your personal dashboard" />
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <x-card class="bg-gradient-to-br from-primary-600 to-primary-800 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white/20 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold mb-1">Forum Activity</div>
                            <div class="text-2xl font-bold">{{ App\Models\Post::count() }} Posts</div>
                            <div class="text-white/70 mt-1">{{ App\Models\Comment::count() }} Comments</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('forum.index') }}" class="inline-flex items-center text-sm bg-white/20 hover:bg-white/30 px-3 py-1 rounded-full transition-colors">
                            Visit Forum
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-primary-100 dark:bg-primary-900/30 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">Your Profile</div>
                            <div class="text-gray-600 dark:text-gray-300">{{ Auth::user()->name }}</div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm">Member since {{ Auth::user()->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                            Edit Profile
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-primary-100 dark:bg-primary-900/30 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">Create New Content</div>
                            <div class="text-gray-600 dark:text-gray-300">Start a discussion or share knowledge</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                            Create Post
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </x-card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <x-card>
                        <x-slot:header>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Your Recent Posts</h3>
                        </x-slot:header>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse(Auth::user()->posts()->latest()->take(5)->get() as $post)
                                <div class="py-4 {{ !$loop->first ? 'pt-4' : '' }} {{ !$loop->last ? 'pb-4' : '' }}">
                                    <a href="{{ route('posts.show', $post) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-800/60 -mx-6 px-6 py-2 rounded-lg">
                                        <h4 class="text-lg font-medium text-primary-700 dark:text-primary-400 mb-1">{{ $post->title }}</h4>
                                        <p class="text-gray-600 dark:text-gray-300 line-clamp-2 mb-2">{{ Str::limit($post->content, 100) }}</p>
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            <span class="mx-2">•</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="py-4 text-gray-600 dark:text-gray-300">You have not created any posts yet.</div>
                            @endforelse
                        </div>
                    </x-card>
                </div>

                <div>
                    <x-card>
                        <x-slot:header>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Comments</h3>
                        </x-slot:header>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse(Auth::user()->comments()->latest()->take(5)->get() as $comment)
                                <div class="py-4 {{ !$loop->first ? 'pt-4' : '' }} {{ !$loop->last ? 'pb-4' : '' }}">
                                    <a href="{{ route('posts.show', $comment->post) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-800/60 -mx-6 px-6 py-2 rounded-lg">
                                        <p class="text-gray-600 dark:text-gray-300 line-clamp-2 mb-2">{{ Str::limit($comment->content, 100) }}</p>
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                            <span class="mx-2">•</span>
                                            <span>On: {{ Str::limit($comment->post->title, 30) }}</span>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="py-4 text-gray-600 dark:text-gray-300">You have not posted any comments yet.</div>
                            @endforelse
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
