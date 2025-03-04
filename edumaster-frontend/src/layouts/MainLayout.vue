<script setup>
import { defineProps } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

import Navigation from '../components/Navigation.vue'
import Logout from '../components/icons/Logout.vue'

const authStore = useAuthStore()
const router = useRouter()

const logout = () => {
  authStore.logout()
  router.push('/')
}

defineProps({
  title: String,
  activeMenu: String,
})
</script>
<template>
  <div class="flex flex-col items-center min-h-screen bg-gray-100">
    <nav class="w-full bg-white shadow-md">
      <div class="flex items-center justify-between w-full h-16 px-6 lg:px-8">
        <div class="flex items-center gap-x-2">
          <img
            class="size-8"
            src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
            alt="EduMaster Logo"
            
          />
          <h1 class="text-lg font-semibold text-gray-800">EduMaster</h1>
        </div>

        <Navigation :active-menu="activeMenu" />

        <!-- Profile Menu -->
        <div class="flex items-center gap-4">
          <button class="text-gray-500 cursor-pointer hover:text-gray-700" @click="logout">
            <Logout size="24" color="#666" />
          </button>
          <div class="relative">
            <button class="flex items-center space-x-2 focus:outline-none">
              <img
                class="w-8 h-8 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="User Avatar"
              />
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main class="container flex flex-col px-6 py-8 gap-y-8">
      <h2 class="text-2xl font-semibold text-gray-700">{{ title }}</h2>
      <slot />
    </main>
  </div>
</template>
