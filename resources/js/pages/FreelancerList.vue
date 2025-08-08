<template>
  <div class="mt-10 pt-10 px-4">
    <h2 class="text-2xl font-bold mb-6">{{ title }}</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 gap-y-6">
      <FreelancerCard v-for="f in freelancers" :key="f.id" :freelancer="f" />
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import axios from '@/axios';
import FreelancerCard from '../components/FreelancerCard.vue';

const route = useRoute();
const freelancers = ref([]);
const title = ref('Freelancers');

const fetchFreelancers = async () => {
    try {
        let url;
        const { subcategory_id, search } = route.query;

        if (subcategory_id) {
            url = `/api/freelancer/subkategori/${subcategory_id}`;
            try {
                const subcatResponse = await axios.get(`/api/subkategori/${subcategory_id}`);
                if (subcatResponse.data.data) {
                    title.value = `Freelancers for ${subcatResponse.data.data.name}`;
                }
            } catch (e) {
                title.value = 'Freelancers in selected category';
            }
        } else if (search) {
            url = `/api/freelancer?search=${search}`;
            title.value = `Search results for "${search}"`;
        } else {
            url = '/api/freelancer';
            title.value = 'All Freelancers';
        }

        const response = await axios.get(url);
        freelancers.value = response.data.data;
    } catch (error) {
        console.error('Error fetching freelancers:', error);
        freelancers.value = [];
    }
};

onMounted(fetchFreelancers);

watch(() => route.query, fetchFreelancers, { deep: true });
</script>
