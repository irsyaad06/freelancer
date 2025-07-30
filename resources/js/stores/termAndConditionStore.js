import { defineStore } from "pinia";
import axios from "../axios";

export const useTermTC = defineStore("term", {
  state: () => ({
    term: null,
    loading: false,
    error: null,
  }),
  actions: {
    async fetchTerm(force = false) {
      // console.log("🔥 fetchTerm terpanggil, force:", force);

      if (this.term && !force) {
        console.log("⛔ Skip fetch karena data sudah ada");
        return;
      }

      this.loading = true;
      this.error = null;

      try {
        const response = await axios.get("/term");
        // console.log("✅ Response API:", response.data);

        // Ambil data pertama dari array
        this.term = response.data.data[0];
        // console.log("📦 term terisi:", this.term);
      } catch (err) {
        this.error = err;
        // console.error("❌ Gagal mengambil data:", err);
      } finally {
        this.loading = false;
      }
    },
  },
});
