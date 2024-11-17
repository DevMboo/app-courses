<script setup>
import { usePage, router, Link } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'

const { props, url } = usePage()
const user = computed(() => props.auth.user)

const searchQuery = ref('')
const open = ref(false)

watch(searchQuery, (newQuery) => {
  router.visit(url, {
    method: 'get',
    data: { search: newQuery },
    preserveState: true,
    preserveScroll: true
  })
})

const logout = () => {
  router.visit('/loggout', { method: 'get' })
}
</script>

<template>
  <header class="w-full mt-3">
    <nav class="flex justify-between w-full py-2 px-2 relative">
      <div class="relative">
        <svg class="absolute top-[21px] left-3 -translate-y-2/4 text-neutral-600 lucide lucide-search" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input 
          type="search" 
          v-model="searchQuery" 
          placeholder="Pesquisar..." 
          class="py-2 px-3 ps-10 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
        >
      </div>

      <div class="flex items-center gap-3">
        <button>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        </button>

        <p>Olá, {{ user.name }}</p>

        <div class="relative">
          <button>
            <img :src="'images/default.webp'" @click="open = !open" class="w-12 h-12 rounded-full" alt="default image">
          </button>
          <div v-if="open" @click.outside="open = false" class="absolute right-0 mt-2 w-[200px] bg-white border border-gray-100 rounded-lg shadow-lg z-40">
            <ul class="text-sm">
              <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                <Link href="/payment">Minhas inscrições</Link>
              </li>
              <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="logout">
                Desconectar
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>
