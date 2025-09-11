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
const subcategories = ref([]); // Menyimpan semua subkategori untuk fallback jika API gagal
const freelancerStore = useFreelancerStore();
const emit = defineEmits(["subcategories-updated"]);

// --- COMPUTED PROPERTY ---
// Ini menjadi satu-satunya sumber kebenaran untuk mengetahui kategori mana yang aktif/terbuka.
// Ia secara reaktif akan mengambil category_id dari subkategori yang terpilih di store.
const openCategoryId = computed(
    () => freelancerStore.selectedSubcategory?.category_id
);

// --- HELPER FUNCTION ---
// Dibuat agar tidak ada duplikasi kode untuk mengambil dan mengirim data subkategori.
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
        // Fallback ke data yang sudah ada jika API gagal
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
// Fungsi ini dipanggil saat tombol kategori di-klik.
const toggleCategory = async (categoryId) => {
    const isDeselecting = openCategoryId.value === categoryId;

    if (isDeselecting) {
        // Jika mengklik kategori yang sudah aktif, bersihkan pilihan.
        // Ini akan memicu watcher untuk menyembunyikan daftar subkategori.
        freelancerStore.selectedSubcategory = null;
    } else {
        // Jika mengklik kategori baru, tampilkan daftar subkategorinya.
        fetchAndEmitSubcategories(categoryId);
    }
};

// Fungsi ini menentukan class CSS untuk tombol kategori.
const getCategoryButtonClass = (categoryId) => {
    const isActive = openCategoryId.value === categoryId;
    return isActive
        ? "border-green-600 text-green-600 bg-white hover:bg-green-50"
        : "border-gray-300 text-gray-700 bg-white hover:bg-gray-50";
};

// Fungsi ini dijalankan saat awal untuk memilih subkategori default.
const initializeDefaultSubcategory = () => {
    const defaultSubcategory = subcategories.value.find((sub) => sub.id === 1);
    if (defaultSubcategory) {
        freelancerStore.fetchFreelancersBySubcategory(defaultSubcategory);
    }
};

// Fungsi ini mungkin masih berguna, jadi kita simpan.
const getSubcategories = (categoryId) => {
    return subcategories.value.filter((sub) => sub.category_id === categoryId);
};

// --- WATCHER ---
// Bagian paling penting untuk sinkronisasi.
// Watcher ini "mendengarkan" setiap perubahan pada state selectedSubcategory di store.
watch(
    () => freelancerStore.selectedSubcategory,
    (newSubcategory) => {
        if (newSubcategory && newSubcategory.category_id) {
            // Jika subkategori baru dipilih (misalnya dari SearchBar),
            // secara otomatis tampilkan daftar subkategori induknya.
            fetchAndEmitSubcategories(newSubcategory.category_id);
        } else {
            // Jika pilihan subkategori di-reset (menjadi null),
            // sembunyikan daftar subkategori yang sedang tampil.
            emit("subcategories-updated", {
                subcategories: [],
                categorySelected: false,
            });
        }
    },
    {
        // `immediate: true` memastikan watcher ini berjalan sekali saat komponen dimuat,
        // berguna jika state sudah ada dari awal.
        immediate: true,
    }
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

        // Panggil ini untuk mengatur state default saat halaman pertama kali dibuka.
        // Watcher akan menangani sisanya secara otomatis.
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
