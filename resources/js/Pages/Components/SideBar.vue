<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const { url } = usePage()

const linkClasses = (path) => {
  const currentPath = new URL(url, window.location.origin).pathname
  return `text-xl font-light py-2 px-3 flex gap-2 items-center rounded-md text-neutral-500 ${
    currentPath === path ? 'bg-neutral-400 text-neutral-800' : 'hover:bg-neutral-200'
  }`
}
</script>


<template>
    <aside class="min-h-screen w-full max-w-[15%] bg-neutral-800 px-4 rounded-e-2xl">
        <div class="mx-auto mt-3 bg-neutral-500 w-20 h-20 flex justify-center items-center rounded-full">
            <img :src="'images/courses.webp'" class="w-16 h-16" alt="Ico application">
        </div>
        <h1 class="my-3 text-xl text-neutral-500 text-center">@APP COURSES</h1>
        <ul class="flex flex-col gap-y-2">
            <li>
                <Link class="text-[14px]" href="/" :class="linkClasses('/')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                    <path
                        d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
                Dashboard
                </Link>
            </li>
            <li>
                <Link class="text-[14px]" href="/courses" :class="linkClasses('/courses')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-1">
                    <path d="M11 14h1v4" />
                    <path d="M16 2v4" />
                    <path d="M3 10h18" />
                    <path d="M8 2v4" />
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                </svg>
                Cursos
                </Link>
            </li>
            <li>
                <Link class="text-[14px]" href="/users" :class="linkClasses('/users')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-round">
                    <path d="M18 21a8 8 0 0 0-16 0" />
                    <circle cx="10" cy="8" r="5" />
                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                </svg>
                Usuário
                </Link>
            </li>
            <li>
                <Link class="text-[14px]" href="/loggout" :class="linkClasses('/loggout')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-power"><path d="M12 2v10"/><path d="M18.4 6.6a9 9 0 1 1-12.77.04"/></svg>
                Desconectar
                </Link>
            </li>
        </ul>
    </aside>
</template>