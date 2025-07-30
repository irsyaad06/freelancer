<template>
    <div class="text-center mt-10 pt-10 mb-10 pb-10">
        <h2 class="text-3xl font-bold text-blue-600 mt-10">
            Welcome to {{ setting ? setting.nama_web : "FindLancer" }}
        </h2>
        <p class="mt-2 text-gray-700">
            Find the best freelancers for your project.
        </p>

        <SearchBar />
        <div class="p-8">
            <CategoryButtons
                @subcategories-updated="handleSubcategoriesUpdate"
            />
        </div>
        <!-- Subcategory Buttons Section -->
        <section v-if="subcategoriesToShow.length > 0" class="text-center py-4">
            <div class="flex justify-center flex-wrap gap-2 px-4">
                <button
                    v-for="sub in subcategoriesToShow"
                    :key="sub.id"
                    @click="selectSubcategory(sub)"
                    class="px-4 py-2 text-sm font-medium border rounded-full transition-colors"
                    :class="{
                        'bg-blue-600 text-white border-blue-600':
                            freelancerStore.selectedSubcategory?.id === sub.id,
                        'bg-white text-gray-700 border-gray-300 hover:bg-gray-100':
                            freelancerStore.selectedSubcategory?.id !== sub.id,
                    }"
                >
                    {{ sub.name }}
                </button>
            </div>
        </section>

        <!-- No Subcategories Message -->
        <section
            v-if="isCategorySelected && subcategoriesToShow.length === 0"
            class="text-center py-4"
        >
            <p class="text-gray-500">Belum ada jasa tersedia</p>
        </section>

        <!-- Dynamic Page Title -->
        <section
            class="text-center pt-4 pb-2"
            :class="{ 'pt-0': subcategoriesToShow.length > 0 }"
        >
            <h2 class="text-2xl font-bold text-gray-800">
                {{
                    freelancerStore.selectedSubcategory?.name ||
                    "Jelajahi Jasa Kami"
                }}
            </h2>
            <p class="text-gray-500">
                Temukan Freelancer yang paling sesuai dengan kebutuhan anda
            </p>
        </section>
        <div v-if="loading" class="flex justify-center items-center py-10">
            <div
                class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
            ></div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="text-center py-10">
            <p class="text-red-500">{{ error }}</p>
            <button
                @click="fetchFreelancers"
                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded"
            >
                Coba Lagi
            </button>
        </div>

        <!-- Data State -->

        <div
            v-else-if="freelancers.length > 0"
            class="flex justify-center items-center"
        >
            <div
                :class="[
                    'grid gap-4 p-4 max-w-7xl mx-auto',
                    freelancers.length === 1 &&
                        'grid-cols-1 justify-items-center',
                    freelancers.length === 2 &&
                        'md:grid-cols-2 justify-items-center',
                    freelancers.length === 3 &&
                        'md:grid-cols-2 lg:grid-cols-3 justify-items-center',
                    freelancers.length >= 4 && 'md:grid-cols-2 lg:grid-cols-4',
                ]"
            >
                <Top3FreelancerCard
                    v-for="f in topFreelancers"
                    :key="`top-${f.id}`"
                    :freelancer="f"
                    :selectedSubcategory="freelancerStore.selectedSubcategory"
                />
                <FreelancerCard
                    v-for="f in freelancers"
                    :key="f.id"
                    :freelancer="f"
                    :selectedSubcategory="freelancerStore.selectedSubcategory"
                />
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-10 mt-10">
            <p class="text-gray-500">Tidak ada freelancer yang tersedia</p>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref, computed } from "vue";
import { storeToRefs } from "pinia";
import { useFreelancerStore } from "../stores/freelancerStore";
import { useSettingStore } from "../stores/settingStore";
import CategoryButtons from "../components/CategoryButtons.vue";
import FreelancerCard from "../components/FreelancerCard.vue";
import Top3FreelancerCard from "../components/Top3FreelancerCard.vue";
import SearchBar from "../components/SearchBar.vue";

const freelancerStore = useFreelancerStore();
const { freelancers, topFreelancers, loading, error } =
    storeToRefs(freelancerStore);
const subcategoriesToShow = ref([]);
const isCategorySelected = ref(false);
const settingStore = useSettingStore();
const setting = computed(() => settingStore.setting);

const handleSubcategoriesUpdate = (payload) => {
    subcategoriesToShow.value = payload.subcategories;
    isCategorySelected.value = payload.categorySelected;
};

const selectSubcategory = (subcategory) => {
    freelancerStore.fetchFreelancersBySubcategory(subcategory);
};

const fetchFreelancers = () => {
    freelancerStore.fetchFreelancers();
};

onMounted(() => {
    fetchFreelancers();
    settingStore.fetchSetting(); // Action dipanggil di sini
});
</script>
