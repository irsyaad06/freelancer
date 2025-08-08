<template>
    <div class="max-w-md mx-auto mt-2" @focusout="closeSuggestions">
        <form @submit.prevent="performSearch">
            <label
                for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only"
                >Cari</label
            >
            <div class="relative">
                <div
                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                >
                    <svg
                        class="w-4 h-4 text-gray-500"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>
                <input
                    type="search"
                    id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari Jasa / Ketik kebutuhanmu..."
                    :value="searchQuery"
                    @input="onInput"
                    @focus="showSuggestions = true"
                    autocomplete="off"
                />
                <button
                    type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                >
                    Cari
                </button>

                <div
                    v-if="showSuggestions"
                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg"
                >
                    <!-- Kalau ada hasil -->
                    <template v-if="suggestions.length > 0">
                        <ul>
                            <li
                                v-for="suggestion in suggestions"
                                :key="suggestion.id"
                                @mousedown.prevent="
                                    selectSuggestion(suggestion)
                                "
                                class="p-3 text-sm flex justify-start text-gray-700 cursor-pointer hover:bg-gray-100"
                            >
                                {{ suggestion.name }}
                            </li>
                        </ul>
                    </template>

                    <!-- Kalau tidak ada hasil -->
                    <template v-else>
                        <div class="p-3 text-sm text-gray-500">
                            Hasil tidak ditemukan
                        </div>
                        <hr />
                        <button
                            type="button"
                            class="text-white flex justify-start cursor-pointer text-xs bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg px-3 py-2 text-left ml-2 my-2"
                            @click="whatsappLink()"
                        >
                            Ceritakan Kebutuhanmu kepada kami!
                        </button>
                    </template>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useFreelancerStore } from "../stores/freelancerStore";
import axios from "@/axios";
import { useSettingStore } from "../stores/settingStore";

const freelancerStore = useFreelancerStore();
const searchQuery = ref("");
const suggestions = ref([]);
const showSuggestions = ref(false);

let debounceTimer;
const settingStore = useSettingStore();

onMounted(() => {
    settingStore.fetchSetting();
});

const onInput = (event) => {
    searchQuery.value = event.target.value;
    clearTimeout(debounceTimer);

    if (searchQuery.value.trim().length > 0) {
        debounceTimer = setTimeout(async () => {
            try {
                // Panggil API langsung saat mengetik
                const response = await axios.get(
                    `/subkategori/search?query=${searchQuery.value}`
                );
                console.log("API suggestions result:", response.data);
                const query = searchQuery.value.toLowerCase();
                let filteredSuggestions = [];

                if (response.data.data && response.data.data.length) {
                    filteredSuggestions = response.data.data.filter((item) =>
                        item.name.toLowerCase().includes(query)
                    );
                }

                suggestions.value = filteredSuggestions;
                showSuggestions.value = true;
            } catch (error) {
                console.error("Error fetching suggestions:", error);
                suggestions.value = [];
                showSuggestions.value = true; // tampilkan tombol walau error
            }
        }, 300); // debounce 300ms
    } else {
        suggestions.value = [];
        showSuggestions.value = false;
    }
};

function selectSuggestion(suggestion) {
    searchQuery.value = suggestion.name;
    showSuggestions.value = false;
    freelancerStore.fetchFreelancersBySubcategory(suggestion);
}

function performSearch() {
    showSuggestions.value = false;
    if (searchQuery.value.trim()) {
        freelancerStore.fetchFreelancersBySearch(searchQuery.value);
    } else {
        freelancerStore.fetchFreelancers();
    }
}

function whatsappLink() {
    if (settingStore.setting && settingStore.setting.telepon_web) {
        let message = "Halo, saya mencari jasa ";

        // Kalau ada yang diketik, tambahkan ke pesan
        if (searchQuery.value.trim().length > 0) {
            message += ` ${searchQuery.value.trim()}`;
        }

        const encodedMessage = encodeURIComponent(message);
        window.open(
            `https://wa.me/${settingStore.setting.telepon_web}?text=${encodedMessage}`,
            "_blank"
        );
    }
}

// Menutup dropdown saat fokus keluar dari area komponen
function closeSuggestions(event) {
    // Cek apakah fokus masih di dalam komponen, jika tidak, tutup dropdown
    if (!event.currentTarget.contains(event.relatedTarget)) {
        showSuggestions.value = false;
    }
}
</script>
