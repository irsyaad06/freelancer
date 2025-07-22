<template>
    <div class="flex flex-wrap justify-center items-center gap-2">
        <!-- Category Buttons -->
        <div v-for="category in categories" :key="category.id" class="relative">
            <button
                @click="toggleCategory(category.id)"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                :class="{ 'bg-blue-800': selectedCategory === category.id }"
            >
                {{ category.name }}
            </button>

            <!-- Subcategories Dropdown for this category -->
            <div
                v-if="selectedCategory === category.id"
                class="absolute z-10 mt-2 bg-white rounded-lg shadow-lg border min-w-[200px]"
            >
                <ul class="py-2">
                    <li
                        v-for="subcategory in getSubcategories(category.id)"
                        :key="subcategory.id"
                    >
                        <button
                            @click="selectSubcategory(subcategory)"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition-colors"
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

const categories = ref([]);
const subcategories = ref([]);
const selectedCategory = ref(null);
const selectedSubcategory = ref(null);

const toggleCategory = (categoryId) => {
    selectedCategory.value =
        selectedCategory.value === categoryId ? null : categoryId;
};

const selectSubcategory = (subcategory) => {
    selectedSubcategory.value = subcategory;
    selectedCategory.value = null; // Close dropdown after selection
    console.log("Selected:", subcategory.name);
};

const getSubcategories = (categoryId) => {
    return subcategories.value.filter((sub) => sub.category_id === categoryId);
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
