<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    salons: Array
});

const salonId = ref();
const services = ref(null);

const progress = ref('salon');

const updateSalonId = (id) => {
    salonId.value = id;
}

const salonSelected = () => {
    progress.value = 'service';

    getServecesBySalonId();
}

async function getServecesBySalonId() {
    const response = await axios.get(`/api/service/${salonId.value}`)
    services.value = response.data
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

            <div v-if="progress === 'service'">
                <h2 class="mx-2 my-4 text-3xl">Select Service</h2>
                <div v-for="service in services" :key="service.id"
                    class="m-2 p-2 border border-slate-400 rounded-lg hover:bg-slate-500 transition ease-in-out duration-150"
                    >

                    <div>{{ service.name }}</div>
                    <!-- <div class="text-sm text-slate-400">{{ salon.address }}</div> -->
                </div>

                <PrimaryButton class="m-2 float-right" :disabled="!salonId" @click="salonSelected">
                    Next
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
