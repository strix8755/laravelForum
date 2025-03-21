@props([
    'type' => 'primary', 
    'as' => 'button',
    'size' => 'md',
    'icon' => false,
    'disabled' => false
])

@php
    // Define classes based on type
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none transition-all duration-200';
    
    $typeClasses = [
        'primary' => 'border border-transparent shadow-sm text-white bg-primary-700 hover:bg-primary-800 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-500',
        'secondary' => 'border border-transparent text-primary-700 bg-primary-100 hover:bg-primary-200 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-primary-900 dark:text-primary-300 dark:hover:bg-primary-800',
        'outline' => 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:border-gray-600 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700',
        'danger' => 'border border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500',
        'light' => 'border border-gray-200 text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700',
        'link' => 'text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 underline p-0',
    ];
    
    $sizeClasses = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-3 text-base',
        'xl' => 'px-6 py-3.5 text-base',
    ];
    
    $iconClasses = [
        'left' => 'inline-flex items-center',
        'only' => 'p-2'
    ];
    
    $disabledClasses = 'opacity-70 cursor-not-allowed';
    
    $classes = $baseClasses . ' ' . 
               ($typeClasses[$type] ?? $typeClasses['primary']) . ' ' .
               ($type !== 'link' ? ($sizeClasses[$size] ?? $sizeClasses['md']) : '') . ' ' .
               ($icon === 'only' ? $iconClasses['only'] : '') . ' ' .
               ($disabled ? $disabledClasses : '');
@endphp

@if ($as === 'button' || $as === 'input')
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'submit', 'disabled' => $disabled]) }}>
        {{ $slot }}
    </button>
@elseif ($as === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <{{ $as }} {{ $attributes->merge(['class' => $classes, 'disabled' => $disabled]) }}>
        {{ $slot }}
    </{{ $as }}>
@endif
