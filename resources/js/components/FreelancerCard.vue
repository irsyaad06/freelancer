<template>
    <div class="relative w-64 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700"
        :class="{ 'border border-yellow-400': props.isTopFreelancer }">
        <div
            v-if="props.isTopFreelancer"
            class="absolute top-2 left-2 bg-yellow-400 text-gray-800 text-xs font-bold px-2 py-1 flex items-center z-10"
        >
            <svg
                class="w-3 h-3 mr-1"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
            </svg>
            Top
        </div>
        <div class="flex flex-col items-center p-6">
            <img
                class="w-20 h-20 mb-3 rounded-full shadow-lg object-cover"
                :src="getProfilePhotoUrl(freelancer.profile_photo)"
                :alt="freelancer.name"
            />
            <h5
                class="mb-1 text-lg font-semibold text-gray-900 dark:text-white text-center"
            >
                {{ freelancer.name }}
            </h5>
            <div class="flex items-center mb-2">
                <svg
                    class="w-4 h-4 text-yellow-300 mr-1"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 22 20"
                >
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                    />
                </svg>
                <span class="text-sm text-gray-600 dark:text-gray-400">{{
                    freelancer.rating
                }} •</span>
                <svg
                
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-4 h-4 text-blue-500 ml-1"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"
                    />
                </svg>

                <span class="text-sm text-gray-500 dark:text-gray-400"
                    >{{ freelancer.is_verified }}</span
                >
            </div>

             <span class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Mulai Dari
                <span class="text-green-600 font-semibold">
                    {{ formatRupiah(freelancer.price) }}
                </span>
            </span>
            <div class="flex flex-col space-y-2 w-full">
                <button
                    @click="goToDetail"
                    class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
                >
                    Lihat Detail
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const props = defineProps({
    freelancer: {
        type: Object,
        required: true,
        default: () => ({
            name: "Freelancer Name",
            profile_photo: null,
        }),
    },
    selectedSubcategory: {
        type: Object,
        default: null,
    },
    isTopFreelancer: {
        type: Boolean,
        default: false,
    },
});

const router = useRouter();

const goToDetail = () => {
    if (props.selectedSubcategory) {
        router.push({
            name: "freelancer.detail",
            params: {
                subcategoryId: props.selectedSubcategory.id,
                freelancerId: props.freelancer.id,
            },
        });
    }
};

const formatRupiah = (value) => {
    if (!value) return "0";
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
};

const getProfilePhotoUrl = (photoPath) => {
    if (!photoPath) {
        return "https://flowbite.com/docs/images/people/profile-picture-3.jpg";
    }

    // Handle both cases: with and without /storage/ prefix
    if (photoPath.startsWith("http")) {
        return photoPath;
    }

    if (photoPath.startsWith("/storage/")) {
        return photoPath;
    }

    return `/storage/${photoPath}`;
};
</script>
