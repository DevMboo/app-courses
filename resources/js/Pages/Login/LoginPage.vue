<script setup>
import Layout from '../Layout.vue'
import { useForm, Head } from '@inertiajs/vue3'

const form = useForm({
  email: null,
  password: null,
})
</script>

<template>
    <Layout>
        <Head title="Login" />
        <div class="w-full min-h-screen">
            <div class="flex flex-col justify-center items-center bg-white h-[100vh]">
                <div
                class="mx-auto flex w-full flex-col justify-center px-5 pt-0 md:h-[unset] md:max-w-[50%] lg:h-[100vh] min-h-[100vh] lg:max-w-[50%] lg:px-6">
                    <div
                        class="my-auto mb-auto mt-8 flex flex-col md:mt-[70px] w-[350px] max-w-[450px] mx-auto md:max-w-[450px] lg:mt-[130px] lg:max-w-[450px]">
                        <div class="mx-auto mt-3 bg-neutral-500 w-20 h-20 flex justify-center items-center rounded-full">
                            <img :src="'images/courses.webp'" class="w-16 h-16" alt="Ico application">
                        </div>
                        <p class="text-[32px] font-bold text-zinc-950">Login</p>
                        <p class="mb-2.5 mt-2.5 font-normal text-zinc-950">Entra com seu E-mail e
                            Senha</p>
                        
                        <div class="relative my-4">
                            <div class="relative flex items-center py-1">
                                <div class="grow border-t border-zinc-200 dark:border-zinc-700"></div>
                                <div class="grow border-t border-zinc-200 dark:border-zinc-700"></div>
                            </div>
                        </div>
                        <div>
                            <form class="mb-4" @submit.prevent="form.post('/login')">
                                <div class="grid gap-2">
                                    <div class="grid gap-1">
                                        <label class="text-zinc-950" for="email">Email</label>
                                        <input
                                            class="mr-2.5 mb-2 h-full min-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600"
                                            id="email" placeholder="name@example.com" type="email" autocapitalize="none"
                                            autocomplete="email" autocorrect="off" name="email" v-model="form.email">
                                        <div class="text-red-600 text-xs" v-if="form.errors.email">{{ form.errors.email }}</div>    

                                        <label
                                            class="text-zinc-950 mt-2" for="password">Password</label>
                                        <input
                                            id="password" placeholder="Password" type="password"
                                            autocomplete="current-password"
                                            class="mr-2.5 mb-2 h-full min-h-[44px] w-full rounded-lg border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-950 placeholder:text-zinc-400 focus:outline-0 focus:ring-2 ring-blue-600"
                                            name="password" v-model="form.password">
                                        <div class="text-red-600 text-xs" v-if="form.errors.password">{{ form.errors.password }}</div>

                                    </div>

                                    <button
                                        class="whitespace-nowrap ring-offset-background bg-neutral-800 text-neutral-400 hover:bg-neutral-950 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 mt-2 flex h-[unset] w-full items-center justify-center rounded-lg px-4 py-4 text-sm font-medium"
                                        type="submit">Entrar na minha conta</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
