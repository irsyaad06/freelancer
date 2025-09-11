<template>
    <div class="category-container flex overflow-x-auto items-start gap-2">
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
import { ref, onMounted, computed, watch } from "vue";
import api from "../axios";
import { useFreelancerStore } from "../stores/freelancerStore";

// --- STATE & EMITS ---
const categories = ref([]);
const subcategories = ref([]);
const selectedCategory = ref(null); // State lokal untuk melacak kategori yang dibuka manual
const isDataReady = ref(false); // <--- TAMBAHKAN INI
const freelancerStore = useFreelancerStore();
const emit = defineEmits(["subcategories-updated"]);

// --- COMPUTED PROPERTY ---
const openCategoryId = computed(
    () => freelancerStore.selectedSubcategory?.category_id
);

// --- HELPER FUNCTIONS ---
const fetchAndEmitSubcategories = async (categoryId) => {
    try {
        const res = await api.get(`/subkategori/kategori/${categoryId}`);
        const filteredSubcategories = res.data.data || res.data;
        emit("subcategories-updated", {
            subcategories: filteredSubcategories,
            categorySelected: true,
        });
    } catch (err) {
        console.error("Error fetching subcategories:", err);
        const filteredSubcategories = subcategories.value.filter(
            (sub) => sub.category_id === categoryId
        );
        emit("subcategories-updated", {
            subcategories: filteredSubcategories,
            categorySelected: true,
        });
    }
};

const getProfilePhotoUrl = (photoPath) => {
    if (!photoPath) {
        return "https://flowbite.com/docs/images/people/profile-picture-3.jpg";
    }
    if (photoPath.startsWith("http") || photoPath.startsWith("/storage/")) {
        return photoPath;
    }
    return `/storage/${photoPath}`;
};

// --- COMPONENT METHODS ---
const toggleCategory = async (categoryId) => {
    const isDeselecting = selectedCategory.value === categoryId;

    if (isDeselecting) {
        // Jika mengklik kategori yang sudah terbuka, tutup dan bersihkan semuanya.
        selectedCategory.value = null;
        freelancerStore.selectedSubcategory = null;
        emit("subcategories-updated", {
            subcategories: [],
            categorySelected: false,
        });
    } else {
        // Jika mengklik kategori baru:
        // 1. Jadikan kategori ini aktif secara lokal.
        selectedCategory.value = categoryId;
        // 2. Ambil dan tampilkan daftar subkategorinya.
        fetchAndEmitSubcategories(categoryId);
    }
};

const getCategoryButtonClass = (categoryId) => {
    const isActive = openCategoryId.value === categoryId;
    const isOpen = selectedCategory.value === categoryId;

    return isActive || isOpen
        ? "border-green-600 text-green-600 bg-white hover:bg-green-50"
        : "border-gray-300 text-gray-700 bg-white hover:bg-gray-50";
};

const initializeDefaultSubcategory = () => {
    const defaultSubcategory = subcategories.value.find((sub) => sub.id === 1);
    if (defaultSubcategory) {
        freelancerStore.fetchFreelancersBySubcategory(defaultSubcategory);
    }
};

// --- WATCHER ---
watch(
    () => freelancerStore.selectedSubcategory,
    (newSubcategory) => {
        if (!isDataReady.value) return; // <--- TAMBAHKAN PENJAGA INI

        if (newSubcategory && newSubcategory.category_id) {
            fetchAndEmitSubcategories(newSubcategory.category_id);
            selectedCategory.value = newSubcategory.category_id;
        } else {
            selectedCategory.value = null;
            emit("subcategories-updated", {
                subcategories: [],
                categorySelected: false,
            });
        }
    },
    { immediate: true }
);

// --- LIFECYCLE HOOK ---
onMounted(async () => {
    try {
        const [categoriesRes, subcategoriesRes] = await Promise.all([
            api.get("/kategori"),
            api.get("/subkategori"),
        ]);
        categories.value = categoriesRes.data.data || categoriesRes.data;
        subcategories.value =
            subcategoriesRes.data.data || subcategoriesRes.data;

        isDataReady.value = true; // <--- SETelah DATA SIAP, BUKA GERBANGNYA

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

.category-container {
    /* Default (Mobile First): Rata kiri */
    justify-content: flex-start;
}

/* Untuk layar medium (md) ke atas, yaitu 768px */
@media (min-width: 768px) {
    .category-container {
        /* Rata tengah untuk desktop */
        justify-content: center;
    }
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
