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
                            <p class="text-gray-700 break-words break-all whitespace-pre-line">
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
                    <router-link :to="`/rekrut/jasa/${selectedPackage.id}`" v-if="selectedPackage" class="w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  cursor-pointer">
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