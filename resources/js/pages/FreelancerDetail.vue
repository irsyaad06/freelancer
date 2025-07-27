<template>
    <div class="max-w-screen-xl mx-auto p-4 mt-10 pt-10 mb-10">
        <div>
            <div class="flex">
                <span class="text-3xl mr-2 font-semibold">{{ freelancerDetail?.kategori || 'Desain' }}</span>
                <span class="text-3xl font-semibold">{{ freelancerDetail?.subkategori || 'Logo' }}</span>
            </div>
        </div>

        <div class="mt-3 mb-3">
            <Avatar :freelancer="freelancerDetail?.freelancer || { name: 'Loading...', profile_photo: null }" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="col-span-3 flex flex-col gap-4">
                <div>
                    <Carousel :photos="freelancerDetail?.freelancer?.photos || []" />
                </div>
                <div id="default-styled-tab-content">
                    <span class="text-2xl font-semibold p-2">Detail Services</span>
                    <div class="p-2">
                        <div v-if="selectedPackage">
                            <p class="text-gray-700">
                                {{ selectedPackage.description }}
                            </p>
                        </div>
                        <div v-else>
                            <p class="text-gray-500">Pilih paket untuk melihat deskripsi detail</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <div>
                    <Tabs :service-packages="freelancerDetail?.servicePackages || []" @package-selected="handlePackageSelection" />
                </div>
                <div class="mt-2 pl-3 w-full flex items-end">
                    <router-link :to="`/rekrut/jasa/${selectedPackage.id}`" v-if="selectedPackage" class="w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
                        Rekrut
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';
import { useFreelancerStore } from '../stores/freelancerStore';
import Avatar from "../components/Avatar.vue";
import Carousel from "../components/Carousel.vue";
import Tabs from "../components/Tabs.vue";

const route = useRoute();
const freelancerStore = useFreelancerStore();

const { freelancerDetail, loading, error } = storeToRefs(freelancerStore);
const selectedPackage = ref(null);

const handlePackageSelection = (pkg) => {
    selectedPackage.value = pkg;
};

onMounted(() => {
    const { subcategoryId, freelancerId } = route.params;
    if (subcategoryId && freelancerId) {
        freelancerStore.fetchFreelancerDetail(subcategoryId, freelancerId);
    }
});

// Watch for changes in freelancerDetail to set default package
import { watch } from 'vue';
watch(() => freelancerDetail.value, (newDetail) => {
    if (newDetail?.servicePackages?.length > 0) {
        selectedPackage.value = newDetail.servicePackages[0];
    }
}, { immediate: true });
</script>



    <!-- <div class="container mx-auto p-4 mt-10 pt-10">

        <div v-if="loading" class="flex justify-center items-center py-10">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        </div>


        <div v-else-if="error" class="text-center py-10">
            <p class="text-red-500">{{ error }}</p>
        </div>


        <div v-else-if="freelancerDetail" class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">

            <div class="text-sm text-gray-500 mb-4">
                {{ freelancerDetail.kategori }} > {{ freelancerDetail.subkategori }}
            </div>


            <div class="flex items-center mb-6">
                <img :src="getProfilePhotoUrl(freelancerDetail.freelancer.profile_photo)" :alt="freelancerDetail.freelancer.name" class="w-24 h-24 rounded-full object-cover mr-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ freelancerDetail.freelancer.name }}</h1>
                    <div class="flex items-center mt-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <span class="text-gray-600 text-lg ml-1">{{ freelancerDetail.freelancer.rating }}</span>
                        <span class="text-gray-500 ml-4">• {{ freelancerDetail.freelancer.is_verified }}</span>
                    </div>
                </div>
            </div>


            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Paket Jasa</h2>
                <div v-if="freelancerDetail.servicePackages.length > 0" class="space-y-4">
                    <div v-for="pkg in freelancerDetail.servicePackages" :key="pkg.id" class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <h3 class="text-xl font-bold text-blue-600">{{ pkg.name }}</h3>
                        <p class="text-gray-600 mt-2">{{ pkg.description }}</p>
                        <div class="mt-4">
                            <h4 class="font-semibold text-gray-800">Layanan yang termasuk:</h4>
                            <ul class="list-disc list-inside mt-2 text-gray-600">
                                <li v-for="service in pkg.services" :key="service.id">
                                    {{ service.name }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-gray-500">Tidak ada paket jasa yang tersedia.</p>
                </div>
            </div>
        </div>
    </div> -->
