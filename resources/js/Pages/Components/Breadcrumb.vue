<script setup>

defineProps({ title: String })
</script>

<template>
    <nav aria-label="breadcrumb" class="w-max">
        <ol class="flex w-full flex-wrap items-center rounded-md mt-6 px-4 py-2">
          <li
            class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
            <a href="#">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path
                  d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                </path>
              </svg>
            </a>
            <span class="pointer-events-none mx-2 text-slate-800">
              /
            </span>
          </li>
          <li
            class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
            <a href="#">Pages</a>
            <span class="pointer-events-none mx-2 text-slate-800">
              /
            </span>
          </li>
          <li
            class="flex cursor-pointer items-center text-sm text-slate-500 transition-colors duration-300 hover:text-slate-800">
            <a href="#">{{title}}</a>
          </li>
        </ol>
    </nav>
</template>