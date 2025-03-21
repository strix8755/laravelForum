@props(['type' => 'info', 'message', 'duration' => 5000])

@php
    $typeClasses = [
        'info' => 'bg-blue-50 dark:bg-blue-900/30 border-blue-400 dark:border-blue-500 text-blue-700 dark:text-blue-200',
        'success' => 'bg-green-50 dark:bg-green-900/30 border-green-400 dark:border-green-500 text-green-700 dark:text-green-200',
        'error' => 'bg-red-50 dark:bg-red-900/30 border-red-400 dark:border-red-500 text-red-700 dark:text-red-200',
        'warning' => 'bg-amber-50 dark:bg-amber-900/30 border-amber-400 dark:border-amber-500 text-amber-700 dark:text-amber-200',
    ];
    
    $iconClasses = [
        'info' => 'text-blue-400',
        'success' => 'text-green-400',
        'error' => 'text-red-400',
        'warning' => 'text-amber-400',
    ];
@endphp

<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-init="setTimeout(() => show = false, {{ $duration }})" 
    @class(["border-l-4 p-4 rounded-md shadow-sm flex items-start", $typeClasses[$type]])
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    role="alert"
>
    <div class="flex-shrink-0">
        @if($type === 'info')
            <svg class="h-5 w-5 {{ $iconClasses[$type] }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        @elseif($type === 'success')
            <svg class="h-5 w-5 {{ $iconClasses[$type] }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        @elseif($type === 'error')
            <svg class="h-5 w-5 {{ $iconClasses[$type] }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        @elseif($type === 'warning')
            <svg class="h-5 w-5 {{ $iconClasses[$type] }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        @endif
    </div>

    <div class="ml-3">
        <p class="text-sm">{{ $message }}</p>
    </div>

    <div class="ml-auto pl-3">
        <div class="-mx-1.5 -my-1.5">
            <button 
                @click="show = false" 
                class="inline-flex rounded-md p-1.5 hover:bg-{{ $type === 'info' ? 'blue' : ($type === 'success' ? 'green' : ($type === 'error' ? 'red' : 'amber')) }}-100 dark:hover:bg-{{ $type === 'info' ? 'blue' : ($type === 'success' ? 'green' : ($type === 'error' ? 'red' : 'amber')) }}-800 focus:outline-none"
            >
                <span class="sr-only">Dismiss</span>
                <svg class="h-4 w-4 {{ $iconClasses[$type] }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
</div>
