<template>
  <div>
    <h2 class="text-2xl font-bold mb-4">Freelancers</h2>
    <div class="grid md:grid-cols-3 gap-4">
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
]
</script>