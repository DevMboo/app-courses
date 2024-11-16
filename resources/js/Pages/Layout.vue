<script setup>
import { usePage } from '@inertiajs/vue3'
import Header from './Components/Header.vue'
import SideBar from './Components/SideBar.vue'

const { props } = usePage()
const isAuthenticated = props.auth.user
</script>

<template>
  <div class="flex gap-3">
    <SideBar  v-if="isAuthenticated && isAuthenticated.is_admin" />
    <main class="w-full">
      <Header  v-if="isAuthenticated" />
      <article class="bg-neutral-100 rounded-s-xl h-screen px-2">
        <slot />
      </article>
    </main>
  </div>
</template>