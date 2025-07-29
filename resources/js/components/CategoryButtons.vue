<template>
    <div class="flex  justify-center overflow-x-auto items-center gap-2">
        <!-- Category Buttons -->
        <div v-for="category in categories" :key="category.id" class="relative">
            <div class="flex flex-col items-center w-24">
                <button
                    @click="toggleCategory(category.id)"
                    class="w-16 h-16 border-2 rounded-full transition-colors flex items-center justify-center"
                    :class="getCategoryButtonClass(category.id)"
                >
                    <img
                        :src="getProfilePhotoUrl(category.icon)"
                        alt="icon"
                        class="w-7 h-7 object-contain"
                        @error="handleImageError"
                    />
                </button>
                <span class="w-full text-xs break-words mt-1 text-center mb-2">
                    {{ category.name }}
                </span>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../axios";
import { useFreelancerStore } from "../stores/freelancerStore";

const categories = ref([]);
const subcategories = ref([]);
const selectedCategory = ref(null);
const freelancerStore = useFreelancerStore();
const emit = defineEmits(["subcategories-updated"]);

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

const toggleCategory = (categoryId) => {
    const isDeselecting = selectedCategory.value === categoryId;
    selectedCategory.value = isDeselecting ? null : categoryId;

    if (isDeselecting) {
        emit("subcategories-updated", {
            subcategories: [],
            categorySelected: false,
        });
    } else {
        const subs = getSubcategories(categoryId);
        emit("subcategories-updated", {
            subcategories: subs,
            categorySelected: true,
        });
    }
};

const getSubcategories = (categoryId) => {
    return subcategories.value.filter((sub) => sub.category_id === categoryId);
};

const getCategoryButtonClass = (categoryId) => {
    const isActive =
        freelancerStore.selectedSubcategory &&
        freelancerStore.selectedSubcategory.category_id === categoryId;

    const isOpen = selectedCategory.value === categoryId;

    return isActive || isOpen
        ? "border-blue-600 text-blue-600 bg-white hover:bg-blue-50"
        : "border-gray-300 text-gray-700 bg-white hover:bg-gray-50";
};

const initializeDefaultSubcategory = () => {
    // Find subcategory with ID 1
    const defaultSubcategory = subcategories.value.find((sub) => sub.id === 1);

    if (defaultSubcategory) {
        console.log("Default selected:", defaultSubcategory.name);
        freelancerStore.fetchFreelancersBySubcategory(defaultSubcategory);
    }
};

onMounted(async () => {
    try {
        const [categoriesRes, subcategoriesRes] = await Promise.all([
            api.get("/kategori"),
            api.get("/subkategori"),
        ]);

        categories.value = categoriesRes.data.data || categoriesRes.data;
        subcategories.value =
            subcategoriesRes.data.data || subcategoriesRes.data;

        // Initialize default subcategory after data is loaded
        initializeDefaultSubcategory();
    } catch (error) {
        console.error("Error loading categories:", error);
    }
});

</script>

<style scoped>
/* Ensure dropdowns appear above other content */
.relative {
    position: relative;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .flex-wrap {
        gap: 0.5rem;
    }
    
    .w-24 {
        width: 5rem;
    }
    
    .w-16 {
        width: 3rem;
        height: 3rem;
    }
    
    .w-7 {
        width: 1.25rem;
        height: 1.25rem;
    }
    
    .text-xs {
        font-size: 0.7rem;
    }
}

@media (max-width: 480px) {
    .w-24 {
        width: 4.5rem;
    }
    
    .w-16 {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .w-7 {
        width: 1rem;
        height: 1rem;
    }
    
    .text-xs {
        font-size: 0.65rem;
    }
}

/* Ensure dropdown is visible on mobile */
.absolute {
    position: absolute;
}

.z-10 {
    z-index: 10;
}
</style>
