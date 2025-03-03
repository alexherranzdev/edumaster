import axios from 'axios'
import { API_URL } from '../config'
import { useAuthStore } from '../stores/auth'

const api = axios.create({
  baseURL: API_URL,
  headers: { 'Content-Type': 'application/json' },
})

api.interceptors.request.use(
  (config) => {
    const authStore = useAuthStore()
    if (authStore.token) {
      config.headers.Authorization = `Bearer ${authStore.token}`
    }
    return config
  },
  (error) => {
    // if error status is 401, logout
    if (error.response.status === 401) {
      useAuthStore().logout()
      window.location.reload()
    }

    return Promise.reject(error)
  },
)

export default api
