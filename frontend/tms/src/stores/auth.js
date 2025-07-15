import { defineStore } from 'pinia'
import axios from 'axios'

const API_URL = '/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    isLoading: false
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    isAdmin: (state) => state.user?.role === 'admin'
  },

  actions: {
    async login(credentials) {
      this.isLoading = true
      try {
        const response = await axios.post(`${API_URL}/login`, credentials)
        this.token = response.data.token
        this.user = response.data.user
        
        // Set default auth header
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        
        return response.data
      } catch (error) {
        throw error.response?.data || error
      } finally {
        this.isLoading = false
      }
    },

    async logout() {
      try {
        await axios.post(`${API_URL}/logout`)
      } catch (error) {
        console.error('Logout error:', error)
      }
      
      this.token = null
      this.user = null
      delete axios.defaults.headers.common['Authorization']
    },

    async fetchUser() {
      if (!this.token) return
      
      try {
        const response = await axios.get(`${API_URL}/me`)
        this.user = response.data
      } catch {
        this.logout()
      }
    },

    initializeAuth() {
      const token = localStorage.getItem('token')
      const user = localStorage.getItem('user')
      
      if (token && user) {
        this.token = token
        this.user = JSON.parse(user)
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      }
    }
  }
})