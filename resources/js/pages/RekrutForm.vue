<template>
    <div>
        <div class="max-w-screen-xl mx-auto p-4 mt-10 pt-10">
            <span class="text-2xl font-semibold">Form Rekrut Freelancer</span>

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
                    <p v-if="errors.fullName" class="mt-1 text-sm text-red-600">
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
                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">
                        {{ errors.email }}
                    </p>
                </div>

                <!-- Nomor WhatsApp -->
                <div class="mb-4">
                    <label
                        for="whatsapp"
                        class="block mb-2 text-sm font-medium text-gray-900"
                    >
                        Nomor WhatsApp <span class="text-red-500">*</span>
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
                    <p v-if="errors.whatsapp" class="mt-1 text-sm text-red-600">
                        {{ errors.whatsapp }}
                    </p>
                </div>

                <!-- Deskripsi Pekerjaan -->
                <div class="mb-4">
                    <label
                        for="jobDescription"
                        class="block mb-2 text-sm font-medium text-gray-900"
                    >
                        Deskripsi Pekerjaan <span class="text-red-500">*</span>
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
                    <p v-if="selectedFile" class="mt-1 text-sm text-green-600">
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
                            <a href="#" class="text-blue-600 hover:underline"
                                >syarat dan ketentuan</a
                            >
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
                    :disabled="!isFormValid"
                    :class="[
                        'w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center',
                        isFormValid
                            ? 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300'
                            : 'bg-gray-400 cursor-not-allowed',
                    ]"
                >
                    Lanjutkan
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

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

const handleSubmit = () => {
    if (validateForm()) {
        // Form is valid, proceed with submission
        console.log("Form submitted:", form.value);
        alert("Form berhasil dikirim!");
        // Here you would typically send the data to your API
    }
};
</script>
