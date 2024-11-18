<script setup>
const props = defineProps({
    title: String,
    value: null
})
</script>

<template>
    <div class="p-6 bg-white shadow rounded-2xl dark:bg-neutral-800">
        <dl class="space-y-2">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ props.title }}</dt>

            <dd class="text-5xl font-light md:text-6xl dark:text-white">{{ props.value }}</dd>
        </dl>
    </div>
</template>