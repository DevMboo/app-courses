<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const open = ref(false);
const previewImage = ref('images/default.webp');

const form = useForm({
  name: null,
  avatar: null,
  email: null,
  is_admin: 0,
  password: null,
  confirm_password: null
});

const handleImagePreview = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.avatar = file;
    previewImage.value = URL.createObjectURL(file);
  }
}

const handleSubmit = () => {
  form.post('/users', {
    onSuccess: () => {
      form.reset();
      previewImage.value = 'images/default.webp';
      open.value = false;
    },
    onError: (errors) => {
      console.error("Erro no envio do formulário:", errors);
    }
  });
}

defineProps({ admin: Boolean });
</script>


<template>
    <button @click="open = true" class="bg-neutral-800 text-white px-3 py-2 text-sm rounded-lg flex justify-center gap-1 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Novo usuário
    </button>

    <div v-if="open" class="w-screen min-h-screen bg-[rgba(0,0,0,.5)] z-[1040] fixed top-0 left-0">
        <div class="w-full max-w-[820px] px-2 py-2 mx-auto bg-white rounded-lg my-16 relative">
            <div class="flex justify-between">
                <h1 class="text-xl font-semibold">Novo usuário</h1>
                <button class="px-2 py-2 rounded-full flex justify-center items-center hover:bg-neutral-200"
                    @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="size-3 lucide lucide-x">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <form @submit.prevent="handleSubmit">
                <div class="">
                    <div class="grid grid-cols-4 divide-x gap-2 mt-4">
                        <div class="col-span-3">
                            <p class="font-semibold mb-3">Detalhes do Usuário</p>
                            <div class="grid grid-cols-6 gap-2">
                                <div class="col-span-3">
                                    <label for="name">Nome*</label>
                                    <input type="text" placeholder="" id="name" v-model="form.name"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.name">{{ form.errors.name }}
                                    </div>
                                </div>
                                <div class="col-span-3" v-if="admin">
                                    <label for="is_admin">Tipo de usuário*</label>
                                    <select name="is_admin" id="is_admin" v-model="form.is_admin"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                        <option value="0">Aluno</option>
                                        <option value="1">Administrador</option>
                                    </select>
                                    <div class="text-red-600 text-xs" v-if="form.errors.is_admin">{{
                                        form.errors.is_admin }}</div>
                                </div>
                                <div class="col-span-6">
                                    <label for="email">E-mail*</label>
                                    <input type="email" placeholder="" id="email" v-model="form.email"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.email">{{ form.errors.email }}
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label for="password">Senha*</label>
                                    <input type="password" placeholder="" id="password" v-model="form.password"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.password">{{ form.errors.password }}
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label for="confirm_password">Confirmar password*</label>
                                    <input type="password" placeholder="" id="confirm_password" v-model="form.confirm_password"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.confirm_password">{{ form.errors.confirm_password }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <p class="font-semibold mb-3 text-center">Foto de perfil</p>
                            <div class="px-3">
                                <img :src="previewImage" class="mx-auto w-44 h-44 rounded-2xl" alt="Image preview">

                                <input type="file" class="hidden" @change="handleImagePreview" ref="fileInput">

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>

                                <div class="flex justify-center mt-3 mb-2">
                                    <button type="button" @click="$refs.fileInput.click()"
                                        class="w-44 py-3 px-2 bg-neutral-800 hover:bg-neutral-900 text-neutral-400 font-semibold mx-auto rounded-lg">
                                        Selecione imagem
                                    </button>
                                </div>
                                <div class="text-red-600 text-xs" v-if="form.errors.avatar">{{ form.errors.avatar }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full justify-end gap-2 mt-3">
                    <button class="border border-gray-200 hover:bg-neutral-200 py-1.5 px-2 rounded-md"
                        @click="open = false">Cancelar</button>
                    <button
                        class="bg-neutral-800 hover:bg-neutral-900 text-white w-full max-w-[78px] py-1.5 px-2 rounded-md"
                        type="submit" >Salvar</button>
                </div>
            </form>
        </div>
    </div>
</template>