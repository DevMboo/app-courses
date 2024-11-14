<script>
import { Link } from '@inertiajs/vue3'

export default {
    props: {
        links: Array,
    },
    components: {
        Link
    }
}
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1 mt-3">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label"></div>
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-neutral-500 focus:text-neutral-500"
                    :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label"></Link>
            </template>
        </div>
    </div>
</template>
