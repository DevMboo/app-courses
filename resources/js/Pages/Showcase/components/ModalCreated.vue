<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

const emit = defineEmits()

const previewImage = ref('images/default.webp')

const isOpen = ref(true)

const nameCourse = ref(null)

const priceCourse = ref(null)

const lockedCourse = ref(false)

const descriptionCourse = ref(null)

const closeModal = () => {
    isOpen.value = false
    emit('close')
}

const form = useForm({
    name: null,
    email: null,
    phone: null,
    payment_method: 'pix',
    cpfCnpj: null,
    phone: null
})

const props = defineProps({
    courseId: {
        type: Number,
        required: true
    },
})

const handleSubmit = () => {
    form.post(`/showcase/${props.courseId}`, {
        onSuccess: () => {
            form.reset();
            closeModal();
        },
        onError: (errors) => {
            console.error("Erro no envio do formulário:", errors);
        }
    });
}

const handleImagePreview = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.avatar = file
        previewImage.value = URL.createObjectURL(file)
    }
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};

watch(() => props.courseId, (newCourseId) => {
    if (newCourseId) {
        axios.get(`/showcase/${newCourseId}/details/show`)
            .then((response) => {
                
                const course = response.data.course;
                
                lockedCourse.value = response.data.buy;
                nameCourse.value = course.title;
                priceCourse.value = course.price;
                descriptionCourse.value = course.description;
                previewImage.value = course.avatar ? `storage/${course.avatar}` : 'images/default.webp';

            })
            .catch((error) => {
                console.error("Erro ao carregar os detalhes do curso:", error);
            });
    }
}, { immediate: true });

</script>

<template>
    <div v-if="isOpen" class="w-screen min-h-screen bg-[rgba(0,0,0,.5)] z-[1040] fixed top-0 left-0">
        <div class="w-full max-w-[980px] px-2 py-2 mx-auto bg-white rounded-lg my-16 relative">
            <div class="flex justify-between">
                <h1 class="text-xl font-semibold" v-if="!lockedCourse">Inscrição</h1>
                <h1 class="text-xl font-semibold" v-if="lockedCourse">Assistir aula</h1>
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
            <form @submit.prevent="handleSubmit" >
                <div class="">
                    <div class="grid grid-cols-4 divide-x gap-2 mt-4">
                        <div class="col-span-3">
                            <p class="font-semibold mb-3">Detalhes do Usuário</p>
                            <div class="grid grid-cols-6 gap-2" v-if="!lockedCourse">
                                <div class="col-span-3">
                                    <label for="name">Nome*</label>
                                    <input type="text" placeholder="" id="name" v-model="form.name"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.name">{{ form.errors.name }}
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label for="email">Email*</label>
                                    <input type="email" placeholder="" id="email" v-model="form.email"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.email">{{ form.errors.email }}
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label for="cpfCnpj">CPF*</label>
                                    <input type="cpfCnpj" placeholder="" id="cpfCnpj" v-model="form.cpfCnpj"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.cpfCnpj">{{ form.errors.cpfCnpj
                                        }}
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label for="phone">Celular*</label>
                                    <input type="phone" placeholder="" id="phone" v-model="form.phone"
                                        class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                    <div class="text-red-600 text-xs" v-if="form.errors.phone">{{ form.errors.phone }}
                                    </div>
                                </div>
                                <div class="col-span-6">
                                    <label for="txt">Descrição do curso</label>
                                    <p id="txt" class="border border-gray-200 px-2 text-justify rounded-lg">{{ descriptionCourse }}</p>
                                </div>
                                <div class="col-span-6">
                                    <p class="font-semibold mb-3">Forma de pagamento</p>
                                    <div class="grid grid-cols-9 gap-2">
                                        <div class="col-span-3">
                                            <div
                                                class="border border-gray-200 flex items-center h-14 rounded-lg px-2 gap-2 cursor-pointer hover:bg-gray-100 peer-checked:bg-blue-400 peer-checked:border-blue-600">
                                                <input type="radio" name="payment_method" id="payment_pix" v-model="form.payment_method" value="pix"
                                                    class="hidden peer">
                                                <label for="payment_pix"
                                                    class="flex items-center gap-2 cursor-pointer peer-checked:text-blue-600 peer-checked:font-semibold w-full">
                                                    <span
                                                        class="w-4 h-4 rounded-full flex items-center justify-center peer-checked:border-blue-600">
                                                        <span
                                                            class="w-2 h-2 bg-blue-600 rounded-full hidden peer-checked:inline-block"></span>
                                                    </span>
                                                    Pix
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <p class="text-xl font-semibold">Valor: {{ formatCurrency(priceCourse) }}</p>
                                </div>
                            </div>
                            <div v-if="lockedCourse">
                                <img :src="'images/default.webp'" class="w-full max-h-[450px]" alt="Default image">
                            </div>
                        </div>
                        <div class="col-span-1">
                            <p class="font-semibold mb-3 text-center">Poster do curso</p>
                            <div class="px-3">
                                <img :src="previewImage" class="mx-auto w-44 h-44 border border-gray-200 rounded-2xl" alt="Image preview">

                                <input type="file" class="hidden" @change="handleImagePreview" ref="fileInput">

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <p class="text-center mt-2">Curso: {{ nameCourse }}</p>
                            <div class="px-3" v-if="lockedCourse">
                                <ul class="space-y-1">
                                    <li class="py-4 px-2 bg-neutral-200 rounded-lg hover:bg-neutral-100 cursor-pointer flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                                        AULA 01
                                    </li>
                                    <li class="py-4 px-2 bg-neutral-200 rounded-lg hover:bg-neutral-100 cursor-pointer flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                                        AULA 02
                                    </li>
                                    <li class="py-4 px-2 bg-neutral-200 rounded-lg hover:bg-neutral-100 cursor-pointer flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                                        AULA 03
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex w-full justify-end gap-2 mt-3" >
                    <button type="button" class="border border-gray-200 hover:bg-neutral-200 py-1.5 px-2 rounded-md"
                        @click="closeModal">Cancelar</button>
                    <button
                        v-if="!lockedCourse"
                        class="bg-neutral-800 hover:bg-neutral-900 text-white w-full max-w-[78px] py-1.5 px-2 rounded-md"
                        type="submit">Comprar</button>
                    <button
                        v-if="lockedCourse"
                        class="bg-indigo-800 hover:bg-indigo-900 text-white w-full max-w-[128px] py-1.5 px-2 rounded-md"
                        type="submit">Assistir aula</button>
                </div>
            </form>
        </div>
    </div>
</template>