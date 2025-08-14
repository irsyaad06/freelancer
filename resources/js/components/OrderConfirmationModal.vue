<template>
    <div v-if="show" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Pemesanan Berhasil!</h3>
                <div class="mt-2 px-7 py-3">
                    <div class="text-left">
                        <p class="text-sm text-gray-600"><strong>No Pesanan:</strong> {{ orderDetails.orderNumber }}</p>
                        <p class="text-sm text-gray-600"><strong>Email:</strong> {{ orderDetails.email }}</p>
                        <p class="text-sm text-gray-600"><strong>WhatsApp:</strong> {{ orderDetails.whatsapp }}</p>
                        <hr class="my-2">
                        <p class="text-sm text-gray-800 font-semibold">Detail Jasa:</p>
                        <p class="text-sm text-gray-600"><strong>Jasa:</strong> {{ orderDetails.serviceName }}</p>
                        <p class="text-sm text-gray-600"><strong>Paket:</strong> {{ orderDetails.packageName }}</p>
                        <p class="text-sm text-gray-600"><strong>Freelancer:</strong> {{ orderDetails.freelancerName }}</p>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-green-700 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                        Lanjutkan Ke Whatsapp
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    orderDetails: {
        type: Object,
        required: true,
        default: () => ({
            orderNumber: '',
            email: '',
            whatsapp: '',
            serviceName: '',
            packageName: '',
            freelancerName: '',
        }),
    },
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};
</script>
