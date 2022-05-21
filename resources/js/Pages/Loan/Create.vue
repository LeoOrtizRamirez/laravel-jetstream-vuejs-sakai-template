<template>
    <div>
        <div class="p-grid">
            <div class="p-col-12">
                <div class="grid">

                    <div class="col-12">
                        <div class="card">
                            <h5>Prestamos</h5>
                            <form @submit.prevent="submit">
                                <div class="p-fluid formgrid grid">
                                    <div class="field col-12 md:col-6">
                                        <label for="name">Cliente</label>
                                        <select name="customer_id" id="customer_id" class="mt-1 block w-full" v-model="form.customer_id" required>
                                            <option value="">Selecciona un cliente</option>
                                            <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{customer.name}}</option>
                                        </select>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="amount">Valor</label>
                                        <InputText v-model="form.amount" id="amount" type="number" @change="getBalance" required/>
                                    </div>
                                    
                                    <div class="field col-12 md:col-6">
                                        <label for="interest">Interes</label>
                                        <select name="interest" id="interest" class="mt-1 block w-full" v-model="form.interest" @change="getBalance" required>
                                            <option value="">Selecciona un Interes</option>
                                            <option value="5">5%</option>
                                            <option value="10">10%</option>
                                            <option value="15">15%</option>
                                            <option value="20">20%</option>
                                        </select>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="balance">Saldo</label>
                                        <InputText v-model="form.balance" id="balance" type="balance" disabled/>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="total_fee">Cuotas</label>
                                        <InputText v-model="form.total_fee" id="total_fee" type="total_fee" required/>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="way_to_pay">Forma de Pago</label>
                                        <select name="way_to_pay" id="way_to_pay" class="mt-1 block w-full" v-model="form.way_to_pay" required>
                                            <option value="">Selecciona una Forma de Pago</option>
                                            <option value="1">Diario</option>
                                            <option value="7">Semanal</option>
                                            <option value="15">Quincenal</option>
                                            <option value="30">Mensual</option>
                                        </select>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="payment_date">Fecha del primer pago</label>
                                        <InputText v-model="form.payment_date" id="payment_date" type="date" required/>
                                    </div>
                                    <Button label="Submit" type="submit"></Button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

export default {
    name: "Create",
    layout: AppLayout,
    components: {
        AppLayout,
        Button,
        InputText,
    },
    props:{
        errors: Object,
        customers:[],
    },
    data() {
        return {
            form:{
                user_id:"",
                customer_id:"",
                amount:"",
                interest:"",
                balance:"",
                total_fee:"",
                way_to_pay:"",
                payment_date:""
            },
            
        }
    },
    mounted() {
    },
    methods: {
        submit(){
            this.$inertia.post(route('loans.store'),this.form);
        },
        getBalance:function(){
            var amount = parseInt(this.form.amount)
            var interest = parseInt(this.form.interest)
            this.form.balance = amount + (amount * interest / 100)
        },
    }
}
</script>

<style scoped>

</style>


<!--
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from "@inertiajs/inertia";

import InputError from "@/Jetstream/InputError";
import JetInput from '@/Jetstream/Input';
import JetLabel from '@/Jetstream/Label';
import JetButton from '@/Jetstream/Button';

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cliente
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mt-4">
                                <JetLabel for="customer_id" value="Cliente" />
                                <input-error :message="errors.customer_id"/>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full" v-model="form.customer_id">
                                    <option value="">Selecciona un cliente</option>
                                    <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{customer.name}}</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="user_id" value="Usuario" />
                                <input-error :message="errors.user_id"/>
                                <select name="user_id" id="user_id" class="mt-1 block w-full" v-model="form.user_id">
                                    <option value="">Selecciona un usuario</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="amount" value="Monto" />
                                <input-error :message="errors.amount"/>
                                <JetInput id="amount" v-model="form.amount" @change="getBalance" type="number" class="mt-1 block w-full" required autocomplete="current-amount"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="interest" value="Interes" />
                                <input-error :message="errors.interest"/>
                                <select name="interest" id="interest" class="mt-1 block w-full" v-model="form.interest" @change="getBalance">
                                    <option value="">Selecciona un Interes</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                    <option value="15">15%</option>
                                    <option value="20">20%</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="balance" value="Saldo" />
                                <input-error :message="errors.balance"/>
                                <JetInput id="balance" v-model="form.balance" type="number" class="mt-1 block w-full" required autocomplete="current-balance"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="total_fee" value="Cuotas" />
                                <input-error :message="errors.total_fee"/>
                                <JetInput id="total_fee" v-model="form.total_fee" type="number" class="mt-1 block w-full" required autocomplete="current-total_fee"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="way_to_pay" value="Forma de pago" />
                                <input-error :message="errors.way_to_pay"/>
                                <select name="way_to_pay" id="way_to_pay" class="mt-1 block w-full" v-model="form.way_to_pay">
                                    <option value="">Selecciona una Forma de Pago</option>
                                    <option value="1">Diario</option>
                                    <option value="7">Semanal</option>
                                    <option value="15">Quincenal</option>
                                    <option value="30">Mensual</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="payment_date" value="Fecha del primer pago" />
                                <input-error :message="errors.payment_date"/>
                                <JetInput id="payment_date" v-model="form.payment_date" type="date" class="mt-1 block w-full" required autocomplete="current-payment_date"/>
                            </div>
                            <div class="mt-4">
                                <JetButton class="mt-4" type="submit">Enviar</JetButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    props:{
        errors: Object,
        customers:[],
        users:[]
    },
    data(){
        return{
            form:{
                user_id:"",
                customer_id:"",
                amount:0,
                interest:0,
                balance:0,
                total_fee:"",
                way_to_pay:"",
                payment_date:""
            },
        };
    },
    components:{
        AppLayout,
        InputError,
        JetInput,
        JetLabel,
        JetButton
    },
    methods:{
        submit(){
            Inertia.post(route('loan.store'),this.form);
        },
        getBalance:function(){
            var amount = parseInt(this.form.amount)
            var interest = parseInt(this.form.interest)
            this.form.balance = amount + (amount * interest / 100)
        },
    }
}
</script>
-->