<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  buyingId: {
    type: Number,
    required: true
  },
  courses: Array,
  users: Array
})

const emit = defineEmits()

const isOpen = ref(true)

const closeModal = () => {
  isOpen.value = false
  emit('close')
}

const form = useForm({
  email: null,
  phone: null,
  cpfCnpj: null,
  price: 0,
  course_id: 0,
  user_id: null,
  status: null
})

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

watch(() => props.buyingId, (newBuyingId) => {
    console.log(props.buyingId, newBuyingId)
    if (newBuyingId) {
        axios.get(`/payment/${newBuyingId}/details/edit`)
            .then((response) => {
                const buying = response.data;

                form.email = buying.email;
                form.phone = buying.phone;
                form.cpfCnpj = buying.cpf;
                form.price = buying.price;
                form.course_id = buying.course_id;
                form.user_id = buying.user_id;
                form.status = buying.status;
            })
    }
}, { immediate: true })

const handleSubmit = () => {
  form.post(`/payment/${props.buyingId}/details`, {
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
        <div class="w-full max-w-[620px] px-2 py-2 mx-auto bg-white rounded-lg my-16 relative">
            <div class="flex justify-between">
                <h1 class="text-xl font-semibold">Editar inscrição</h1>
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
                <div v-if="form.status != 'payment_confirmed'">
                    <p class="font-semibold mb-3 mt-3">Detalhes da inscrição</p>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="col-span-1">
                            <label for="email">Email*</label>
                            <input type="email" placeholder="" id="email" v-model="form.email"
                                class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                            <div class="text-red-600 text-xs" v-if="form.errors.email">{{ form.errors.email }}
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="cpfCnpj">CPF*</label>
                            <input type="cpfCnpj" placeholder="" id="cpfCnpj" v-model="form.cpfCnpj"
                                class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                            <div class="text-red-600 text-xs" v-if="form.errors.cpfCnpj">{{ form.errors.cpfCnpj }}
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="phone">Celular*</label>
                            <input type="phone" placeholder="" id="phone" v-model="form.phone"
                                class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                            <div class="text-red-600 text-xs" v-if="form.errors.phone">{{ form.errors.phone }}
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="price">Valor*</label>
                            <money3 v-model="form.price" v-bind="config"
                                class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                            </money3>
                        </div>
                        <div class="col-span-2">
                            <label for="status">Status*</label>
                            <select name="status" id="status" v-model="form.status" class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                <option value="reprocess_payment" selected>Reprocessar pagamento</option>
                                <option value="payment_created">Pagamento criado</option>
                                <option value="pending">Pendente</option>
                                <option value="canceled">Cancelar</option>
                            </select>
                            <div class="text-red-600 text-xs" v-if="form.errors.status">{{ form.errors.status }}
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="course_id">Curso*</label>
                            <select name="course_id" id="course_id" v-model="form.course_id" class="mr-2.5 mb-2 h-full max-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600">
                                <option v-for="course in courses" :value="course.id" selected>{{ course.title }}</option>
                            </select>
                            <div class="text-red-600 text-xs" v-if="form.errors.course_id">{{ form.errors.course_id }}
                            </div>
                        </div>
                    </div>
                    <div class="flex w-full justify-end gap-2 mt-3">
                        <button class="border border-gray-200 hover:bg-neutral-200 py-1.5 px-2 rounded-md"
                            @click="closeModal">Cancelar</button>
                        <button class="bg-neutral-800 hover:bg-neutral-900 text-white w-full max-w-[78px] py-1.5 px-2 rounded-md"
                            type="submit">Salvar</button>
                    </div>
                </div>

                <div v-if="form.status == 'payment_confirmed'">
                    <div class="flex justify-center items-center flex-col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="size-16 text-red-600 lucide lucide-triangle-alert">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                        <h1 class="text-2xl font-semibold">Atenção!</h1>
                        <p class="text-lg font-semibold">Nenhuma alteração pode ser realizada uma vez que o pagamento já
                            foi efetuado.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>