<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

const previewImage = ref('images/default.webp')
const newMaterial = ref('')
const props = defineProps({
  courseId: {
    type: Number,
    required: true
  },
  categories: Array
})

const emit = defineEmits()

const isOpen = ref(true)

const closeModal = () => {
  isOpen.value = false
  emit('close')
}

const config = ref({
  prefix: '',
  suffix: '',
  thousands: '.',
  decimal: ',',
  precision: 2,
  disableNegative: false,
  disabled: false,
  min: null,
  max: null,
  allowBlank: false,
  minimumNumberOfCharacters: 0,
  shouldRound: true,
  focusOnRight: false,
})

const form = useForm({
  title: null,
  avatar: null,
  category: null,
  price: 0,
  vacancies: null,
  date_ini: null,
  date_end: null,
  status: true,
  description: null,
  materials: []
})

const handleImagePreview = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.avatar = file
    previewImage.value = URL.createObjectURL(file)
  }
}

const addMaterial = () => {
  if (newMaterial.value.trim()) {
    form.materials.push(newMaterial.value.trim())
    newMaterial.value = ''
  }
}

const removeMaterial = (index) => {
  form.materials.splice(index, 1)
}

watch(() => props.courseId, (newCourseId) => {
  if (newCourseId) {
    axios.get(`/courses/${newCourseId}/details/edit`)
      .then((response) => {
        const course = response.data;

        form.title = course.title;
        form.category = course.category_id;
        form.price = course.price;
        form.vacancies = course.vacancies;
        form.date_ini = course.date_ini.split(" ")[0];
        form.date_end = course.date_end.split(" ")[0];
        form.status = !!course.status;
        form.description = course.description;

        form.materials = Array.isArray(course.materials) ? course.materials : (course.materials ? JSON.parse(course.materials) : []);

        previewImage.value = course.avatar ? `storage/${course.avatar}` : 'images/default.webp';

      })
      .catch((error) => {
        console.error("Erro ao carregar os detalhes do curso:", error);
      });
  }
}, { immediate: true });


const handleSubmit = () => {
  form.post(`/courses/${props.courseId}/details`, {
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
    <div class="w-full max-w-[820px] px-2 py-2 mx-auto bg-white rounded-lg my-16 relative">
      <div class="flex justify-between">
        <h1 class="text-xl font-semibold">Editar curso</h1>
        <button class="px-2 py-2 rounded-full flex justify-center items-center hover:bg-neutral-200"
          @click="closeModal">
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
              <p class="font-semibold mb-3">Detalhes do Cursos</p>
              <div class="grid grid-cols-6 gap-2">
                <div class="col-span-3">
                  <label for="title">Nome*</label>
                  <input type="text" placeholder="" id="title" v-model="form.title"
                    class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                  <div class="text-red-600 text-xs" v-if="form.errors.title">{{ form.errors.title }}
                  </div>
                </div>
                <div class="col-span-3">
                  <label for="category">Categoria*</label>
                  <select name="category" id="category" v-model="form.category"
                    class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.title }}
                    </option>
                  </select>
                  <div class="text-red-600 text-xs" v-if="form.errors.category">{{
                    form.errors.category }}</div>
                </div>
                <div class="col-span-3">
                  <label for="price">Valor*</label>
                  <money3 v-model="form.price" v-bind="config"
                    class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                  </money3>
                  <div class="text-red-600 text-xs" v-if="form.errors.price">{{ form.errors.price }}
                  </div>
                </div>
                <div class="col-span-3">
                  <label for="vacancies">Vagas*</label>
                  <input type="text" placeholder="300" id="vacancies" v-model="form.vacancies"
                    class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                  <div class="text-red-600 text-xs" v-if="form.errors.vacancies">{{
                    form.errors.vacancies }}</div>
                </div>
                <div class="col-span-3">
                  <label for="date_ini">Inscrições de*</label>
                  <input type="date" placeholder="08/10/2024" id="date_ini" v-model="form.date_ini"
                    class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                  <div class="text-red-600 text-xs" v-if="form.errors.date_ini">{{
                    form.errors.date_ini }}</div>
                </div>
                <div class="col-span-3">
                  <label for="date_end">Até*</label>
                  <input type="date" placeholder="10/10/2024" id="date_end" v-model="form.date_end"
                    class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                  <div class="text-red-600 text-xs" v-if="form.errors.date_end">{{
                    form.errors.date_end }}</div>
                </div>
                <div class="col-span-6">
                  <label for="description">Descrição*</label>
                  <textarea id="description" rows="9" v-model="form.description"
                    class="mr-2.5 mb-2 h-full max-h-[84px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600"></textarea>
                  <div class="text-red-600 text-xs" v-if="form.errors.description">{{
                    form.errors.description }}</div>
                </div>
                <div class="col-span-3">
                  <label for="materials">Materiais</label>

                  <div class="w-full flex">
                    <input type="text" placeholder="Adicionar material" v-model="newMaterial" id="materials"
                      class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                    <button @click="addMaterial" type="button"
                      class="bg-neutral-800 hover:bg-neutral-900 text-white max-h-[44px] py-1.5 px-2 rounded-md">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="size-4 lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                      </svg>
                    </button>
                  </div>

                  <!-- Exibição da lista de materiais -->
                  <ul class="mt-2">
                    <li v-for="(material, index) in form.materials" :key="index"
                      class="flex items-center justify-between mb-1 bg-gray-100 px-3 py-2 rounded-lg text-sm text-zinc-950">
                      <span>{{ material }}</span>
                      <button @click="removeMaterial(index)" type="button" class="text-red-600 hover:text-red-800">
                        Remover
                      </button>
                    </li>
                  </ul>
                </div>

                <div class="col-span-6">

                  <div class="inline-flex items-center gap-2">
                    <label class="flex items-center cursor-pointer relative">
                      <input type="checkbox" checked v-model="form.status"
                        class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                        id="status" name="status" />
                      <span
                        class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                          fill="currentColor" stroke="currentColor" stroke-width="1">
                          <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </span>
                    </label>
                    Status
                  </div>

                </div>
              </div>
            </div>
            <div class="col-span-1">
              <p class="font-semibold mb-3 text-center">Thumbnail</p>
              <div class="px-3">
                <img :src="previewImage" class="mx-auto w-44 h-44 rounded-2xl" alt="Image preview">

                <input type="file" class="hidden" @change="handleImagePreview" ref="fileInputEdit">

                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                  {{ form.progress.percentage }}%
                </progress>

                <div class="flex justify-center mt-3 mb-2">
                  <button type="button" @click="$refs.fileInputEdit.click()"
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
            @click="closeModal">Cancelar</button>
          <button class="bg-neutral-800 hover:bg-neutral-900 text-white w-full max-w-[78px] py-1.5 px-2 rounded-md"
            type="submit">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>
