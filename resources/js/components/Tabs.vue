<template>
    <div class="border-l pl-3 border-gray-300 right-10">
        <div class="mb-4 border-gray-200 ">
            <ul
                class="flex md:flex-wrap justify-between -mb-px text-sm font-medium text-center bullet"
                role="tablist"
            >
                <li v-for="(pkg, index) in servicePackages" :key="pkg.id" class="me-2" role="presentation">
                    <button
                        :class="[
                            'inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300',
                            activeTab === index ? 'font-bold border-green-600 text-green-600 bg-green-200' : 'border-transparent text-gray-500'
                        ]"
                        @click="selectPackage(index, pkg)"
                        type="button"
                        role="tab"
                        :aria-controls="`content-${index}`"
                        :aria-selected="activeTab === index"
                    >
                        {{ pkg.name }}
                    </button>
                </li>
            </ul>
        </div>
        <div id="tab-content">
            <div
                v-for="(pkg, index) in servicePackages"
                :key="pkg.id"
                :class="['p-4 rounded-lg bg-gray-50', activeTab === index ? 'block' : 'hidden']"
                :id="`content-${index}`"
                role="tabpanel"
                :aria-labelledby="`tab-${index}`"
            >
                <div class="flex justify-between mb-3">
                    <span class="font-bold text-lg">{{ pkg.name }}</span>
                    <span class="text-green-600 font-semibold">Rp {{ formatPrice(pkg.price) }}</span>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Layanan yang termasuk:</h4>
                    <ul class="pl-5 list-disc space-y-1">
                        <li v-for="service in pkg.services" :key="service.id" class="text-sm">
                            {{ service.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    servicePackages: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['package-selected']);

const activeTab = ref(0);

const selectPackage = (index, pkg) => {
    activeTab.value = index;
    emit('package-selected', pkg);
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price);
};

onMounted(() => {
    // Ensure tabs work correctly
    if (props.servicePackages.length > 0) {
        activeTab.value = 0;
    }
});
</script>
