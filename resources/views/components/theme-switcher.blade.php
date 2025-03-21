<button 
    x-data="{
        theme: localStorage.getItem('theme') || 'system',
        
        init() {
            this.$watch('theme', (value) => {
                localStorage.setItem('theme', value)
                this.updateTheme()
            })
            
            this.updateTheme()
            
            // Watch for system preference changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (this.theme === 'system') {
                    this.updateTheme()
                }
            })
        },
        
        updateTheme() {
            const isDark = this.theme === 'dark' || 
                (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)
            
            document.documentElement.classList.toggle('dark', isDark)
        }
    }"
    @click="theme = theme === 'light' ? 'dark' : theme === 'dark' ? 'system' : 'light'"
    x-tooltip="theme === 'light' ? 'Light Mode' : theme === 'dark' ? 'Dark Mode' : 'System Theme'"
    class="flex items-center justify-center w-10 h-10 rounded-full focus:outline-none transition duration-150 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-800"
>
    <svg 
        x-show="theme === 'light'" 
        class="w-5 h-5 text-gray-600"
        xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>

    <svg 
        x-show="theme === 'dark'" 
        class="w-5 h-5 text-gray-300"
        xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>

    <svg 
        x-show="theme === 'system'" 
        class="w-5 h-5 text-gray-400"
        xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
    </svg>
</button>
