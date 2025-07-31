<template>
    <div class="max-w-md mx-auto mt-2" @focusout="closeSuggestions">
        <form @submit.prevent="performSearch">
            <label
                for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only "
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
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                    placeholder="Cari Jasa / Ketik kebutuhanmu..."
                    v-model="searchQuery"
                    @focus="showSuggestions = true"
                    autocomplete="off"
                />
                <button
                    type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 "
                >
                    Cari
                </button>

                <div
                    v-if="showSuggestions && filteredSuggestions.length > 0"
                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg "
                >
                    <ul>
                        <li
                            v-for="suggestion in filteredSuggestions"
                            :key="suggestion.id"
                            @click="selectSuggestion(suggestion)"
                            class="p-3 text-sm flex justify-start text-gray-700 cursor-pointer hover:bg-gray-100 "
                        >
                            {{ suggestion.name }}
                        </li>
                    </ul>
                    <div>
                        <hr />
                        <button
                            type="button"
                            class="text-white flex justify-start cursor-pointer text-xs bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300  rounded-lg px-3 py-2 text-left ml-2 my-2"
                        >
                            Ceritakan Kebutuhanmu kepada kami!
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

// --- State Management ---
const searchQuery = ref("");
const showSuggestions = ref(false);

// --- Data Dummy ---
const dummyData = ref([
    { id: 1, name: "Web Design" },
    { id: 2, name: "Web Development" },
    { id: 3, name: "Logo Design" },
    { id: 4, name: "Graphic Design" },
    { id: 5, name: "Content Writer" },
    { id: 6, name: "Video Editor" },
    { id: 7, name: "Social Media Manager" },
]);

// --- Computed Property untuk memfilter saran ---
const filteredSuggestions = computed(() => {
    if (!searchQuery.value) {
        return [];
    }
    // Filter data berdasarkan input pengguna (tidak case-sensitive)
    return dummyData.value.filter((item) =>
        item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// --- Functions ---
function selectSuggestion(suggestion) {
    searchQuery.value = suggestion.name; // Isi input dengan saran yang dipilih
    showSuggestions.value = false; // Sembunyikan dropdown
    // Anda bisa langsung trigger pencarian di sini jika mau
    // performSearch();
}

function performSearch() {
    if (!searchQuery.value) return;
    console.log("Melakukan pencarian untuk:", searchQuery.value);
    showSuggestions.value = false; // Sembunyikan dropdown setelah submit
    // Di sini Anda akan menambahkan logika untuk menavigasi ke halaman hasil pencarian
}

// Menutup dropdown saat fokus keluar dari area komponen
function closeSuggestions(event) {
    // Cek apakah fokus masih di dalam komponen, jika tidak, tutup dropdown
    if (!event.currentTarget.contains(event.relatedTarget)) {
        showSuggestions.value = false;
    }
}
</script>
