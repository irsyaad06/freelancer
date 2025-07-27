<template>
    <div class="flex flex-wrap justify-center items-center gap-2">
        <!-- Category Buttons -->
        <div v-for="category in categories" :key="category.id" class="relative">
            <button
                @click="toggleCategory(category.id)"
                class="px-4 py-2 border-2 rounded-lg transition-colors"
                :class="getCategoryButtonClass(category.id)"
            >
                {{ category.name }}
            </button>

            <!-- Subcategories Dropdown for this category -->
            <div
                v-if="selectedCategory === category.id"
                class="absolute z-10 mt-2 bg-white rounded-lg shadow-lg border border-blue-400 min-w-[200px]"
            >
                <ul class="py-2">
                    <li
                        v-for="subcategory in getSubcategories(category.id)"
                        :key="subcategory.id"
                    >
                        <button
                            @click="selectSubcategory(subcategory)"
                            class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-gray-100 hover:text-blue-600 transition-colors"
                            :class="{ 'bg-blue-100 font-semibold': selectedSubcategory?.id === subcategory.id }"
                        >
                            {{ subcategory.name }}
                        </button>
                    </li>
                    <li
                        v-if="getSubcategories(category.id).length === 0"
                        class="px-4 py-2 text-sm text-gray-400"
                    >
                        Tidak ada subkategori
                    </li>
                </ul>
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
const selectedSubcategory = ref(null);
const freelancerStore = useFreelancerStore();

const toggleCategory = (categoryId) => {
    selectedCategory.value =
        selectedCategory.value === categoryId ? null : categoryId;
};

const selectSubcategory = (subcategory) => {
    selectedSubcategory.value = subcategory;
    selectedCategory.value = null; // Close dropdown after selection
    
    // Find parent category ID
    const parentCategory = categories.value.find(
        cat => cat.id === subcategory.category_id
    );
    
    console.log("Selected:", subcategory.name);
    freelancerStore.fetchFreelancersBySubcategory(subcategory);
};

const getSubcategories = (categoryId) => {
    return subcategories.value.filter((sub) => sub.category_id === categoryId);
};

const getCategoryButtonClass = (categoryId) => {
    const isActive = selectedSubcategory.value && 
                    selectedSubcategory.value.category_id === categoryId;
    
    return isActive 
        ? 'border-blue-600 text-blue-600 bg-white hover:bg-blue-50' 
        : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50';
};

const initializeDefaultSubcategory = () => {
    // Find subcategory with ID 1
    const defaultSubcategory = subcategories.value.find(sub => sub.id === 1);
    
    if (defaultSubcategory) {
        selectedSubcategory.value = defaultSubcategory;
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

// Close dropdown when clicking outside
const closeDropdown = (e) => {
    if (!e.target.closest(".relative")) {
        selectedCategory.value = null;
    }
};

document.addEventListener("click", closeDropdown);
</script>

<style scoped>
/* Ensure dropdowns appear above other content */
.relative {
    position: relative;
}
</style>
