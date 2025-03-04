<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isLoading = ref(false)

const login = async () => {
  if (!email.value || !password.value) {
    errorMessage.value = 'Por favor, rellena todos los campos'
    return
  }

  isLoading.value = true
  const success = await authStore.login(email.value, password.value)
  if (success) {
    router.push('/dashboard')
  } else {
    errorMessage.value = 'Invalid credentials'
    isLoading.value = false
  }
}
</script>

<template>
  <div class="flex items-center justify-center h-screen text-gray-800 bg-white">
    <div class="hidden w-2/3 h-screen lg:block">
      <img
        src="https://habitacion.com/wp-content/uploads/2023/05/bedroom-2-1536x1097.jpg"
        alt="Placeholder Image"
        class="object-cover w-full h-full"
      />
    </div>
    <div class="w-full p-8 lg:p-21 md:p-52 sm:20 lg:w-1/3">
      <form action="#" method="POST" class="flex flex-col gap-y-2.5">
        <div>
          <label for="username" class="block text-gray-600">Usuario</label>
          <input
            placeholder="Escribe tu correo"
            v-model="email"
            type="text"
            id="username"
            name="username"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary"
            autocomplete="off"
          />
        </div>
        <div>
          <label for="password" class="block text-gray-800">Contraseña</label>
          <input
            placeholder="*************"
            v-model="password"
            type="password"
            id="password"
            name="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
            autocomplete="off"
            @keyup.enter="login"
          />
        </div>
        <p v-if="errorMessage" class="mt-2 text-red-500">{{ errorMessage }}</p>
        <button
          type="button"
          @click="login"
          disabled="isLoading"
          class="w-full px-4 py-2 font-semibold text-white rounded-md bg-primary hover:bg-blue-600"
          :class="{ 'cursor-not-allowed opacity-50': isLoading }"
        >
          {{ isLoading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>
    </div>
  </div>
</template>
