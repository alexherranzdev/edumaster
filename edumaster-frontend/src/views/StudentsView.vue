<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useAuthStore } from '../stores/auth'
import MainLayout from '../layouts/MainLayout.vue'

const authStore = useAuthStore()

const students = ref([])
const isLoading = ref(true)
const isViewing = ref(false)
const isSaving = ref(false)
const errorMessage = ref(null)
const errorFormMessage = ref(null)
const showModal = ref(false)
const newUser = ref({ name: '', email: '', password: '', role: 'student' })
const errorsForm = {}

const fetchStudents = async () => {
  try {
    const response = await api.get('/users')
    students.value = response.data
  } catch (error) {
    errorMessage.value = 'Failed to load students'
  } finally {
    isLoading.value = false
  }
}

const openViewModal = (student) => {
  isViewing.value = true
  errorFormMessage.value = null
  newUser.value = {...student}
  showModal.value = true
}

const openCreateModal = () => {
  isViewing.value = false
  errorFormMessage.value = null
  newUser.value = { name: '', email: '', role: 'student' }
  showModal.value = true
}

const validatePassword = (event) => {
  const password = event.target.value
  if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/)) {
    errorsForm.password = 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula y un número'
  } else {
    delete errorsForm.password
  }
}

const updateUser = async (user) => {
  try {
    await api.put(`/users/${user.user_id}`, user)
    showModal.value = false
    fetchStudents()
  } catch (error) {
    console.error('Error updating user:', error)
  }
}

const createUser = async (user) => {
  try {
    isSaving.value = true
    await api.post(`/register`, user)
    showModal.value = false
    fetchStudents()
  } catch (error) {
    if (error.response.data.message) {
      errorFormMessage.value = error.response.data.message
    }
  } finally {
    isSaving.value = false
  }
}

const saveUser = async () => {
  if (
    typeof newUser.value.user_id !== 'undefined' &&
    newUser.value.user_id !== null
  ) {
    await updateUser(newUser.value)
  } else {
    await createUser(newUser.value)
  }
}

const deleteStudent = async (student) => {
  await api.delete(`/users/${student.user_id}`)
}

const handleDelete = async (student) => {
  if (!confirm('¿Estás seguro de eliminar este alumno?')) {
    return
  }
  
  await deleteStudent(student)
  fetchStudents()
}

onMounted(fetchStudents)
</script>

<template>
  <MainLayout title="Alumnos" activeMenu="students">
    <div class="flex justify-end mb-4">
      <button
        v-if="authStore.isTeacher"
        @click="openCreateModal()"
        class="px-4 py-2 text-white transition rounded-lg cursor-pointer bg-primary hover:bg-primary-dark"
      >
        + Añadir alumno
      </button>
    </div>

    <div v-if="isLoading" class="text-center text-gray-500">Loading students...</div>
    <div v-else-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
    <table v-else class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
      <thead>
        <tr class="text-left bg-gray-100">
          <th class="px-4 py-2 border-b">Nombre</th>
          <th class="px-4 py-2 border-b">Email</th>
          <th class="px-4 py-2 border-b"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="student in students" :key="student.id">
          <td class="px-4 py-2 border-b">{{ student.name }}</td>
          <td class="px-4 py-2 border-b">{{ student.email }}</td>
          <td class="px-4 py-2 text-right border-b">
            <div class="flex gap-x-2.5 justify-end">
              <button
                v-if="authStore.isTeacher"
                @click="openViewModal(student)"
                class="px-3 py-1 text-sm text-white rounded-md bg-primary hover:bg-primary-dark"
              >
                Ver
              </button>
              <button
                v-if="authStore.isTeacher"
                @click="handleDelete(student)"
                class="px-3 py-1 text-sm text-white rounded-md bg-rose-500 hover:bg-rose-600" 
              >
                Eliminar
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div
      v-if="showModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="flex flex-col w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg gap-y-4">
        <h3 class="mb-4 text-xl font-semibold">
          {{ isViewing ? 'Detalles del alumno' : 'Nuevo alumno' }}
        </h3>
        <div class="flex flex-col mb-4 gap-y-2">
          <label class="block mb-2 text-sm font-bold text-gray-700">Nombre</label>
          <input
            v-model="newUser.name"
            type="text"
            placeholder="Escribe el nombre"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
          />
        </div>

        <div class="flex flex-col mb-4 gap-y-2">
          <label class="block mb-2 text-sm font-bold text-gray-700">Email</label>
          <input
            v-model="newUser.email"
            type="email"
            placeholder="ejemplo@edumaster.dev"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
          />
        </div>

        <div class="flex flex-col mb-4 gap-y-2">
          <label class="block mb-2 text-sm font-bold text-gray-700">Contraseña</label>
          <input
            v-model="newUser.password"
            type="password"
            placeholder="*********"
            @input="validatePassword"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
          />
          <p v-if="errorsForm.password" class="text-sm text-red-500">{{ errorsForm.password }}</p>
        </div>

        <div if="errorFormMessage" class="text-red-500">{{ errorFormMessage }}</div>

        <div class="flex justify-end gap-x-2">
          <button
            @click="showModal = false"
            class="px-4 py-2 mr-2 text-white transition bg-gray-400 rounded-lg hover:bg-gray-500"
          >
            Cancelar
          </button>
          <button
            @click="saveUser"
            :disabled="isSaving"
            class="px-4 py-2 text-white transition rounded-lg bg-primary hover:bg-primary-dark"
            :class="{ 'opacity-50 cursor-not-allowed': isSaving }"
          >
            {{ isSaving ? 'Guardando...' : 'Guardar' }}
          </button>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
