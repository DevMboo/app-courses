<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3';

import Layout from '../Layout.vue'
import Paginator from '../Components/Paginator.vue';
import Breadcrumb from '../Components/Breadcrumb.vue';

import ModalCreated from './components/ModalCreated.vue';
import ModalEdit from './components/ModalEdit.vue';

const modalOpen = ref(false)
const modalType = ref(null)
const selectedUserId = ref(null)

const openModal = (id, type) => {
  selectedUserId.value = id
  modalType.value = type
  modalOpen.value = true
}

defineProps({ users: Object })
</script>

<template>
  <Layout>
    <Head title="Usuários" />
    <div>
      <Breadcrumb title="Usuário"/>

      <div class="flex justify-end gap-2">
        <!-- Modal's Courses start -->
        <ModalCreated :admin="true" /><!-- Modal's Courses end -->
      </div>

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
      <div class="flex flex-col mt-3" v-if="users && users.data.length > 0">
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
                        Email
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Tipo da conta
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Criado
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                      
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100">
                      <td class=" w-4">
                        <div class="flex items-center">
                          <img :src="`images/default.webp`" v-if="!user.avatar" class="mx-2 h-12 rounded-full">
                          <img :src="`storage/${user.avatar}`" v-if="user.avatar" class="mx-2 h-12 rounded-full">
                        </div>
                      </td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ user.name }}</td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ user.email }}</td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                        <span v-if="user.is_admin" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Administrador</span>
                        <span v-if="!user.is_admin" class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Usuário</span>
                      </td>
                      <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ new Date(user.created_at).toLocaleDateString('pt-BR') }}</td>
                      <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap space-x-2 divide-x">
                        <button class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(user.id, 'edit')">Editar</button>
                        <button class="text-blue-600 dark:text-blue-500 hover:underline ps-2" @click="openModal(user.id, 'delete')">Deletar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <Paginator :links="users.links" />
      </div>
    </div>
  </Layout>

  <!-- Modal Edit start -->
  <ModalEdit v-if="modalOpen && modalType === 'edit'" :userId="selectedUserId" @close="modalOpen = false" /><!-- Modal Edit end -->
</template>
