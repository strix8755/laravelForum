@extends('layouts.app')

@section('title', 'Create New Post')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-4 flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('forum.index') }}" class="text-gray-500 hover:text-primary-700 dark:text-gray-400 dark:hover:text-primary-400 inline-flex items-center">
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
                            <span class="text-gray-500 dark:text-gray-400 ml-1 md:ml-2 text-sm font-medium">Create Post</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Create Post Card -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-primary-100 dark:bg-primary-900/30 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Create New Post</h2>
                    </div>
                </x-slot:header>

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                            :value="old('title')" placeholder="Enter a descriptive title" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea id="content" name="content" rows="6" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 shadow-sm"
                            placeholder="Write your post content here..." required>{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-input-label for="image" :value="__('Image (Optional)')" />
                        <div class="mt-1 flex items-center">
                            <span class="inline-block h-12 w-12 overflow-hidden rounded-md bg-gray-100 dark:bg-gray-800">
                                <img id="image-preview" class="h-full w-full object-cover hidden">
                                <svg id="image-placeholder" class="h-full w-full text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <label for="image" class="ml-5 relative cursor-pointer rounded-md bg-white dark:bg-gray-800 font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Upload an image</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewImage()">
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <x-button type="light" :href="route('forum.index')" as="a">
                            Cancel
                        </x-button>
                        <x-button type="primary">
                            Create Post
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
                imagePlaceholder.classList.add('hidden');
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
@endpush
@endsection
