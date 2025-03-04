<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useAuthStore } from '../stores/auth'
import MainLayout from '../layouts/MainLayout.vue'
import BaseButton from '../components/BaseButton.vue'

const authStore = useAuthStore()

const teachers = ref([])
const isLoading = ref(true)
const isViewing = ref(false)
const isSaving = ref(false)
const errorMessage = ref(null)
const errorFormMessage = ref(null)
const showModal = ref(false)
const newUser = ref({ name: '', email: '', password: '', role: 'teacher' })
const errorsForm = {}

const fetchTeachers = async () => {
  try {
    const response = await api.get('/users?role=teacher')
    teachers.value = response.data
  } catch {
    errorMessage.value = 'Error al cargar alumnos'
  } finally {
    isLoading.value = false
  }
}

const openCreateModal = () => {
  errorFormMessage.value = null
  newUser.value = { name: '', email: '', role: 'teacher' }
  showModal.value = true
}

const openViewModal = (student) => {
  isViewing.value = true
  errorFormMessage.value = null
  newUser.value = { ...student }
  showModal.value = true
}

const updateUser = async (user) => {
  try {
    await api.put(`/users/${user.user_id}`, user)
    showModal.value = false
    fetchTeachers()
  } catch (error) {
    console.error('Error updating user:', error)
  }
}

const createUser = async (user) => {
  try {
    isSaving.value = true
    await api.post(`/register`, user)
    showModal.value = false
    fetchTeachers()
  } catch (error) {
    if (error.response.data.message) {
      errorFormMessage.value = error.response.data.message
    }
  } finally {
    isSaving.value = false
  }
}

const saveUser = async () => {
  if (typeof newUser.value.user_id !== 'undefined' && newUser.value.user_id !== null) {
    await updateUser(newUser.value)
  } else {
    await createUser(newUser.value)
  }
}

const deleteStudent = async (student) => {
  await api.delete(`/users/${student.user_id}`)
}

const handleDelete = async (student) => {
  if (!confirm('¿Estás seguro de eliminar este profesor?')) {
    return
  }

  await deleteStudent(student)
  fetchTeachers()
}

const validatePassword = (event) => {
  const password = event.target.value
  if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/)) {
    errorsForm.password =
      'La contraseña debe contener al menos una letra mayúscula, una letra minúscula y un número'
  } else {
    delete errorsForm.password
  }
}

onMounted(fetchTeachers)
</script>

<template>
  <MainLayout title="Profesores" activeMenu="teachers">
    <div class="flex justify-end mb-4">
      <BaseButton v-if="authStore.isTeacher" @handleClick="openCreateModal()">
        + Añadir profesor
      </BaseButton>
    </div>

    <div v-if="isLoading" class="text-center text-gray-500">Cargando profesores...</div>
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
        <tr v-for="teacher in teachers" :key="teacher.id">
          <td class="px-4 py-2 border-b">{{ teacher.name }}</td>
          <td class="px-4 py-2 border-b">{{ teacher.email }}</td>
          <td class="px-4 py-2 text-right border-b">
            <div class="flex gap-x-2.5 justify-end">
              <BaseButton @handleClick="openViewModal(teacher)" size="sm">Ver</BaseButton>
              <BaseButton @handleClick="handleDelete(teacher)" size="sm" type="danger">Eliminar</BaseButton>
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
          {{ isViewing ? 'Detalles del profesor' : 'Nuevo profesor' }}
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
          <BaseButton @handleClick="showModal = false" type="default">Cancelar</BaseButton>
          <BaseButton
            @handleClick="saveUser"
            :is-disabled="isSaving"
            :class="{ 'opacity-50 cursor-not-allowed': isSaving }"
          >
            {{ isSaving ? 'Guardando...' : 'Guardar' }}
          </BaseButton>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
