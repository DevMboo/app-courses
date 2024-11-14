<script setup>
import { ref, defineProps, defineEmits } from 'vue'

const props = defineProps({
  courseId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits()

const isOpen = ref(true)

const closeModal = () => {
  isOpen.value = false
  emit('close')
}
</script>

<template>
    <div v-if="isOpen" class="w-screen min-h-screen bg-[rgba(0,0,0,.5)] z-[1040] fixed top-0 left-0">
      <div class="w-full max-w-[420px] px-2 py-2 mx-auto bg-white rounded-lg my-16 relative">
        <div class="flex justify-between">
          <h1 class="text-xl">Deletar curso - ID: {{ courseId }}</h1>
          <button class="px-2 py-2 rounded-full flex justify-center items-center hover:bg-neutral-200" @click="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3 lucide lucide-x">
              <path d="M18 6 6 18" />
              <path d="m6 6 12 12" />
            </svg>
          </button>
        </div>
        <p>Dados do curso com ID: {{ courseId }}</p>
      </div>
    </div>
</template>
