<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

import Layout from '../Layout.vue'
import Export from '../Components/Export.vue';
import Breadcrumb from '../Components/Breadcrumb.vue';

import CardData from './components/CardData.vue';
import ModalEdit from './components/ModalEdit.vue';
import ModalDelete from './components/ModalDelete.vue';

const selectedBuying = ref([]);
const modalOpen = ref(false)
const modalType = ref(null)
const selectedBuyingId = ref(null)

const openModal = (id, type) => {
  selectedBuyingId.value = id
  modalType.value = type
  modalOpen.value = true
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};

defineProps({ totals: Object, buyings: Object, courses: Object })
</script>

<template>
  <Layout>

    <Head title="Dashboard" />
    <div>
      <Breadcrumb title="Dashboard" />

      <section class="grid gap-6 md:grid-cols-4 max-w-9xl mx-auto w-full mt-2">
        <CardData :title="'Total de cursos'" :value="totals.courses" />

        <CardData :title="'Total de alunos'" :value="totals.students" />

        <CardData :title="'Total de administradores'" :value="totals.admin" />

        <CardData :title="'Lucro total'" :value="formatCurrency(totals.budget)" />
      </section>

      <div v-if="$page.props.flash.message"
        class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md rounded-t-lg mt-3">
        <div class="flex">
          <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20">
              <path
                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
            </svg></div>
          <div>
            <p class="font-bold">Salvo</p>
            <p class="text-sm">{{ $page.props.flash.message }}</p>
          </div>
        </div>
      </div>
      
      <!-- This table component -->
      <div class="flex flex-col mt-3" v-if="buyings && buyings.data.length > 0">
        <hr>
        <div class="flex justify-between gap-2 py-2 relative">
          <h1 class="mb-2 font-semibold text-lg">Lista de inscrições</h1>
          <!-- Filter page start -->
          <Export :selected="selectedBuying" :mode="'buying'" /> <!-- Filter page start -->
        </div>
        <div class="overflow-x-auto sm:rounded-lg">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden ">
              <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-neutral-800">
                  <tr>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                      #
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                      Poster
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                      Curso
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                      Aluno
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                      Status
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                      Preço
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                      Abertura
                    </th>
                    <th scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="buying in buyings.data" :key="buying.id" class="hover:bg-gray-100">
                    <td class="p-4 w-4">
                      <div class="flex items-center">
                        <input id="checkbox-table-1" type="checkbox" :value="buying.id" v-model="selectedBuying"
                          class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-100 focus:ring-blue-500">
                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                      </div>
                    </td>
                    <td class="p-4">
                      <div class="flex items-center">
                        <img :src="'images/default.webp'" v-if="!buying.avatar" class="w-16 h-16 rounded-full object-cover"
                          alt="Course default image">
                        <img :src="'storage/' + buying.avatar" v-if="buying.avatar" class="w-16 h-16 rounded-full object-cover"
                          alt="Course image">
                      </div>
                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ buying.name }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                      {{ buying.user_name }}
                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                      <span v-if="buying.status == 'canceled'"
                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">CANCELADO</span>
                      <span v-if="buying.status == 'payment_created'"
                        class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">PENDENTE</span>
                      <span v-if="buying.status == 'reprocess_payment'"
                        class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">REPROCESSADO</span>
                      <span v-if="buying.status == 'payment_confirmed'"
                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">PAGAMENTO
                        EFETUADO</span>

                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{
                      formatCurrency(buying.price) }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ new
                      Date(buying.created_at).toLocaleDateString('pt-BR') }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap space-x-2 divide-x">
                       <button class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(buying.id, 'edit')">Editar</button>
                       <button v-if="buying.status != 'payment_confirmed'" class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(buying.id, 'delete')">Deletar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- This table component empty -->
      <div v-if="buyings && buyings.data.length === 0" class="mt-3 text-gray-700 text-center">
        <img :src="'images/empty.svg'" class="w-64 h-64 mx-auto" alt="Empty svg">
        Nenhuma solicitação de pagamento confirmada ainda...
      </div>

    </div>

    <!-- Modal Delete start -->
    <ModalDelete v-if="modalOpen && modalType === 'delete'" :courses="courses" :buyingId="selectedBuyingId" @close="modalOpen = false" /><!-- Modal Delete end -->
    <!-- Modal Edit start -->
    <ModalEdit v-if="modalOpen && modalType === 'edit'" :courses="courses" :buyingId="selectedBuyingId" @close="modalOpen = false" /><!-- Modal Edit end -->
  </Layout>
</template>
