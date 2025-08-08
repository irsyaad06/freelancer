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
                    :value="searchQuery"
                    @input="onInput"
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
                    v-if="showSuggestions && suggestions.length > 0"
                    class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg "
                >
                    <ul>
                        <li
                            v-for="suggestion in suggestions"
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
import { ref } from "vue";
import { useFreelancerStore } from "../stores/freelancerStore";
import axios from "@/axios";

const freelancerStore = useFreelancerStore();
const searchQuery = ref("");
const suggestions = ref([]);
const showSuggestions = ref(false);

let debounceTimer;

    const onInput = (event) => {
        searchQuery.value = event.target.value;
        clearTimeout(debounceTimer);
        
        if (searchQuery.value.trim().length > 0) {
            debounceTimer = setTimeout(async () => {
                try {
                    const response = await axios.get(
                        `/api/subkategori/search?query=${searchQuery.value}`
                    );
                    
                    let filteredSuggestions = [];
                    
                    if (response.data.data && response.data.data.length) {
                        // Filter suggestions that start with the typed character(s)
                        const query = searchQuery.value.toLowerCase();
                        filteredSuggestions = response.data.data.filter(item => 
                            item.name.toLowerCase().startsWith(query)
                        );
                        
                        // If no matches starting with the query, show all matches
                        if (filteredSuggestions.length === 0) {
                            filteredSuggestions = response.data.data;
                        }
                    }
                    
                    suggestions.value = filteredSuggestions;
                    showSuggestions.value = filteredSuggestions.length > 0;
                } catch (error) {
                    console.error("Error fetching suggestions:", error);
                    suggestions.value = [];
                    showSuggestions.value = false;
                }
            }, 300); // 300ms debounce
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

// Menutup dropdown saat fokus keluar dari area komponen
function closeSuggestions(event) {
    // Cek apakah fokus masih di dalam komponen, jika tidak, tutup dropdown
    if (!event.currentTarget.contains(event.relatedTarget)) {
        showSuggestions.value = false;
    }
}
</script>
