import { defineStore } from 'pinia'
import api from '../services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    isStudent: (state) => state.user?.role === 'student',
    isTeacher: (state) => state.user?.role === 'teacher',
  },
  actions: {
    async login(email, password) {
      try {
        const response = await api.post('/login', { email, password })
        this.user = response.data.user
        this.token = response.data.token
        localStorage.setItem('user', JSON.stringify(this.user))
        localStorage.setItem('token', this.token)
        return true
      } catch (error) {
        console.error('Login failed:', error.response.data)
        return false
      }
    },

    logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('user')
      localStorage.removeItem('token')
    },
  },
})
