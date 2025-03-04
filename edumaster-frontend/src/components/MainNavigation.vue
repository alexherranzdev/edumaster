<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()
const isOpen = ref(false)

defineProps({
  activeMenu: String,
})

const menu = []
menu.push({
  name: 'Dashboard',
  path: '/dashboard',
})

if (authStore.isTeacher) {
  menu.push({
    name: 'Alumnos',
    path: '/students',
  })

  menu.push({
    name: 'Profesores',
    path: '/teachers',
  })
}

menu.push({
  name: 'Fichas de trabajo',
  path: '/worksheets',
})

const closeMenu = () => {
  isOpen.value = false
}
</script>

<template>
  <!-- Contenedor del menú -->
  <div class="relative ml-auto md:mx-auto">
    <!-- Botón hamburguesa en móviles -->
    <button @click="isOpen = !isOpen" class="p-2 text-gray-600 md:hidden focus:outline-none">
      <svg v-if="!isOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16m-7 6h7"
        />
      </svg>
      <svg v-else class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M6 18L18 6M6 6l12 12"
        />
      </svg>
    </button>

    <!-- Menú en pantalla completa para móviles -->
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-gray-900 bg-opacity-90 md:hidden"
    >
      <button @click="isOpen = false" class="absolute text-3xl text-white top-4 right-4">
        &times;
      </button>

      <nav class="flex flex-col space-y-6 text-xl text-white">
        <RouterLink
          v-for="item in menu"
          :key="item.name"
          :to="item.path"
          @click="closeMenu"
          :class="{ 'text-primary font-semibold': '/' + activeMenu === item.path }"
          class="hover:text-primary"
        >
          {{ item.name }}
        </RouterLink>
      </nav>
    </div>

    <!-- Menú normal en escritorio -->
    <div class="hidden md:flex gap-x-6">
      <RouterLink
        v-for="item in menu"
        :key="item.name"
        :to="item.path"
        :class="{ 'text-primary font-semibold': '/' + activeMenu === item.path }"
        class="text-gray-600 hover:text-primary"
      >
        {{ item.name }}
      </RouterLink>
    </div>
  </div>
</template>
