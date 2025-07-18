<script setup lang="ts">
import FreelancerCard from "../components/FreelancerCard.vue";
import SearchBar from "../components/SearchBar.vue";
</script>

<template>
    <div class="text-center mt-10 pt-10">
        <h2 class="text-3xl font-bold text-blue-600 mt-10">
            Welcome to FreelanceFinder
        </h2>
        <p class="mt-2 text-gray-700">
            Find the best freelancers for your project.
        </p>

        <SearchBar />
        <FreelancerCard />
    </div>
</template>
