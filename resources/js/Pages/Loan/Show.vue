<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from "@inertiajs/inertia";
import JetLabel from '@/Jetstream/Label';

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cuotas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="p-3">Cuota</th>
                                    <th class="p-3">Valor</th>
                                    <th class="p">Fecha de pago</th>
                                    <th class="p-3">Estado</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="p in payments" :key="p.id">
                                    <td class="p-3 border">{{ p.fee }}</td>
                                    <td class="p-3 border">{{ new Intl.NumberFormat('en-US').format(p.amount) }}</td>
                                    <td class="p-3 border">{{  dateFormat(p.payment_date) }}</td>
                                    <td class="p-3 border">{{ p.status.name }}</td>
                                    <td class="p-3 border">
                                        <button @click="setPayment(p.id)" v-if="p.status_id != 2" class="btn btn-primary mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="p-3 border">Total</th>
                                    <th class="p-3 border">{{ new Intl.NumberFormat('en-US').format(total) }}</th>
                                    <th class="p-3 border" colspan="3"></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </AppLayout>
</template>
<script>
export default {
    props:{
        payments:[],
        total: 0,
    },
    components:{
        AppLayout,
        JetLabel
    },
    methods:{
        dateFormat(date){
            const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            const d = new Date(date)
            const month = months[d.getMonth()];
            return  d.getDate() + " de " + month + " " + d.getFullYear()
        },
        setPayment(id){
            Inertia.post(route('payment.store',[id,'show']))
        }
    }
}
</script>
