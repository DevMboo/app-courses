<script setup>
import { Head } from '@inertiajs/vue3';

import Layout from '../Layout.vue'
import Breadcrumb from '../Components/Breadcrumb.vue';

const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};

defineProps({ buying: Object, myBuyings: Object })
</script>

<template>
    <Layout>
        <Head title="Minhas inscrições" />
        <div>
            <Breadcrumb title="Minhas inscrições" />

            <div v-if="$page.props.flash.message"
                class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md rounded-t-lg mt-3">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                        </svg></div>
                    <div>
                        <p class="font-bold">Salvo</p>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-2 divide-x">
                <div class="col-span-4">
                    <div class="max-w-md mx-auto p-4 bg-white shadow-md rounded-lg" v-if="buying">

                        <div class="text-center mb-4">
                            <h1 class="text-xl font-semibold text-gray-800">Detalhes do Pagamento</h1>
                            <p class="text-sm text-gray-500">Verifique as informações abaixo</p>
                        </div>

                        <div class="flex justify-center mb-4">
                            <img :src="'data:image/png;base64,' + buying.pix_qr_code_url" alt="QR Code"
                                class="w-32 h-32 object-contain">
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Produto adquirido:</span>
                                <span class="text-gray-800">{{ buying.course.title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">CPF:</span>
                                <span class="text-gray-800">{{ buying.cpf }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Preço a Ser Pago:</span>
                                <span class="text-gray-800">{{ formatCurrency(buying.price) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Data de Validade:</span>
                                <span class="text-gray-800">1 dia após o pedido ser realizado</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Status:</span>
                                <span v-if="buying.status == 'payment_created'" class="text-yellow-800 font-semibold">Pendente</span>
                                <span v-if="buying.status == 'payment_confirmed'" class="text-green-800 font-semibold">Pagamento efetuado</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Valor Total:</span>
                                <span class="text-gray-800">{{ formatCurrency(buying.price) }}</span>
                            </div>
                        </div>

                        <div
                            class="bg-yellow-100 border-t-4 border-yellow-500 rounded-b text-yellow-900 px-4 py-3 shadow-md rounded-t-lg mt-3 mb-2">
                            <div class="flex">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-yellow-500 mr-4"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                    </svg></div>
                                <div>
                                    <p class="font-bold">Atenção</p>
                                    <p class="text-sm">O QR Code apresentado abaixo é gerado pelo banco ASAAS e contém
                                        dados de
                                        ambiente SANDBOX, ou seja, são informações fictícias destinadas exclusivamente
                                        para
                                        testes e homologação. Portanto, ao escanear este QR Code, ele não representará
                                        um
                                        pagamento válido de Pix, mas sim uma simulação de transação.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-md mx-auto p-4" v-if="!buying">
                        <img :src="'images/payment.svg'" alt="Not found submit">
                        <p class="text-center font-thin">Nenhuma compra em aberto no momento...</p>
                    </div>
                </div>

                <div class="col-span-8">
                    <!-- This table component -->
                    <div class="flex flex-col mt-3 px-2">
                        <h1 class="mb-2 font-semibold text-lg">Meus cursos inscritos</h1>
                        <div class="overflow-x-auto sm:rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden ">
                                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                        <thead class="bg-neutral-800">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-neutral-200 uppercase ">
                                                    Curso
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
                                                    Data do pedido
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="myBuying in myBuyings.data" :key="myBuying.id" class="hover:bg-gray-100">
                                                <td class="p-4">
                                                    <div class="flex items-center">
                                                        <img :src="'storage/'+myBuying.avatar" class="w-16 h-16 rounded-full object-cover" alt="Course image">
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ myBuying.name }}</td>
                                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    <span v-if="myBuying.status == 'payment_created'" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">PENDENTE</span>
                                                    <span v-if="myBuying.status == 'payment_confirmed'" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">PAGAMENTO EFETUADO</span>
                                             
                                                </td>
                                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ formatCurrency(myBuying.price) }}</td>
                                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ new Date(myBuying.created_at).toLocaleDateString('pt-BR') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>