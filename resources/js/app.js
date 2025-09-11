import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import "flowbite";
import { useTheme } from "./composables/useTheme";

// Initialize theme on app start
const { isDark } = useTheme();
isDark.value = false; // Force light mode as default
// Tambahkan blok ini
if (process.env.NODE_ENV === "production") {
    connect("http://localhost", 8098); // Jangan ubah URL ini
}

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
app.mount("#app");
