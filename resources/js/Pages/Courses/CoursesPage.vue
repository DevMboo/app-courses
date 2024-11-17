<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Paginator from '../Components/Paginator.vue';

import Layout from '../Layout.vue'
import Breadcrumb from '../Components/Breadcrumb.vue';
import Export from '../Components/Export.vue';

import ModalCreated from './components/ModalCreated.vue';
import ModalEdit from './components/ModalEdit.vue';
import ModalView from './components/ModalView.vue';
import ModalDelete from './components/ModalDelete.vue';

const modalOpen = ref(false)
const modalType = ref(null)
const selectedCourseId = ref(null)
const selectedCourses = ref([]);

const openModal = (id, type) => {
  selectedCourseId.value = id
  modalType.value = type
  modalOpen.value = true
}

const formatCurrency = (value) => {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  }).format(value);
};

defineProps({ categories: Object, courses: Object })
</script>

<template>
  <Layout>
    <Head title="Cursos" />
    <div>
      <Breadcrumb title="Cursos" />

      <div class="flex justify-end gap-2">
        <!-- Filter page start -->
        <Export :selected="selectedCourses" :mode="'course'" /> <!-- Filter page end -->
        <!-- Modal's Courses start -->
        <ModalCreated :categories="categories" /><!-- Modal's Courses end -->
      </div>
      <div>

      <div v-if="$page.props.flash.message" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md rounded-t-lg mt-3">
        <div class="flex">
          <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
          <div>
            <p class="font-bold">Salvo</p>
            <p class="text-sm">{{ $page.props.flash.message }}</p>
          </div>
        </div>
      </div>

        <!-- This table component -->
        <div class="flex flex-col mt-3" v-if="courses && courses.data.length > 0">
          <div class="overflow-x-auto sm:rounded-lg">
            <div class="inline-block min-w-full align-middle">
              <div class="overflow-hidden ">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                  <thead class="bg-neutral-800">
                    <tr>
                      <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                        #
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                        Nome
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Valor
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Ativo
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Período de inscrição
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Vagas restantes
                      </th>
                      <th scope="col" class="p-4">
                        <span class="sr-only">act</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="course in courses.data" :key="course.id" class="hover:bg-gray-100">
                      <td class="p-4 w-4">
                        <div class="flex items-center">
                          <input id="checkbox-table-1" type="checkbox" :value="course.id"
                            v-model="selectedCourses"  
                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-100 focus:ring-blue-500">
                          <label for="checkbox-table-1" class="sr-only">checkbox</label>
                        </div>
                      </td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ course.title }}</td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap">{{ formatCurrency(course.price) }}</td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                        <span v-if="course.status" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">ATIVO</span>
                        <span v-if="!course.status" class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">INATIVO</span>
                      </td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ new Date(course.date_ini).toLocaleDateString('pt-BR') }}
                      </td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ course.vacancies }}
                      </td>
                      <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap space-x-2 divide-x">
                        <button class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(course.id, 'view')">Visualizar</button>
                        <button class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(course.id, 'edit')">Editar</button>
                        <button class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(course.id, 'delete')">Deletar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <Paginator :links="courses.links" />
        </div>

        <!-- This table component empty -->
        <div v-if="courses && courses.data.length === 0" class="mt-3 text-gray-700 text-center">
          <img :src="'images/empty.svg'" class="w-64 h-64 mx-auto" alt="Empty svg">
          Nenhum curso criado ainda...
        </div>

      </div>
    </div>

    <!-- Modal Edit start -->
    <ModalEdit v-if="modalOpen && modalType === 'edit'" :categories="categories" :courseId="selectedCourseId" @close="modalOpen = false" /><!-- Modal Edit end -->
    <!-- Modal View start -->
    <ModalView v-if="modalOpen && modalType === 'view'" :categories="categories" :courseId="selectedCourseId" @close="modalOpen = false" /><!-- Modal View end -->
    <!-- Modal Delete start -->
    <ModalDelete v-if="modalOpen && modalType === 'delete'" :courseId="selectedCourseId" @close="modalOpen = false" /><!-- Modal Delete end -->
  </Layout>
</template>
