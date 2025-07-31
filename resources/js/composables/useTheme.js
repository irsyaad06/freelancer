import { ref, onMounted } from 'vue'

const isDark = ref(false)

export function useTheme() {
  // Always ensure light mode on mount
  onMounted(() => {
    document.documentElement.classList.remove('dark')
    localStorage.removeItem('theme')
  })

  // Disable theme toggling
  const toggleTheme = () => {
    // Do nothing
  }

  return {
    isDark,
    toggleTheme,
  }
}
