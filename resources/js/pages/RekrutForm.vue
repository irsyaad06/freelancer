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
                            class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mt-10 pt-10"
                        ></div>
                        <p class="mt-2 text-gray-600">Memuat Pilihan Anda...</p>
                    </div>

                    <div v-else-if="error" class="text-center py-8">
                        <p class="text-red-600">{{ error }}</p>
                    </div>

                    <div
                        v-else-if="servicePackage"
                        class="mb-8 bg-white rounded-lg shadow-sm border border-blue-300 p-6 mt-6 sticky"
                    >
                        <h2 class="flex text-xl font-semibold">
                            {{ servicePackage.title }}
                        </h2>

                        <p class="text-gray-600 mb-4 break-words break-all whitespace-pre-line">
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
                    <form @submit.prevent="handleSubmit" class="max-w-md mt-6">
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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
                                @input="validateWhatsApp"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
                                @input="updateCharacterCount"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
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
                                Upload File (Opsional)
                            </label>
                            <input
                                type="file"
                                id="fileUpload"
                                @change="handleFileUpload"
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
                                    formatFileSize(selectedFile.size)
                                }})
                            </p>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.termsAccepted"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                    required
                                />
                                <span class="ml-2 text-sm text-gray-900">
                                    Saya menyetujui
                                    <button
                                        type="button"
                                        @click="showTermsModal = true"
                                        class="text-blue-600 hover:underline cursor-pointer"
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
                                    ? 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300'
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
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import Term from "../components/Term.vue";

const route = useRoute();
const servicePackage = ref(null);
const loading = ref(true);
const error = ref(null);
const showTermsModal = ref(false);
const isSubmitting = ref(false);

const form = ref({
    fullName: "",
    email: "",
    whatsapp: "",
    jobDescription: "",
    fileUpload: null,
    termsAccepted: false,
});

const errors = ref({
    fullName: "",
    email: "",
    whatsapp: "",
    jobDescription: "",
    fileUpload: "",
    termsAccepted: "",
});

const selectedFile = ref(null);
const characterCount = ref(0);

const updateCharacterCount = () => {
    characterCount.value = form.value.jobDescription.length;
};

const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
};

const validateWhatsApp = (event) => {
    // Only allow numbers
    const value = event.target.value.replace(/\D/g, "");
    form.value.whatsapp = value;

    if (value.length < 10 || value.length > 15) {
        errors.value.whatsapp = "Nomor WhatsApp harus antara 10-15 digit";
    } else {
        errors.value.whatsapp = "";
    }
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];

    if (file) {
        // Check file size (max 10MB)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes

        if (file.size > maxSize) {
            errors.value.fileUpload = "File tidak boleh lebih dari 10MB";
            selectedFile.value = null;
            form.value.fileUpload = null;
        } else {
            errors.value.fileUpload = "";
            selectedFile.value = file;
            form.value.fileUpload = file;
        }
    }
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const validateForm = () => {
    let isValid = true;

    // Reset errors
    Object.keys(errors.value).forEach((key) => (errors.value[key] = ""));

    // Validate full name
    if (!form.value.fullName.trim()) {
        errors.value.fullName = "Nama lengkap wajib diisi";
        isValid = false;
    }

    // Validate email
    if (!form.value.email.trim()) {
        errors.value.email = "Email wajib diisi";
        isValid = false;
    } else if (!validateEmail(form.value.email)) {
        errors.value.email = "Format email tidak valid";
        isValid = false;
    }

    // Validate WhatsApp
    if (!form.value.whatsapp.trim()) {
        errors.value.whatsapp = "Nomor WhatsApp wajib diisi";
        isValid = false;
    } else if (
        form.value.whatsapp.length < 10 ||
        form.value.whatsapp.length > 15
    ) {
        errors.value.whatsapp = "Nomor WhatsApp harus antara 10-15 digit";
        isValid = false;
    }

    // Validate job description
    if (!form.value.jobDescription.trim()) {
        errors.value.jobDescription = "Deskripsi pekerjaan wajib diisi";
        isValid = false;
    }

    // Validate terms acceptance
    if (!form.value.termsAccepted) {
        errors.value.termsAccepted =
            "Anda harus menyetujui syarat dan ketentuan";
        isValid = false;
    }

    return isValid;
};

const isFormValid = computed(() => {
    return (
        form.value.fullName.trim() !== "" &&
        form.value.email.trim() !== "" &&
        validateEmail(form.value.email) &&
        form.value.whatsapp.trim() !== "" &&
        form.value.whatsapp.length >= 10 &&
        form.value.whatsapp.length <= 15 &&
        form.value.jobDescription.trim() !== "" &&
        form.value.termsAccepted &&
        !errors.value.fileUpload
    );
});

const handleSubmit = async () => {
    if (!validateForm()) {
        return;
    }

    isSubmitting.value = true;

    try {
        const formData = new FormData();

        // Add form fields
        formData.append("freelancer_id", servicePackage.value.freelancer.id);
        formData.append("service_package_id", servicePackage.value.id);
        formData.append("buyer_name", form.value.fullName);
        formData.append("buyer_email", form.value.email);
        formData.append("buyer_whatsapp", form.value.whatsapp);
        formData.append("job_description", form.value.jobDescription);

        // Add file if provided
        if (form.value.fileUpload) {
            formData.append("attachment_file", form.value.fileUpload);
        }

        const response = await axios.post(
            //harus diganti jadi dinamis
            "http://localhost:8000/api/pesanan",
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        );

        if (response.data.success) {
            alert(
                "Order berhasil dibuat! ID Order: " +
                    response.data.data.id_order
            );
            // Reset form
            form.value = {
                fullName: "",
                email: "",
                whatsapp: "",
                jobDescription: "",
                fileUpload: null,
                termsAccepted: false,
            };
            selectedFile.value = null;
            characterCount.value = 0;
        }
    } catch (error) {
        console.error("Error submitting order:", error.response?.data || error);

        if (
            error.response &&
            error.response.status === 422 &&
            error.response.data.errors
        ) {
            // Handle validation errors from Laravel
            const validationErrors = error.response.data.errors;
            let errorMessage = "Terdapat kesalahan pada input Anda:\n";
            for (const field in validationErrors) {
                errorMessage += `- ${validationErrors[field].join(", ")}\n`;
            }
            alert(errorMessage);
        } else if (error.response?.data?.message) {
            // Handle other server errors with a specific message
            alert("Error: " + error.response.data.message);
        } else {
            // Handle network errors or other unexpected issues
            alert("Terjadi kesalahan saat mengirim order. Silakan coba lagi.");
        }
    } finally {
        isSubmitting.value = false;
    }
};

// Fetch service package data
onMounted(async () => {
    try {
        const servicePackageId = route.params.servicePackageId;
        const response = await axios.get(
            `http://localhost:8000/api/layanan/${servicePackageId}`
        );
        servicePackage.value = response.data.data;
    } catch (err) {
        error.value = "Failed to load service package data";
        console.error("Error fetching service package:", err);
    } finally {
        loading.value = false;
    }
});
</script>
