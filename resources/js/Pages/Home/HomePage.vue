<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

import Layout from '../Layout.vue'
import Export from '../Components/Export.vue';
import Breadcrumb from '../Components/Breadcrumb.vue';

import CardData from './components/CardData.vue';

const selectedCourses = ref([]);

const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};

defineProps({ totals: Object, buyings: Object })
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

      <!-- This table component -->
      <div class="flex flex-col mt-3">
        <hr>
        <div class="flex justify-between gap-2 py-2 relative">
          <h1 class="mb-2 font-semibold text-lg">Lista de inscrições</h1>
          <!-- Filter page start -->
          <Export :selected="selectedCourses" :mode="'buying'"/> <!-- Filter page start -->
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

                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="buying in buyings.data" :key="buying.id" class="hover:bg-gray-100">
                    <td class="p-4">
                      <div class="flex items-center">
                        <img :src="'storage/' + buying.avatar" class="w-16 h-16 rounded-full object-cover"
                          alt="Course image">
                      </div>
                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ buying.name }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                      {{ buying.user_name }}
                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                      <span v-if="buying.status == 'payment_created'"
                        class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">PENDENTE</span>
                      <span v-if="buying.status == 'payment_confirmed'"
                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">PAGAMENTO
                        EFETUADO</span>

                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{
                      formatCurrency(buying.price) }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ new
                      Date(buying.created_at).toLocaleDateString('pt-BR') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </Layout>
</template>
