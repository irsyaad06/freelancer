<template>
  <div>
    <h2 class="text-2xl font-bold">{{ freelancer.name }}</h2>
    <p class="text-gray-700">Skill: {{ freelancer.skill }}</p>
    <p class="text-gray-600 mt-4">More details about the freelancer...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const freelancer = ref({})

onMounted(() => {
  const id = Number(route.params.id)
  // Dummy fetch
  const dummy = [
    { id: 1, name: 'John Doe', skill: 'Web Developer' },
    { id: 2, name: 'Jane Smith', skill: 'Graphic Designer' },
    { id: 3, name: 'Ali Akbar', skill: 'Mobile Developer' },
  ]
  freelancer.value = dummy.find(f => f.id === id) || { name: 'Not Found', skill: '-' }
})
</script>