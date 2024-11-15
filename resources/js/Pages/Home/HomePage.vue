<script setup>
import Layout from '../Layout.vue'
import Breadcrumb from '../Components/Breadcrumb.vue';

import CardData from './components/CardData.vue';
</script>

<template>
  <Layout>
    <div>
      <Breadcrumb title="Dashboard" />

      <section class="grid gap-6 md:grid-cols-4 max-w-9xl mx-auto w-full ">
        <CardData :title="'Total de cursos'" :value="'14'"/>
        
        <CardData :title="'Total de cursos'" :value="'14'"/>

        <CardData :title="'Total de cursos'" :value="'14'"/>

        <CardData :title="'Total de cursos'" :value="'14'"/>
      </section>

    </div>
  </Layout>
</template>
