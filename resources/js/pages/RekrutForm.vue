<template>
    <div>
        <div class="max-w-screen-xl mx-auto p-4 mt-10 pt-10 mb-10 pb-10">
            <span class="text-2xl font-semibold">Form Rekrut Freelancer</span>
            <!-- Service Package Info -->
            <div class="md:grid grid-cols-4 md:grid-cols-2 gap-5">
                <div class="order-2 md:order-1">
                    <span>Paket yang dipilih</span>
                    <div v-if="loading" class="text-center py-8">
                        <div
                            class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600 mx-auto mt-10 pt-10"
                        ></div>
                        <p class="mt-2 text-gray-600">Memuat Pilihan Anda...</p>
                    </div>

                    <div v-else-if="error" class="text-center py-8">
                        <p class="text-red-600">{{ error }}</p>
                    </div>

                    <div
                        v-else-if="servicePackage"
                        class="mb-8 bg-white rounded-lg shadow-sm border border-green-300 p-6 mt-6 sticky"
                    >
                        <h2 class="flex text-xl font-semibold">
                            {{ servicePackage.title }}
                        </h2>

                        <p
                            class="text-gray-600 mb-4 break-words break-all whitespace-pre-line"
                        >
                            {{ servicePackage.description }}
                        </p>

                        <div class="ml-2">
                            <div class="flex">
                                <span class="font-medium text-gray-700"
                                    >Freelancer</span
                                >
                                <p>:</p>
                                <p class="text-gray-600 ml-1">
                                    {{ servicePackage.freelancer.name }}
                                </p>
                            </div>
                            <div class="flex flex-wrap mt-2">
                                <span class="font-medium text-gray-700"
                                    >Jasa</span
                                >
                                <p>:</p>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-1"
                                >
                                    Pembuatan
                                    {{ servicePackage.subcategory.name }}
                                </span>
                            </div>
                            <div class="flex flex-wrap mt-2">
                                <span class="font-medium text-gray-700"
                                    >Layanan:</span
                                >
                                <ul class="text-gray-600 ml-1">
                                    <li
                                        v-for="service in servicePackage.services"
                                        :key="service.title"
                                    >
                                        • {{ service.title }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <form @submit.prevent="store.submitOrder" class="max-w-md mt-6">
                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <label
                                for="fullName"
                                class="block mb-2 text-sm font-medium text-gray-900"
                            >
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="fullName"
                                v-model="form.fullName"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                placeholder="Masukkan nama lengkap"
                                required
                            />
                            <p
                                v-if="errors.fullName"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.fullName }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900"
                            >
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                placeholder="contoh@email.com"
                                required
                            />
                            <p
                                v-if="errors.email"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.email }}
                            </p>
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div class="mb-4">
                            <label
                                for="whatsapp"
                                class="block mb-2 text-sm font-medium text-gray-900"
                            >
                                Nomor WhatsApp
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="tel"
                                id="whatsapp"
                                v-model="form.whatsapp"
                                @input="store.validateWhatsApp"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                placeholder="081234567890"
                                required
                            />
                            <p
                                v-if="errors.whatsapp"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.whatsapp }}
                            </p>
                        </div>

                        <!-- Deskripsi Pekerjaan -->
                        <div class="mb-4">
                            <label
                                for="jobDescription"
                                class="block mb-2 text-sm font-medium text-gray-900"
                            >
                                Deskripsi Pekerjaan
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="jobDescription"
                                rows="6"
                                maxlength="500"
                                v-model="form.jobDescription"
                                @input="store.updateCharacterCount"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500"
                                placeholder="Ketik deskripsi pekerjaan disini... (maksimal 500 karakter)"
                                required
                            ></textarea>
                            <div class="text-right text-sm text-gray-500 mt-1">
                                {{ characterCount }}/500 karakter
                            </div>
                            <p
                                v-if="errors.jobDescription"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.jobDescription }}
                            </p>
                        </div>

                        <!-- Upload File -->
                        <div class="mb-4">
                            <label
                                for="fileUpload"
                                class="block mb-2 text-sm font-medium text-gray-900"
                            >
                                Upload File (Opsional) |
                                <span class="text-red-500">
                                    Maksimal 25 MB</span
                                >
                            </label>
                            <input
                                type="file"
                                id="fileUpload"
                                @change="store.handleFileUpload"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            />
                            <p
                                v-if="errors.fileUpload"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.fileUpload }}
                            </p>
                            <p
                                v-if="selectedFile"
                                class="mt-1 text-sm text-green-600"
                            >
                                File terpilih: {{ selectedFile.name }} ({{
                                    store.formatFileSize(selectedFile.size)
                                }})
                            </p>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.termsAccepted"
                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500"
                                    required
                                />
                                <span class="ml-2 text-sm text-gray-900">
                                    Saya menyetujui
                                    <button
                                        type="button"
                                        @click="showTermsModal = true"
                                        class="text-green-600 hover:underline cursor-pointer"
                                    >
                                        Syarat dan Ketentuan
                                    </button>
                                </span>
                            </label>
                            <p
                                v-if="errors.termsAccepted"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.termsAccepted }}
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="!isFormValid || isSubmitting"
                            :class="[
                                'w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center',
                                isFormValid && !isSubmitting
                                    ? 'bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300'
                                    : 'bg-gray-400 cursor-not-allowed',
                            ]"
                        >
                            {{
                                isSubmitting ? "Mengirim..." : "Pesan Sekarang"
                            }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <Term :show="showTermsModal" @close="showTermsModal = false" />

    <!-- Order Confirmation Modal -->
    <OrderConfirmationModal
        :show="showOrderModal"
        :order-details="orderDetails"
        @close="store.closeOrderModal"
    />
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { storeToRefs } from "pinia";
import Term from "../components/Term.vue";
import OrderConfirmationModal from "../components/OrderConfirmationModal.vue";
import { useSettingStore } from "../stores/settingStore";
import { useRekrutFormStore } from "../stores/rekrutFormStore";

const route = useRoute();
const store = useRekrutFormStore();
const settingStore = useSettingStore();

const {
    servicePackage,
    loading,
    error,
    isSubmitting,
    showOrderModal,
    orderDetails,
    form,
    errors,
    selectedFile,
    characterCount,
    isFormValid,
} = storeToRefs(store);

const showTermsModal = ref(false);

onMounted(() => {
    settingStore.fetchSetting();
    store.fetchServicePackage(route.params.servicePackageId);
    store.resetForm();
});
</script>
