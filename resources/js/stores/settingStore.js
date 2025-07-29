import { defineStore } from 'pinia';
import axios from '../axios';

export const useSettingStore = defineStore('setting', {
  state: () => ({
    setting: null,
    loading: false,
    error: null,
  }),
  actions: {
    async fetchSetting() {
      this.loading = true;
      try {
        const response = await axios.get('/pengaturan');
        this.setting = response.data;
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },
  },
});
