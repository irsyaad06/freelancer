// app.js (Versi Final)

import { createApp } from "vue";
import { createPinia } from "pinia";
// SUMBER IMPORT YANG BENAR ADA DI BAWAH INI
import { devtools } from '@vue/devtools'
import App from "./App.vue";
import router from "./router";
import "flowbite";
import { useTheme } from "./composables/useTheme";

// Initialize theme on app start
const { isDark } = useTheme();
isDark.value = false; // Force light mode as default

// KODE YANG BENAR UNTUK VITE
if (import.meta.env.MODE === "production") {
    devtools.connect("http://localhost", 8098);
}

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
app.mount("#app");