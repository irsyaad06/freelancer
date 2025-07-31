<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @click.self="$emit('close')"
  >
    <div class="relative w-full max-w-xl p-4" style="max-height: 80vh;">
      <div class="relative flex flex-col bg-white rounded-lg shadow" style="max-height: 80vh;">
        
        <!-- Header -->
        <div class="flex items-center justify-between flex-shrink-0 p-4 border-b rounded-t">
          <h3 class="text-xl font-semibold text-gray-900 ">
            Syarat dan Ketentuan
          </h3>
          <button
            @click="$emit('close')"
            type="button"
            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto "
          >
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>

        <!-- Body -->
        <div class="flex-1 p-4 overflow-y-auto space-y-4">
          <div v-if="loading" class="py-10 text-center">
            <div class="inline-block w-8 h-8 border-b-2 rounded-full animate-spin border-blue-600"></div>
            <p class="mt-2 text-gray-500">Memuat...</p>
          </div>

          <div v-else-if="error" class="py-10 text-center text-red-500">
            <p>Gagal memuat syarat dan ketentuan.</p>
            <button @click="retry"
              class="mt-3 px-4 py-2 text-sm text-white bg-red-500 rounded-lg hover:bg-red-600">
              Coba Lagi
            </button>
          </div>

          <div v-else-if="term" class="prose max-w-none " v-html="term.content"></div>
        </div>

        <!-- Footer -->
        <div class="flex items-center flex-shrink-0 p-4 border-t border-gray-200 rounded-b ">
          <button
            @click="$emit('close')"
            type="button"
            class="px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
          >
            Saya Setuju
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { storeToRefs } from "pinia";
import { useTermTC } from "../stores/termAndConditionStore";

const props = defineProps({
  show: { type: Boolean, default: false },
});
defineEmits(["close"]);

const termStore = useTermTC();
const { term, loading, error } = storeToRefs(termStore);

const retry = () => termStore.fetchTerm(true);

// Auto-fetch saat komponen mount (sekali saja)
onMounted(() => {
  termStore.fetchTerm();
});
</script>
