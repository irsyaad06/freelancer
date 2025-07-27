    <template>
        <!-- Main modal -->
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center bg-blue-600/50"
            @click.self="$emit('close')"
        >
            <div class="relative p-4 w-full max-w-xl max-h-[80vh]">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 flex flex-col"
                    style="max-height: 80vh;"
                >
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200 flex-shrink-0"
                    >
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white"
                        >
                            Syarat dan Ketentuan
                        </h3>
                        <button
                            type="button"
                            @click="$emit('close')"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4 overflow-y-auto flex-1">
                        <h4 class="font-semibold text-lg mb-2">1. Ketentuan Umum</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            Dengan menggunakan layanan ini, Anda setuju untuk mematuhi semua syarat dan ketentuan yang berlaku. 
                            Layanan ini disediakan oleh platform freelancer untuk memfasilitasi transaksi antara klien dan freelancer.
                        </p>
                        
                        <h4 class="font-semibold text-lg mb-2">2. Hak dan Kewajiban</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            - Klien wajib memberikan informasi yang akurat dan lengkap mengenai proyek yang akan dikerjakan.<br>
                            - Freelancer berkewajiban untuk menyelesaikan pekerjaan sesuai dengan kesepakatan yang telah disetujui.<br>
                            - Pembayaran akan diproses melalui platform dengan sistem escrow untuk keamanan kedua belah pihak.
                        </p>

                        <h4 class="font-semibold text-lg mb-2">3. Kebijakan Pembatalan</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            Pembatalan dapat dilakukan sesuai dengan ketentuan yang telah disepakati dalam kontrak kerja. 
                            Setiap pembatalan akan dikenakan biaya administrasi sesuai dengan kebijakan platform.
                        </p>

                        <h4 class="font-semibold text-lg mb-2">4. Privasi dan Keamanan</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            Kami menjaga kerahasiaan data pribadi Anda sesuai dengan kebijakan privasi kami. 
                            Semua transaksi dilakukan dengan sistem keamanan yang terenkripsi.
                        </p>

                        <h4 class="font-semibold text-lg mb-2">5. Kebijakan Pembayaran</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            - Pembayaran dilakukan melalui platform dengan sistem milestone.<br>
                            - Dana akan disimpan dalam escrow hingga pekerjaan selesai sesuai kesepakatan.<br>
                            - Refund dapat diajukan sesuai dengan ketentuan yang berlaku.
                        </p>

                        <h4 class="font-semibold text-lg mb-2">6. Penyelesaian Sengketa</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            Setiap sengketa akan diselesaikan melalui mediasi terlebih dahulu. 
                            Jika tidak tercapai kesepakatan, maka akan dilakukan arbitrase sesuai dengan hukum yang berlaku.
                        </p>

                        <h4 class="font-semibold text-lg mb-2">7. Perubahan Syarat</h4>
                        <p
                            class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                        >
                            Kami berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu. 
                            Perubahan akan diberitahukan melalui email atau notifikasi dalam platform.
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 flex-shrink-0"
                    >
                        <button
                            @click="$emit('close')"
                            type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Saya Setuju
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script setup>
    defineProps({
        show: {
            type: Boolean,
            default: false
        }
    });

    defineEmits(['close']);
    </script>
