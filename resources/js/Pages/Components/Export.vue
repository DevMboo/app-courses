<script setup>
import { ref, defineProps } from 'vue';
import axios from 'axios';

const open = ref(false);
const isProcessing = ref(false);
const feedbackMessage = ref('');
const { selected, mode } = defineProps({ selected: Array, mode: String });

const handleExport = async (format) => {
  try {
    isProcessing.value = true;
    feedbackMessage.value = 'Sua exportação está sendo processada. Verifique seu e-mail em breve.';

    await axios.post('/export', {
      ids: selected.length > 0 ? selected : null,
      mode: mode,
      format: format
    })

    open.value = false;
  } catch (error) {
    feedbackMessage.value = 'Ocorreu um erro ao iniciar a exportação. Tente novamente.';
  } finally {
    isProcessing.value = false;
  }
}
</script>

<template>
  <div class="flex gap-2"> 
    <p v-if="feedbackMessage" class="mt-2 text-sm text-gray-600">
      {{ feedbackMessage }}
    </p>
    <div class="relative flex flex-col justify-end">
      <button @click="open = !open" class="static right-0 border border-gray-300 text-gray-900 hover:bg-gray-50 w-[114.83px] px-3 py-2 text-sm rounded-lg flex justify-center gap-1 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 lucide lucide-file-down"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
        Exportar
      </button>
  
      <div v-if="open" @click.outside="open = false" class="absolute right-0 mt-2 w-[200px] bg-white border border-gray-100 rounded-lg shadow-lg z-10">
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
  </div>

</template>
