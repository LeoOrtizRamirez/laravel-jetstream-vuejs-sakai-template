<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";

import JetDialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";

</script>

<template>
    <AppLayout title="Inversiones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inversiones
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200 overflow-x-auto">
                        <Link v-permission="'investment.create'" :href="route('investment.create')" class="btn btn-sm btn-primary mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </Link>
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="p-3">Usuario</th>
                                    <th class="p-3">Valor</th>
                                    <th class="p-3">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="i in investments" :key="i.id">
                                    <td class="p-3 border">{{ i.user.name }}</td>
                                    <td class="p-3 border">{{ new Intl.NumberFormat('en-US').format(i.amount) }}</td>
                                    <td class="p-3 border">{{ dateFormat(i.created_at) }}</td>
                                    <td class="p-3 border">
                                        <Link v-permission="'investment.edit'" :href="route('investment.edit', { investment: i})" class="btn btn-sm btn-success mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </Link>
                                        <button v-permission="'investment.destroy'" @click="modalOpen=true;selectInvestment=i" class="btn btn-sm btn-danger mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <div class="row">
                            <div class="col text-center">
                                <h2>Balance</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Inversiones</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ new Intl.NumberFormat('en-US').format(investment) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Prestamos</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ new Intl.NumberFormat('en-US').format(loans) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Ganancia</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ new Intl.NumberFormat('en-US').format(gain) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <h2>Caja</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4"></div>
                            <div class="col-md-4 col-md-offset-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Saldo actual</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ new Intl.NumberFormat('en-US').format(investment - loans) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-4"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


        


    <jet-dialog-modal :show="modalOpen">
        <template v-slot:title>
            <h1>Eliminar Inversión</h1>
        </template> 
        <template v-slot:content>
            <p v-if="selectInvestment">¿Seguro que quieres eliminar la inversión?</p>
        </template> 
        <template v-slot:footer>
            <jet-button @click="modalOpen=false">Cerrar</jet-button>
            <jet-button class="bg-red-500 hover:bg-red-800" @click="deleteInvestment()">Eliminar</jet-button>
        </template>    
    </jet-dialog-modal> 



    </AppLayout>
</template>
<script>

export default {
    props:{
        investments:[],
        investment:0,
        loans:0,
        gain:0
    },
    data(){
        return{
            modalOpen:false,
            selectInvestment:Object
        }
    },
    components:{
        AppLayout,
        Link,
        JetDialogModal,
        JetButton
    },
    methods:{
        deleteInvestment: function(){
            //if(!confirm("¿Seguro que quieres eliminar el usuario?"));
            Inertia.delete(route("investment.destroy", {investment : this.selectInvestment}))
            this.modalOpen = false
        },
        dateFormat(date){
            const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            const d = new Date(date)
            const month = months[d.getMonth()];
            return  d.getDate() + " de " + month + " " + d.getFullYear()
        }
    }
}
</script>
