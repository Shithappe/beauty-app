<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import moment from 'moment';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

const props = defineProps({
    firstsalons: Array
});

const salons = ref();
const services = ref();
const records = ref();

salons.value = props.firstsalons;

const select = ref('salon');
const data = ref(null);

const newSalon = ref({
    name: '',
    address: ''
})

const newService = ref({
    name: '',
    is_avalible: '',
    salon_id: ''
})


const changeSelect = (value) => {
    switch (value) {
        case 'salon': getSalons(); break;
        case 'service': getServices(); break;
        case 'record': getRecords(); break;

        default:  break;
    }
    select.value = value;
}

async function getSalons() {
    axios.get('/api/salon')
        .then(function (response) {
            console.log(response.data);

            salons.value = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
}

async function createSalon() {
    axios.post('/api/salon', {
        name: newSalon.value.name,
        address: newSalon.value.address
    })
        .then(function (response) {
            console.log(response.data);

            newSalon.value.name = '';
            newSalon.value.address = '';

            getSalons();
        })
        .catch(function (error) {
            console.log(error);
        });
}

async function deleteSalons(id) {
    axios.delete(`/api/salon/${id}`)
        .then(function (response) {
            console.log(response.data);
            getSalons();
        })
        .catch(function (error) {
            console.log(error);
        });
}

async function getServices() {
    axios.get('/api/service')
        .then(function (response) {
            console.log(response.data);

            services.value = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
}

async function createService() {
    axios.post('/api/service', {
        name: newService.value.name,
        is_avalible: newService.value.is_avalible,
        salon_id: newService.value.salon_id
    })
        .then(function (response) {
            console.log(response.data);

            newService.value.name = '';
            newService.value.is_avalible = '';
            newService.value.salon_id = '';

            getServices();
        })
        .catch(function (error) {
            console.log(error);
        });
}

async function deleteService(id) {
    axios.delete(`/api/service/${id}`)
        .then(function (response) {
            console.log(response.data);
            getServices();
        })
        .catch(function (error) {
            console.log(error);
        });
}


async function getRecords() {
    axios.get('/api/record')
        .then(function (response) {
            console.log(response.data);

            records.value = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
}

async function deleteRecord(id) {
    axios.delete(`/api/record/${id}`)
        .then(function (response) {
            console.log(response.data);
            getRecords();
        })
        .catch(function (error) {
            console.log(error);
        });
}

</script>

<template>
    <Head title="Admin" />


    <div class="text-white min-h-screen w-full bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="flex justify-center items-stretch">
            <button class="m-2 p-2 px-4 text-lg bg-slate-700 rounded-lg"
                :class="{ 'bg-slate-500 outline': select === 'salon' }" @click="changeSelect('salon')">Salons</button>
            <button class="m-2 p-2 px-4 text-lg bg-slate-700 rounded-lg"
                :class="{ 'bg-slate-500 outline': select === 'service' }" @click="changeSelect('service')">Services</button>
            <button class="m-2 p-2 px-4 text-lg bg-slate-700 rounded-lg"
                :class="{ 'bg-slate-500 outline': select === 'record' }" @click="changeSelect('record')">Records</button>
        </div>

        <div class="p-4">

            <table v-if="select === 'salon'" class="table-auto w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="pl-6 py-2 text-left">Name</th>
                        <th class="pl-6 py-2 text-left">Address</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="border-b"></td> 
                        <td class="px-4 py-2 border-b"><TextInput v-model="newSalon.name" placeholder="Name" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="newSalon.address" placeholder="Address" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b space-x-1">
                            <PrimaryButton @click="createSalon">Create</PrimaryButton>
                        </td>
                    </tr>
                    <tr v-for="salon in salons">
                        <td class="px-4 py-2 border-b">{{ salon.id }}</td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="salon.name" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="salon.address" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b space-x-1">
                            <PrimaryButton>Update</PrimaryButton>
                            <PrimaryButton @click="deleteSalons(salon.id)">Delete</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table v-else-if="select === 'service'" class="table-auto w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="pl-6 py-2 text-left">Name</th>
                        <th class="pl-6 py-2 text-left">Is Avalible</th>
                        <th class="pl-6 py-2 text-left">Salon ID</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="border-b"></td> 
                        <td class="px-4 py-2 border-b"><TextInput v-model="newService.name" placeholder="Name" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="newService.is_avalible" placeholder="Is Avalible" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="newService.salon_id" placeholder="Salon ID (tempolary)" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b space-x-1">
                            <PrimaryButton @click="createService">Create</PrimaryButton>
                        </td>
                    </tr>
                    <tr v-for="service in services">
                        <td class="px-4 py-2 border-b">{{ service.id }}</td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="service.name" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="service.is_avalible" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="service.salon_id" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b space-x-1">
                            <PrimaryButton>Update</PrimaryButton>
                            <PrimaryButton @click="deleteService(service.id)">Delete</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table v-else-if="select === 'record'" class="table-auto w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="pl-6 py-2 text-left">Date</th>
                        <th class="pl-6 py-2 text-left">Time</th>
                        <th class="px-4 py-2 text-left">Username</th>
                        <th class="px-4 py-2 text-left">Phone</th>
                        <th class="px-4 py-2 text-left">Salon ID</th>
                        <th class="px-4 py-2 text-left">Service ID</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- <tr>
                        <td class="border-b"></td> 
                        <td class="px-4 py-2 border-b"><TextInput v-model="newSalon.name" placeholder="Name" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b"><TextInput v-model="newSalon.address" placeholder="Address" class="w-min text-white bg-transparent border-none focus:text-black" /></td>
                        <td class="px-4 py-2 border-b space-x-1">
                            <PrimaryButton @click="createSalon">Create</PrimaryButton>
                        </td>
                    </tr> -->
                    <tr v-for="record in records">
                        <td class="px-4 py-2 border-b">{{ record.id }}</td>
                        <td class="px-4 py-2 border-b">{{ record.date }}</td>
                        <td class="px-4 py-2 border-b">{{ record.time }}</td>
                        <td class="px-4 py-2 border-b">{{ record.username }}</td>
                        <td class="px-4 py-2 border-b">{{ record.phone }}</td>
                        <td class="px-4 py-2 border-b">{{ record.salon_id }}</td>
                        <td class="px-4 py-2 border-b">{{ record.service_id }}</td>
                        <td class="px-4 py-2 border-b space-x-1">
                            <!-- <PrimaryButton>Update</PrimaryButton> -->
                            <PrimaryButton @click="deleteRecord(record.id)">Delete</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
