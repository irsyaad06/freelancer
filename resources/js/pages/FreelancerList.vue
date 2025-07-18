<template>
  <div class="mt-10 pt-10 px-4">
    <h2 class="text-2xl font-bold mb-6">Freelancers</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 gap-y-6">
      <FreelancerCard v-for="f in freelancers" :key="f.id" :freelancer="f" />
    </div>
  </div>
</template>

<script setup>
import FreelancerCard from '../components/FreelancerCard.vue'

const freelancers = [
  { id: 1, name: 'John Doe', skill: 'Web Developer' },
  { id: 2, name: 'Jane Smith', skill: 'Graphic Designer' },
  { id: 3, name: 'Ali Akbar', skill: 'Mobile Developer' },
  { id: 4, name: 'Duba Kuda', skill: 'Mobile kanzler' },
  { id: 5, name: 'Aliando', skill: 'Web hack' },
]
</script>