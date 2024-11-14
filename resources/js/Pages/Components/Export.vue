<script setup>
import { ref, defineProps } from 'vue'

const open = ref(false)
const { selected, mode } = defineProps({ selected: Array, mode: String })


const handleExport = (format) => {
  axios.post('/export', {
    ids: selected.length > 0 ? selected : null,
    mode: mode,
    format: format
  })
  open.value = false
}

</script>

<template>
  <div class="relative">
    <button @click="open = !open" class="border border-gray-300 text-gray-900 hover:bg-gray-50 w-[114.83px] px-3 py-2 text-sm rounded-lg flex justify-center gap-1 items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 lucide lucide-file-down"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
      Exportar
    </button>

    <div v-if="open" @click.outside="open = false" class="absolute mt-2 w-[200px] bg-white border border-gray-100 rounded-lg shadow-lg z-10">
      <ul class="text-sm">
        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="handleExport('pdf')">
          Exportar PDF
        </li>
        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="handleExport('excel')">
          Exportar Excel
        </li>
      </ul>
    </div>
  </div>
</template>
