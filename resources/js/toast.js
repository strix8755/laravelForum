/**
 * Toast notification system
 * Displays messages at the bottom right of the screen that auto-dismiss
 */
window.Toast = {
    /**
     * Show a toast notification
     * 
     * @param {string} message - The message to display
     * @param {string} type - The type of notification (success, error, info, warning)
     * @param {number} duration - How long to display the toast in milliseconds
     */
    show(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        
        // Set the base classes
        toast.className = 'fixed bottom-5 right-5 px-4 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 flex items-center';
        
        // Add type-specific classes
        switch (type) {
            case 'success':
                toast.classList.add('bg-green-600', 'text-white');
                break;
            case 'error':
                toast.classList.add('bg-red-600', 'text-white');
                break;
            case 'info':
                toast.classList.add('bg-blue-600', 'text-white');
                break;
            case 'warning':
                toast.classList.add('bg-amber-600', 'text-white');
                break;
            default:
                toast.classList.add('bg-gray-800', 'text-white');
        }
        
        // Create the icon for the toast
        const iconContainer = document.createElement('div');
        iconContainer.className = 'mr-3 flex-shrink-0';
        
        let iconSvg = '';
        switch (type) {
            case 'success':
                iconSvg = `<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>`;
                break;
            case 'error':
                iconSvg = `<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>`;
                break;
            case 'info':
                iconSvg = `<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>`;
                break;
            case 'warning':
                iconSvg = `<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>`;
                break;
        }
        
        iconContainer.innerHTML = iconSvg;
        toast.appendChild(iconContainer);
        
        // Add the message text
        const messageEl = document.createElement('div');
        messageEl.className = 'flex-1 font-medium';
        messageEl.textContent = message;
        toast.appendChild(messageEl);
        
        // Add a close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'ml-4 text-white focus:outline-none hover:text-white/80';
        closeBtn.innerHTML = `<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>`;
        closeBtn.addEventListener('click', () => {
            dismissToast(toast);
        });
        toast.appendChild(closeBtn);
        
        // Add to the DOM
        document.body.appendChild(toast);
        
        // Wait a tiny bit to ensure transition works
        setTimeout(() => {
            toast.classList.add('translate-y-0', 'opacity-100');
            toast.classList.remove('translate-y-12', 'opacity-0');
        }, 10);
        
        // Auto-dismiss after set duration
        setTimeout(() => {
            dismissToast(toast);
        }, duration);
        
        function dismissToast(toastElement) {
            toastElement.classList.remove('translate-y-0', 'opacity-100');
            toastElement.classList.add('translate-y-12', 'opacity-0');
            
            // Remove from DOM after transition completes
            setTimeout(() => {
                if (document.body.contains(toastElement)) {
                    document.body.removeChild(toastElement);
                }
            }, 300);
        }
    },
    
    // Convenience methods
    success(message, duration) {
        this.show(message, 'success', duration);
    },
    
    error(message, duration) {
        this.show(message, 'error', duration);
    },
    
    info(message, duration) {
        this.show(message, 'info', duration);
    },
    
    warning(message, duration) {
        this.show(message, 'warning', duration);
    }
};
