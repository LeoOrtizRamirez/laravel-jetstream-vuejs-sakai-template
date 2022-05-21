<template>
    <div>
        <div class="p-grid">
            <div class="p-col-12">
                <div class="grid">

                    <div class="col-12">
                        <div class="card">
                            <h5>Cliente</h5>
                            <form @submit.prevent="submit">
                                <div class="p-fluid formgrid grid">
                                    <div class="field col-12 md:col-6">
                                        <label for="name">Nombre</label>
                                        <InputText v-model="form.name" id="name" type="text" required/>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="document">Número de documento</label>
                                        <InputText v-model="form.document" id="document" type="text"/>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="phone">Teléfono</label>
                                        <InputText v-model="form.phone" id="phone" type="text"/>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="email">E-mail</label>
                                        <InputText v-model="form.email" id="email" type="email"/>
                                    </div>
                                    <div class="field col-12 md:col-6">
                                        <label for="address">Dirección</label>
                                        <InputText v-model="form.address" id="address" type="text"/>
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
import DataTable from "primevue/datatable";
import {FilterMatchMode} from "primevue/api";
import DatatableService from "../../Services/DatatableService";
import Menubar from "primevue/menubar";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import DeleteDialog from "../../Components/DeleteDialog";

export default {
    name: "Create",
    layout: AppLayout,
    components: {
        AppLayout,
        Button,
        InputText,
    },
    data() {
        return {
            form:{
                name:"",
                document:"",
                phone:"",
                email:"",
                address:""
            },
        }
    },
    mounted() {
    },
    methods: {
        submit(){
            this.$inertia.post(route('customers.store'),this.form);
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
import { Link } from '@inertiajs/inertia-vue3';

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
                                <JetLabel for="name" value="Nombre" />
                                <input-error :message="errors.name"/>
                                <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autocomplete="current-name"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="document" value="Número de documento" />
                                <input-error :message="errors.document"/>
                                <JetInput id="document" v-model="form.document" type="text" class="mt-1 block w-full" autocomplete="current-document"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="phone" value="Teléfono" />
                                <input-error :message="errors.phone"/>
                                <JetInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-full" autocomplete="current-phone"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="email" value="Email" />
                                <input-error :message="errors.email"/>
                                <JetInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" autocomplete="current-email"/>
                            </div>
                            <div class="mt-4">
                                <JetLabel for="address" value="Dirección" />
                                <input-error :message="errors.address"/>
                                <JetInput id="address" v-model="form.address" type="text" class="mt-1 block w-full" autocomplete="current-address"/>
                            </div>
                            <div class="mt-4">
                                <Link :href="route('customer.index')" class="btn btn-danger mr-2">Cancelar</Link>
                                <JetButton class="btn btn-primary" type="submit">Enviar</JetButton>
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
        errors: Object
    },
    data(){
        return{
            form:{
                name:"",
                document:"",
                phone:"",
                email:"",
                address:""
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
            Inertia.post(route('customer.store'),this.form);
        },
    }
}
</script>
-->