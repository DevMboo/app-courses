<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

import Layout from '../Layout.vue'

import Breadcrumb from '../Components/Breadcrumb.vue';
import ModalCreated from './components/ModalCreated.vue';

const formatCurrency = (value) => {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  }).format(value);
};

const courseId = ref(null)
const modalOpen = ref(false)

const openModal = (id) => {
  modalOpen.value = true
  courseId.value= id
}

defineProps({ courses: Object })
</script>


<template>
    <Layout>
        <Head title="Vitrine de cursos" />
        <div>
            <Breadcrumb title="Vitrine de cursos"/>
            
            <div v-if="$page.props.flash.message" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md rounded-t-lg mt-3">
              <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                  <p class="font-bold">Salvo</p>
                  <p class="text-sm">{{ $page.props.flash.message }}</p>
                </div>
              </div>
            </div>

            <div v-if="$page.props.flash.info" class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md rounded-t-lg mt-3">
              <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                  <p class="font-bold">Alerta</p>
                  <p class="text-sm">{{ $page.props.flash.info }}</p>
                </div>
              </div>
            </div>

            <h1 class="mt-3 text-2xl font-semibold mb-2">Cursos para você</h1>
            <div class="grid grid-cols-5 gap-3">
                <div class="col-span-1" v-for="course in courses.data" :key="course.id" @click="openModal(course.id)">
                    <div class="mx-auto px-0">
                        <div class="max-w-md cursor-pointer rounded-lg bg-white p-2 shadow duration-150 hover:scale-105 hover:shadow-md">
                        <img :src="`images/default.webp`" v-if="!course.avatar" class="w-full h-[211px] rounded-lg object-cover border border-gray-200 object-center">
                        <img :src="`storage/${course.avatar}`" v-if="course.avatar" class="w-full h-[211px] rounded-lg object-cover border border-gray-200 object-center">
                        <p class="my-4 pl-4 font-bold text-gray-500">{{ course.title }}</p>
                        <p class="mb-4 ml-4 text-xl font-semibold text-gray-800">{{ formatCurrency(course.price) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>

    <!-- Modal Edit start -->
    <ModalCreated v-if="modalOpen" @close="modalOpen = false" :courseId="courseId" /><!-- Modal Edit end -->
</template>