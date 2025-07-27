<template>
    <div class="flex items-center gap-4">
        <img
            class="w-20 h-20 rounded-full object-cover"
            :src="getProfilePhotoUrl(freelancer.profile_photo)"
            :alt="freelancer.name"
        />
        <div class="font-medium text-black">
            <div class="text-xl font-semibold">{{ freelancer.name }}</div>
            <div class="flex items-center gap-2">
                <div class="text-sm text-gray-500 mt-1">
                    {{ freelancer.is_verified }}
                </div>
                •
                
                <div class="text-sm text-gray-500 mt-1 flex">
                    <svg
                    class="w-4 h-4 text-yellow-400 mr-1 "
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 22 20"
                >
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
                    />
                </svg>
                    {{ freelancer.rating }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    freelancer: {
        type: Object,
        required: true,
        default: () => ({
            name: "Freelancer Name",
            profile_photo: null,
        }),
    },
});

const getProfilePhotoUrl = (photoPath) => {
    if (!photoPath) {
        return "https://img.icons8.com/ios-filled/100/000000/user-male-circle.png";
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
