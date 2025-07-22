<template>
    <div class="text-center mt-10 pt-10">
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
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
        >
            <FreelancerCard
                v-for="f in freelancers"
                :key="f.id"
                :freelancer="f"
            />
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-10">
            <p class="text-gray-500">Tidak ada freelancer yang tersedia</p>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import CategoryButtons from "../components/CategoryButtons.vue";
import FreelancerCard from "../components/FreelancerCard.vue";
import SearchBar from "../components/SearchBar.vue";

import api from "../axios";

const freelancers = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchFreelancers = async () => {
    try {
        loading.value = true;
        error.value = null;

        const response = await api.get("/freelancer");

        if (response.data.code === 200) {
            freelancers.value = response.data.data;
        } else {
            throw new Error(
                response.data.message || "Gagal mengambil data freelancer"
            );
        }
    } catch (err) {
        error.value =
            err.response?.data?.message || err.message || "Terjadi kesalahan";
        console.error("Error fetching freelancers:", err);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchFreelancers();
});
</script>
