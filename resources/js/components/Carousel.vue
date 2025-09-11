<template>
    <div class="relative w-full">
        <div
            class="relative w-full bg-gray-200 overflow-hidden rounded-lg"
            style="
                aspect-ratio: 16/9;
                max-width: 1920px;
                max-height: 1080px;
                margin: 0 auto;
            "
        >
            <div
                v-if="isLoading"
                class="w-full h-full bg-gray-300 animate-pulse"
                aria-label="Loading photos"
            ></div>

            <div
                v-else-if="photos && photos.length > 0"
                class="relative w-full h-full"
            >
                <div
                    v-for="(photo, index) in photos"
                    :key="photo.id"
                    class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                    :class="{
                        'opacity-100': currentSlide === index,
                        'opacity-0': currentSlide !== index,
                    }"
                >
                    <img
                        :src="getProfilePhotoUrl(photo.image)"
                        class="w-full h-full object-cover"
                        :alt="photo.caption || 'Freelancer photo'"
                    />
                </div>
            </div>

            <div
                v-else
                class="w-full h-full flex items-center justify-center bg-gray-200"
            >
                <span class="text-gray-500">Belum ada foto</span>
            </div>
        </div>

        <div
            v-if="!isLoading && photos && photos.length > 1"
            class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse"
        >
            <button
                v-for="(photo, index) in photos"
                :key="'dot-' + index"
                type="button"
                class="w-3 h-3 rounded-full bg-white/50 hover:bg-white/70 transition"
                :class="{ 'bg-white': currentSlide === index }"
                :aria-label="'Slide ' + (index + 1)"
                @click="goToSlide(index)"
            ></button>
        </div>

        <div v-if="!isLoading && photos && photos.length > 1">
            <button
                type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                @click="prevSlide"
            >
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 transition"
                >
                    <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button
                type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                @click="nextSlide"
            >
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 transition"
                >
                    <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    photos: {
        type: Array,
        required: true,
        default: () => [],
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
});

const currentSlide = ref(0);

const getProfilePhotoUrl = (photoPath) => {
    if (!photoPath) {
        return ""; // Return empty string to avoid broken image icon
    }
    if (photoPath.startsWith("http") || photoPath.startsWith("/storage/")) {
        return photoPath;
    }
    if (photoPath.startsWith("freelancer-photos/")) {
        return `/storage/${photoPath}`;
    }
    return `/storage/${photoPath}`;
};

const nextSlide = () => {
    if (props.photos && props.photos.length > 0) {
        currentSlide.value = (currentSlide.value + 1) % props.photos.length;
    }
};

const prevSlide = () => {
    if (props.photos && props.photos.length > 0) {
        currentSlide.value = (currentSlide.value - 1 + props.photos.length) % props.photos.length;
    }
};

const goToSlide = (index) => {
    currentSlide.value = index;
};
</script>