import { defineStore } from 'pinia'
import api from '../axios'

export const useFreelancerStore = defineStore('freelancer', {
  state: () => ({
    freelancers: [],
    loading: false,
    error: null,
    selectedSubcategory: null,
    freelancerDetail: null,
  }),

  getters: {
    getFreelancers: (state) => state.freelancers,
    isLoading: (state) => state.loading,
    hasError: (state) => state.error !== null,
  },

  actions: {
    async fetchFreelancers() {
      this.loading = true
      this.error = null
      this.selectedSubcategory = null
      
      try {
        // Use the main freelancer endpoint to get all freelancers
        const response = await api.get('/freelancer')
        
        if (response.data.code === 200) {
          this.freelancers = response.data.data
        } else {
          throw new Error(response.data.message || 'Failed to fetch freelancers')
        }
      } catch (error) {
        this.error = error.message || 'An error occurred while fetching freelancers'
        console.error('Error fetching freelancers:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchFreelancersBySubcategory(subcategory) {
      this.loading = true
      this.error = null
      this.selectedSubcategory = subcategory

      try {
        const response = await api.get(`/freelancer/subkategori/${subcategory.id}`)
        
        if (response.data.code === 200) {
          this.freelancers = response.data.data
        } else {
          throw new Error(response.data.message || 'Failed to fetch freelancers')
        }
      } catch (error) {
        this.error = error.message || 'An error occurred while fetching freelancers'
        console.error('Error fetching freelancers:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchFreelancerDetail(subcategoryId, freelancerId) {
      this.loading = true;
      this.error = null;
      this.freelancerDetail = null;

      try {
        const response = await api.get(`/jasa/${subcategoryId}/freelancer/${freelancerId}`);
        if (response.data.code === 200) {
          const detail = response.data.data;
          
          // Sort service packages
          if (detail.servicePackages) {
            const packageOrder = { 'starter': 1, 'standard': 2, 'premium': 3 };
            detail.servicePackages.sort((a, b) => {
              const orderA = packageOrder[a.name.toLowerCase()] || 99;
              const orderB = packageOrder[b.name.toLowerCase()] || 99;
              return orderA - orderB;
            });
          }
          
          this.freelancerDetail = detail;
        } else {
          throw new Error(response.data.message || 'Failed to fetch freelancer detail');
        }
      } catch (error) {
        this.error = error.message || 'An error occurred while fetching freelancer detail';
        console.error('Error fetching freelancer detail:', error);
      } finally {
        this.loading = false;
      }
    },

    clearError() {
      this.error = null
    }
  }
})
