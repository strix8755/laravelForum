@props(['title', 'description' => null, 'actions' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white leading-6">
            {{ $title }}
        </h2>
        
        @if ($description)
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $description }}
            </p>
        @endif
    </div>
    
    @if ($actions)
        <div class="flex-shrink-0 flex items-center space-x-2">
            {{ $actions }}
        </div>
    @endif
</div>
