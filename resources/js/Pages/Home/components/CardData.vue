<script setup>
const props = defineProps({
    title: String,
    value: String
})
</script>

<template>
    <div class="p-6 bg-white shadow rounded-2xl dark:bg-neutral-800">
        <dl class="space-y-2">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ props.title }}</dt>

            <dd class="text-5xl font-light md:text-6xl dark:text-white">{{ props.value }}</dd>

            <dd class="flex items-center space-x-1 text-sm font-medium text-green-500 dark:text-green-400">
                <span>32k increase</span>

                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17.25 15.25V6.75H8.75"></path>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 7L6.75 17.25"></path>
                </svg>
            </dd>
        </dl>
    </div>
</template>