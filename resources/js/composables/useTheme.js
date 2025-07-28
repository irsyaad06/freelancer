import { ref, watch, onMounted } from 'vue'

const isDark = ref(false)

export function useTheme() {
  // Initialize theme on mount
  onMounted(() => {
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme === 'dark') {
      isDark.value = true
      document.documentElement.classList.add('dark')
    } else {
      isDark.value = false
      document.documentElement.classList.remove('dark')
    }
  })

  // Watch for changes and update DOM
  watch(isDark, (newVal) => {
    if (newVal) {
      document.documentElement.classList.add('dark')
      localStorage.setItem('theme', 'dark')
    } else {
      document.documentElement.classList.remove('dark')
      localStorage.setItem('theme', 'light')
    }
  })

  const toggleTheme = () => {
    isDark.value = !isDark.value
  }

  return {
    isDark,
    toggleTheme,
  }
}
