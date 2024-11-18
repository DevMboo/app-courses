<script setup>
import Layout from '../Layout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

const { props } = usePage()
const isAuthenticated = props.auth.user

</script>


<template>
    <Layout>
        <Head title="Home" />
        <div class="w-full min-h-screen">
            <div class="flex flex-col justify-center items-center bg-white h-[100vh]">
                <div class="w-full max-w-[560px] min-h-[450px] flex justify-center items-center flex-col space-y-2">
                    <div class="mx-auto mt-3 bg-neutral-500 w-20 h-20 flex justify-center items-center rounded-full">
                        <img :src="'images/courses.webp'" class="w-16 h-16" alt="Ico application">
                    </div>
                    <h1 class="text-center text-3xl">Bem vindo ao APP @Marcasite cursos</h1>
                    <Link href="/login" v-if="!isAuthenticated" class="w-[240px] py-2 px-2 bg-indigo-600 text-white font-semibold text-center rounded-lg mt-3">Entrar com minha conta</Link>
                    <Link href="/showcase" v-if="isAuthenticated" class="w-[240px] py-2 px-2 bg-indigo-600 text-white font-semibold text-center rounded-lg mt-3">Conheça nossos principais cursos</Link>
                </div>
            </div>
        </div>
    </Layout>
</template>