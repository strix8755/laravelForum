import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

// Import Alpine.js
import Alpine from 'alpinejs';

// Create Vue app
const app = createApp({});
const pinia = createPinia();

// Register Vue components
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import PostList from './components/PostList.vue';
app.component('post-list', PostList);

import PostShow from './components/PostShow.vue';
app.component('post-show', PostShow);

// Mount Vue app
app.use(pinia);
app.mount('#app');

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Dark mode toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    // Check for saved theme preference or use OS preference
    if (localStorage.getItem('color-theme') === 'dark' || 
        (!('color-theme' in localStorage) && 
         window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Set initial icon state based on current theme
    if (themeToggleBtn && themeToggleDarkIcon && themeToggleLightIcon) {
        if (document.documentElement.classList.contains('dark')) {
            themeToggleDarkIcon.classList.add('hidden');
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }

        // Toggle theme on button click
        themeToggleBtn.addEventListener('click', function() {
            // Toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');
            
            // Toggle theme
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    }
});
