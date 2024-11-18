<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  userId: {
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

const form = useForm({})

const handleSubmit = () => {
  form.post(`/users/${props.userId}/destroy`, {
    onSuccess: () => {
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.error("Erro no envio do formulário:", errors);
    }
  });
}

</script>

<template>
    <div v-if="isOpen" class="w-screen min-h-screen bg-[rgba(0,0,0,.5)] z-[1040] fixed top-0 left-0">
      <div class="w-full max-w-[420px] px-2 py-2 mx-auto bg-white rounded-lg my-16 relative">
        <div class="flex justify-between">
          <h1 class="text-xl">Tem certeza?</h1>
          <button class="px-2 py-2 rounded-full flex justify-center items-center hover:bg-neutral-200" @click="closeModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3 lucide lucide-x">
              <path d="M18 6 6 18" />
              <path d="m6 6 12 12" />
            </svg>
          </button>
        </div>
        <form @submit.prevent="handleSubmit">
          <div class="py-2">
            <svg class="size-12 text-red-600 mx-auto lucide lucide-triangle-alert" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            <p class="text-center text-md font-semibold">Você está prestes a excluir este usuário. Todos os registros vinculados a ele serão permanentemente apagados. Essa ação é irreversível. Deseja continuar?</p>
          </div>
          <div class="flex justify-center gap-2">
              <button class="border border-gray-200 hover:bg-neutral-200 py-1.5 px-2 rounded-md"
                  @click="closeModal">Cancelar</button>
              <button
                  class="bg-red-800 hover:bg-red-900 text-white w-[168px] py-1.5 px-2 rounded-md"
                  type="submit" >Confirmar e deletar</button>
          </div>
        </form>
      </div>
    </div>
</template>
