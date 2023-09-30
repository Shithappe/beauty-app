<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import moment from 'moment';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

defineProps({
    salons: Array
});

const today = moment().format('YYYY-MM-DD');

const salonId = ref();
const services = ref(null);
const serviceId = ref(null);

const progress = ref('salon');
const date = ref();
const availableTime = ref();
const time = ref();

const username = ref('');
const phone = ref('');


const updateSalonId = (id) => {
    salonId.value = id;
}
const updateServiceId = (id) => {
    serviceId.value = id;
}


const salonSelected = () => {
    progress.value = 'service';
    getServecesBySalonId();
}

const serviceSelected = () => {
    progress.value = 'date';
}

const dataSelected = () => {
    progress.value = 'time';
    getAvailableRecords();
}

const timeSelected = (valueTime) => {
    time.value = valueTime;
    progress.value = 'send';
}

const sendData = () => {
    console.log(username.value + ' ' + phone.value);

    axios.post('/api/record', {
        username: username.value,
        phone: phone.value,
        salon_id: salonId.value,
        service_id: serviceId.value,
        date: date.value,
        time: time.value,
    })
        .then(function (response) {
            console.log(response.data);
            progress.value = 'done';
        })
        .catch(function (error) {
            console.log(error);
        });
}

const goToBack = () => {
    salonId.value = null;
    services.value = null;
    serviceId.valuenull = null;
    progress.value = 'salon';
    date.value = null;
    availableTime.value = null;
    time.value = null;
    username.value = '';
    phone.value = '';
}


async function getServecesBySalonId() {
    const response = await axios.get(`/api/service/${salonId.value}`)
    services.value = response.data
}

async function getAvailableRecords() {
    const response = await axios.get(`/api/available-records/${serviceId.value}/${date.value}`)
    availableTime.value = response.data;
}


</script>

<template>
    <Head title="Welcome" />

    <div
        class="sm:flex sm:justify-center sm:items-center text-white min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="w-1/3">

            <div v-if="progress === 'salon'">
                <h2 class="mx-2 my-4 text-3xl">Select Salon</h2>
                <div v-for="salon in salons" :key="salons.id" @click="updateSalonId(salon.id)"
                    class="m-2 p-2 border border-slate-400 rounded-lg hover:bg-slate-500 transition ease-in-out duration-150"
                    :class="{ 'bg-slate-600': salon.id === salonId }">

                    <div>{{ salon.name }}</div>
                    <div class="text-sm text-slate-400">{{ salon.address }}</div>
                </div>

                <PrimaryButton class="m-2 float-right" :disabled="!salonId" @click="salonSelected">
                    Next
                </PrimaryButton>
            </div>

            <div v-if="progress === 'service'" class="animate-fade-in-right">
                <h2 class="mx-2 my-4 text-3xl">Select Service</h2>
                <div v-for="service in services" :key="service.id" @click="updateServiceId(service.id)"
                    class="m-2 p-2 border border-slate-400 rounded-lg hover:bg-slate-500 transition ease-in-out duration-150"
                    :class="{ 'bg-slate-600': service.id === serviceId }">

                    <div>{{ service.name }}</div>
                </div>

                <PrimaryButton class="m-2 float-right" :disabled="!salonId" @click="serviceSelected">
                    Next
                </PrimaryButton>
            </div>

            <div v-if="progress === 'date'">
                <h2 class="my-4 text-3xl">Select Date</h2>

                <VueCtkDateTimePicker v-model="date" format="YYYY-MM-DD" :inline=true :only-date=true :min-date=today
                    :no-weekends-days=true :dark=true :no-button=true />

                <PrimaryButton class="my-4 float-right" :disabled="!date" @click="dataSelected">
                    Next
                </PrimaryButton>
            </div>

            <div v-if="progress === 'time'">
                <h2 class="mx-2 my-4 text-3xl">Select Service</h2>
                <div v-for="time in availableTime" :key="time" @click="timeSelected(time)"
                    class="m-2 p-2 border border-slate-400 rounded-lg hover:bg-slate-500 transition ease-in-out duration-150">
                    <div>{{ time }}</div>
                </div>
            </div>

            <div v-if="progress === 'send'">
                <h2 class="my-4 text-3xl">Info about You</h2>
                <TextInput v-model="username" :placeholder="'Enter Name'" />
                <TextInput v-model="phone" :placeholder="'Enter Phone'" />
                <PrimaryButton class="my-4 float-right" @click="sendData">
                    Done
                </PrimaryButton>
            </div>

            <div v-if="progress === 'done'">
                <div>Date: {{ moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY') }} {{ time }}</div>
                <div>Address: {{ salons.find(item => item.id === salonId).address }}</div>
                <div>Service: {{ services.find(item => item.id === serviceId).name }}</div>
                <PrimaryButton class="my-4 float-right" @click="goToBack">
                    Done
                </PrimaryButton>
            </div>
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
