<template>
    <div>
        <div v-if="loading" class="flex justify-center py-8">
            <svg class="animate-spin h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        
        <div v-else-if="post" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ post.title }}</h1>
            
            <div class="flex flex-wrap items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                <div class="flex items-center mr-4 mb-2">
                    <img :src="post.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(post.user.name) + '&color=7F9CF5&background=EBF4FF'" 
                        :alt="post.user.name" class="h-8 w-8 rounded-full mr-2 object-cover border border-gray-200 dark:border-gray-700">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ post.user.name }}</span>
                    </div>
                </div>
                
                <div class="flex items-center mr-4 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ formatDate(post.created_at) }}</span>
                </div>
                
                <div v-if="isOwnPost" class="flex space-x-2 ml-auto mb-2">
                    <a :href="'/posts/' + post.id + '/edit'" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-medium text-xs text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 active:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit
                    </a>
                    
                    <button @click="deletePost" class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-red-500 focus:outline-none focus:border-red-700 active:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
            
            <div class="prose prose-lg dark:prose-invert max-w-none mb-6">
                {{ post.content }}
            </div>
            
            <div v-if="post.image_path" class="mb-6">
                <img :src="'/storage/' + post.image_path" alt="Post image" class="rounded-lg max-h-96 mx-auto shadow-md hover:shadow-lg transition-shadow">
            </div>
            
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Comments</h2>
                
                <div v-if="isAuthenticated" class="mb-6">
                    <textarea v-model="newComment" rows="3" class="w-full px-3 py-2 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-800 dark:focus:ring-primary-500" placeholder="Add a comment..."></textarea>
                    
                    <div class="flex justify-end mt-2">
                        <button @click="submitComment" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                            Submit Comment
                        </button>
                    </div>
                </div>
                
                <div v-else class="mb-6 text-center">
                    <p class="mb-3">You need to be logged in to comment</p>
                    <div class="flex justify-center space-x-4">
                        <a href="/login" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Log In</a>
                        <a href="/register" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">Register</a>
                    </div>
                </div>
                
                <div v-if="post.comments.length === 0" class="text-center py-6 bg-gray-50 dark:bg-gray-800/60 rounded-lg">
                    <p class="text-gray-600 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                </div>
                
                <div v-else class="space-y-4">
                    <div v-for="comment in post.comments" :key="comment.id" class="bg-gray-50 dark:bg-gray-800/60 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <img :src="comment.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(comment.user.name) + '&color=7F9CF5&background=EBF4FF'" 
                                    :alt="comment.user.name" class="h-8 w-8 rounded-full mr-2 object-cover border border-gray-200 dark:border-gray-700">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ comment.user.name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ formatDate(comment.created_at) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-gray-700 dark:text-gray-300">
                            {{ comment.content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-else class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-gray-600 dark:text-gray-400">Post not found.</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        postId: {
            type: Number,
            required: true
        },
        isAuthenticated: {
            type: Boolean,
            required: true
        },
        currentUserId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            post: null,
            loading: true,
            newComment: ''
        }
    },
    computed: {
        isOwnPost() {
            return this.post && this.currentUserId && this.post.user.id === this.currentUserId;
        }
    },
    mounted() {
        this.fetchPost();
    },
    methods: {
        fetchPost() {
            this.loading = true;
            axios.get(`/api/posts/${this.postId}`)
                .then(response => {
                    this.post = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error fetching post:', error);
                    this.loading = false;
                });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' at ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },
        submitComment() {
            if (!this.newComment.trim()) return;
            
            axios.post(`/api/posts/${this.postId}/comments`, {
                content: this.newComment
            })
                .then(response => {
                    // Add the new comment to the post
                    this.post.comments.unshift(response.data);
                    this.newComment = '';
                })
                .catch(error => {
                    console.error('Error submitting comment:', error);
                });
        },
        deletePost() {
            if (!confirm('Are you sure you want to delete this post?')) return;
            
            axios.delete(`/api/posts/${this.postId}`)
                .then(() => {
                    window.location.href = '/forum';
                })
                .catch(error => {
                    console.error('Error deleting post:', error);
                });
        }
    }
}
</script>
