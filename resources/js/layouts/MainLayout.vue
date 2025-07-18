<template>
    <div>
        <Navbar />
        <main class="min-h-screen p-4 mx-4 md:mx-12 lg:mx-20">
            <router-view />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
</script>
