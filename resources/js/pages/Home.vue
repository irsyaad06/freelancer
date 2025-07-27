<template>
    <div class="text-center mt-10 pt-10 mb-10 pb-10">
        <h2 class="text-3xl font-bold text-blue-600 mt-10">
            Welcome to FindLancer
        </h2>
        <p class="mt-2 text-gray-700">
            Find the best freelancers for your project.
        </p>

        <SearchBar />
        <div class="p-8">
            <CategoryButtons />
        </div>
        <div v-if="selectedSubcategory" class="text-gray-800">
            Jasa yang di pilih :
            <span class="text-blue-600 bg-transparent border-1 border-blue-700 rounded-md p-2">{{ selectedSubcategory.name }}</span>
        </div>
        <div v-if="loading" class="flex justify-center items-center py-10">
            <div
                class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
            ></div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="text-center py-10">
            <p class="text-red-500">{{ error }}</p>
            <button
                @click="fetchFreelancers"
                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded"
            >
                Coba Lagi
            </button>
        </div>

        <!-- Data State -->
        <div
            v-else-if="freelancers.length > 0"
            class="max-w-screen-xl flex mx-auto p-4"
        >
            <FreelancerCard
                v-for="f in freelancers"
                :key="f.id"
                :freelancer="f"
                :selectedSubcategory="selectedSubcategory"
            />
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-10 mt-10">
            <p class="text-gray-500">Tidak ada freelancer yang tersedia</p>
        </div>
    </div>
</template>
<script setup>
import { onMounted } from "vue";
import { storeToRefs } from "pinia";
import { useFreelancerStore } from "../stores/freelancerStore";
import CategoryButtons from "../components/CategoryButtons.vue";
import FreelancerCard from "../components/FreelancerCard.vue";
import SearchBar from "../components/SearchBar.vue";

const freelancerStore = useFreelancerStore();
const { freelancers, loading, error, selectedSubcategory } =
    storeToRefs(freelancerStore);

const fetchFreelancers = () => {
    freelancerStore.fetchFreelancers();
};

onMounted(() => {
    fetchFreelancers();
});
</script>
