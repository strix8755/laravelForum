@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
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
                            <a href="{{ route('posts.show', $post) }}" class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 ml-1 md:ml-2 text-sm font-medium">
                                {{ Str::limit($post->title, 30) }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-500 dark:text-gray-400 ml-1 md:ml-2 text-sm font-medium">Edit Post</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Edit Post Card -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Edit Post</h2>
                    </div>
                </x-slot:header>

                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" 
                            class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('title') border-red-500 @enderror" 
                            placeholder="Enter a descriptive title" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Content</label>
                        <textarea name="content" id="content" rows="6" 
                            class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white @error('content') border-red-500 @enderror" 
                            placeholder="Write your post content here..." required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image (Optional)</label>
                        <div class="mt-1 flex items-center">
                            <span class="inline-block h-12 w-12 overflow-hidden rounded-md bg-gray-100 dark:bg-gray-800">
                                @if($post->image_path)
                                    <img id="image-preview" src="{{ asset('storage/'.$post->image_path) }}" class="h-full w-full object-cover">
                                @else
                                    <img id="image-preview" class="h-full w-full object-cover hidden">
                                    <svg id="image-placeholder" class="h-full w-full text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </span>
                            <label for="image" class="ml-5 relative cursor-pointer rounded-md bg-white dark:bg-gray-800 font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>{{ $post->image_path ? 'Change image' : 'Upload an image' }}</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewImage()">
                            </label>
                            @if($post->image_path)
                                <div class="ml-3 flex items-center">
                                    <input type="checkbox" id="remove_image" name="remove_image" class="rounded border-gray-300 dark:border-gray-600 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800">
                                    <label for="remove_image" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remove image</label>
                                </div>
                            @endif
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <x-button type="light" :href="route('posts.show', $post)" as="a">
                            Cancel
                        </x-button>
                        <x-button type="primary">
                            Update Post
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage() {
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');
        
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                if (imagePlaceholder) {
                    imagePlaceholder.classList.add('hidden');
                }
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
@endpush
@endsection
