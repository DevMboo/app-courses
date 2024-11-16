<script setup>
import Layout from '../Layout.vue'
import Breadcrumb from '../Components/Breadcrumb.vue';

import CardData from './components/CardData.vue';

defineProps({ totals: Object })
</script>

<template>
  <Layout>
    <div>
      <Breadcrumb title="Dashboard" />

      <section class="grid gap-6 md:grid-cols-4 max-w-9xl mx-auto w-full mt-2">
        <CardData :title="'Total de cursos'" :value="totals.courses" />

        <CardData :title="'Total de alunos'" :value="totals.students" />

        <CardData :title="'Total de administradores'" :value="totals.admin" />

        <CardData :title="'Lucro total'" :value="'14'" />
      </section>

      <!-- This table component -->
      <div class="flex flex-col mt-3">
        <hr>
        <h1 class="mb-2 font-semibold text-lg">Lista de inscrições</h1>
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
                        Curso
                      </th>
                      <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase">
                        Aluno
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
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </Layout>
</template>
