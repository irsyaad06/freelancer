import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'flowbite'
import { useTheme } from './composables/useTheme'

// Initialize theme on app start
const { isDark } = useTheme()
isDark.value = false // Force light mode as default

const app = createApp(App)
app.use(router)
app.mount('#app')
