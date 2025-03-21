<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ title }}</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">This is an example Vue component.</p>
        <div class="mt-4">
            <button @click="incrementCounter" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                Clicked {{ counter }} times
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            counter: 0,
            title: 'Example Component'
        }
    },
    methods: {
        incrementCounter() {
            this.counter++;
        }
    }
}
</script>
