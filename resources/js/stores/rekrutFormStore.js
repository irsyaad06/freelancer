import { defineStore } from "pinia";
import axios from "../axios";
import { useSettingStore } from "./settingStore";

export const useRekrutFormStore = defineStore("rekrutForm", {
    state: () => ({
        servicePackage: null,
        loading: true,
        error: null,
        isSubmitting: false,
        showOrderModal: false,
        orderDetails: {},
        form: {
            fullName: "",
            email: "",
            whatsapp: "",
            jobDescription: "",
            fileUpload: null,
            termsAccepted: false,
        },
        errors: {
            fullName: "",
            email: "",
            whatsapp: "",
            jobDescription: "",
            fileUpload: "",
            termsAccepted: "",
        },
        selectedFile: null,
        characterCount: 0,
    }),

    getters: {
        isFormValid() {
            return (
                this.form.fullName.trim() !== "" &&
                this.form.email.trim() !== "" &&
                this.validateEmail(this.form.email) &&
                this.form.whatsapp.trim() !== "" &&
                this.form.whatsapp.length >= 10 &&
                this.form.whatsapp.length <= 15 &&
                this.form.jobDescription.trim() !== "" &&
                this.form.termsAccepted &&
                !this.errors.fileUpload
            );
        },
    },

    actions: {
        updateCharacterCount() {
            this.characterCount = this.form.jobDescription.length;
        },

        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        validateWhatsApp() {
            const value = this.form.whatsapp.replace(/\D/g, "");
            this.form.whatsapp = value;

            if (value.length < 10 || value.length > 15) {
                this.errors.whatsapp = "Nomor WhatsApp harus antara 10-15 digit";
            } else {
                this.errors.whatsapp = "";
            }
        },

        handleFileUpload(event) {
            const file = event.target.files[0];

            if (file) {
                const maxSize = 25 * 1024 * 1024;
                if (file.size > maxSize) {
                    this.errors.fileUpload = "File tidak boleh lebih dari 25MB";
                    this.selectedFile = null;
                    this.form.fileUpload = null;
                } else {
                    this.errors.fileUpload = "";
                    this.selectedFile = file;
                    this.form.fileUpload = file;
                }
            }
        },

        formatFileSize(bytes) {
            if (bytes === 0) return "0 Bytes";
            const k = 1024;
            const sizes = ["Bytes", "KB", "MB", "GB"];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return (
                parseFloat((bytes / Math.pow(k, i)).toFixed(2)) +
                " " +
                sizes[i]
            );
        },

        validateForm() {
            let isValid = true;
            Object.keys(this.errors).forEach((key) => (this.errors[key] = ""));

            if (!this.form.fullName.trim()) {
                this.errors.fullName = "Nama lengkap wajib diisi";
                isValid = false;
            }
            if (!this.form.email.trim()) {
                this.errors.email = "Email wajib diisi";
                isValid = false;
            } else if (!this.validateEmail(this.form.email)) {
                this.errors.email = "Format email tidak valid";
                isValid = false;
            }
            if (!this.form.whatsapp.trim()) {
                this.errors.whatsapp = "Nomor WhatsApp wajib diisi";
                isValid = false;
            } else if (
                this.form.whatsapp.length < 10 ||
                this.form.whatsapp.length > 15
            ) {
                this.errors.whatsapp = "Nomor WhatsApp harus antara 10-15 digit";
                isValid = false;
            }
            if (!this.form.jobDescription.trim()) {
                this.errors.jobDescription = "Deskripsi pekerjaan wajib diisi";
                isValid = false;
            }
            if (!this.form.termsAccepted) {
                this.errors.termsAccepted = "Anda harus menyetujui syarat dan ketentuan";
                isValid = false;
            }

            return isValid;
        },

        async fetchServicePackage(id) {
            this.loading = true;
            try {
                const response = await axios.get(`/layanan/${id}`);
                this.servicePackage = response.data.data;
            } catch (err) {
                this.error = "Failed to load service package data";
                console.error("Error fetching service package:", err);
            } finally {
                this.loading = false;
            }
        },

        async submitOrder() {
            if (!this.validateForm()) {
                return;
            }

            this.isSubmitting = true;

            try {
                const formData = new FormData();
                formData.append("freelancer_id", this.servicePackage.freelancer.id);
                formData.append("service_package_id", this.servicePackage.id);
                formData.append("buyer_name", this.form.fullName);
                formData.append("buyer_email", this.form.email);
                formData.append("buyer_whatsapp", this.form.whatsapp);
                formData.append("job_description", this.form.jobDescription);
                if (this.form.fileUpload) {
                    formData.append("attachment_file", this.form.fileUpload);
                }

                const response = await axios.post("/pesanan", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                if (response.data.success) {
                    this.orderDetails = {
                        orderNumber: response.data.data.id_order,
                        email: this.form.email,
                        whatsapp: this.form.whatsapp,
                        serviceName: `Pembuatan ${this.servicePackage.subcategory.name}`,
                        packageName: this.servicePackage.title,
                        freelancerName: this.servicePackage.freelancer.name,
                    };
                    this.showOrderModal = true;
                }
            } catch (error) {
                console.error("Error submitting order:", error.response?.data || error);
                if (
                    error.response &&
                    error.response.status === 422 &&
                    error.response.data.errors
                ) {
                    const validationErrors = error.response.data.errors;
                    let errorMessage = "Terdapat kesalahan pada input Anda:\n";
                    for (const field in validationErrors) {
                        errorMessage += `- ${validationErrors[field].join(", ")}\n`;
                    }
                    alert(errorMessage);
                } else if (error.response?.data?.message) {
                    alert("Error: " + error.response.data.message);
                } else {
                    alert("Terjadi kesalahan saat mengirim order. Silakan coba lagi.");
                }
            } finally {
                this.isSubmitting = false;
            }
        },

        closeOrderModal() {
            this.showOrderModal = false;
            const settingStore = useSettingStore();

            if (settingStore.setting && settingStore.setting.telepon_web) {
                const message = `Halo, saya ingin konfirmasi pesanan dengan detail berikut:
- No Pesanan: ${this.orderDetails.orderNumber}
- Email: ${this.orderDetails.email}
- Jasa: ${this.orderDetails.serviceName}
- Paket: ${this.orderDetails.packageName}
- Freelancer: ${this.orderDetails.freelancerName}`;
                const encodedMessage = encodeURIComponent(message);
                window.open(
                    `https://wa.me/${settingStore.setting.telepon_web}?text=${encodedMessage}`,
                    "_blank"
                );
            }
            this.resetForm();
        },

        resetForm() {
            this.form = {
                fullName: "",
                email: "",
                whatsapp: "",
                jobDescription: "",
                fileUpload: null,
                termsAccepted: false,
            };
            this.selectedFile = null;
            this.characterCount = 0;
            Object.keys(this.errors).forEach((key) => (this.errors[key] = ""));
        },
    },
});
