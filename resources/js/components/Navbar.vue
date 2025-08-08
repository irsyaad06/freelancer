<!-- Navbar.vue -->
<template>
    <nav
        class="bg-white fixed w-full z-50 top-0 start-0 border-b border-gray-200 "
    >
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
        >
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img
                    v-if="setting && setting.logo_web"
                    :src="setting.logo_web"
                    class="h-8"
                    :alt="setting.nama_web"
                />
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap "
                    >{{ setting ? setting.nama_web : "FindLancer" }}</span
                >
            </a>
            <div
                class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <!-- Theme Toggle Button -->
                <button
                    
                    type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 "
                >
                    Coming Soon
                </button>
                <button
                    data-collapse-toggle="navbar-sticky"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 "
                    aria-controls="navbar-sticky"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 17 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15"
                        />
                    </svg>
                </button>
            </div>
            <div
                class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                id="navbar-sticky"
            >
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white "
                >
                    <li>
                        <router-link
                            to="/"
                            :class="[
                                'block py-2 px-3 rounded-sm md:p-0',
                                route.path === '/'
                                    ? 'text-blue-700 bg-blue-100 md:bg-transparent md:text-blue-700'
                                    : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700',
                            ]"
                        >
                            Beranda
                        </router-link>
                    </li>
                    <!-- <li>
                        <a
                            href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 "
                        >
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 "
                        >
                            Kontak
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { useRoute } from "vue-router";
import { useTheme } from "../composables/useTheme";
import { onMounted, computed } from "vue";
import { useSettingStore } from "../stores/settingStore";

const route = useRoute();
const { isDark, toggleTheme } = useTheme();
const settingStore = useSettingStore();

const setting = computed(() => settingStore.setting);

onMounted(() => {
    settingStore.fetchSetting();
});
</script>

<style scoped>
/* Tambahan styling untuk active state */
.router-link-active {
    @apply text-blue-700 bg-blue-100 md:bg-transparent md:text-blue-700;
}
</style>
