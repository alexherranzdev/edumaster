<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { v4 as uuidv4 } from "uuid"
import api from '../services/api'
import { useAuthStore } from '../stores/auth'
import MainLayout from '../layouts/MainLayout.vue'
import IconClose from '@/components/icons/IconClose.vue'
import Button from '@/components/Button.vue'

const authStore = useAuthStore()
const route = useRoute()
const router = useRouter()

const worksheets = ref([])
const isLoading = ref(true)
const errorMessage = ref(null)
const showModal = ref(false)
const showSubmitModal = ref(false)
const isViewing = ref(false)
const isSubmit = ref(false)
const newWorksheet = ref({
  worksheet_id: null,
  title: '',
  description: '',
  questions: [],
  correct_word: ''
})
const limit = 10
const offset = ref(route.query.page ? (parseInt(route.query.page) - 1) * limit : 0)
const hasMore = ref(false)
const selectedWord = ref({})

const addQuestion = (worksheet) => {
  if (!worksheet.questions) {
    worksheet.questions = []
  }
  
  worksheet.questions.push({
    question_id: uuidv4(),
    question: '',
    words: [],
    correct_word: ''
  })
}

const removeQuestion = async (index) => {
  if (confirm('¿Estás seguro de eliminar esta pregunta?')) {
    newWorksheet.value.questions.splice(index, 1)
  }
}

const addWord = (question) => {
  question.words.push('')
}

const removeWord = (question, index) => {
  question.words.splice(index, 1)
}

const fetchWorksheets = async () => {
  isLoading.value = true
  try {
    let url = `/worksheets?limit=${limit}&offset=${offset.value}`
    if (authStore.isStudent) {
      url += `&with=responses`
    }

    const response = await api.get(url)
    worksheets.value = response.data.data
    hasMore.value = response.data.hasMore
  } catch (error) {
    if (error.status === 401) {
      authStore.logout()
      window.location.reload()
    }
    errorMessage.value = 'Error al cargar las worksheets'
  } finally {
    isLoading.value = false
  }
}

const updatePage = (newOffset) => {
  offset.value = newOffset
  router.push({ query: { page: offset.value / limit + 1 } })
  fetchWorksheets()
}

const nextPage = () => {
  if (hasMore.value) {
    updatePage(offset.value + limit)
  }
}

const prevPage = () => {
  if (offset.value > 0) {
    updatePage(offset.value - limit)
  }
}

const updateWorksheet = async (worksheet) => {
  try {
    await api.put(`/worksheets/${worksheet.worksheet_id}`, worksheet)
    showModal.value = false
    fetchWorksheets()
  } catch (error) {
    console.error('Error updating worksheet:', error)
  }
}

const createWorksheet = async () => {
  try {
    await api.post('/worksheets', newWorksheet.value)
    showModal.value = false
    fetchWorksheets()
  } catch (error) {
    console.error('Error creating worksheet:', error)
  }
}

const saveWorksheet = async () => {
  if (!newWorksheet.value.title) {
    return
  }

  if (
    typeof newWorksheet.value.worksheet_id !== 'undefined' &&
    newWorksheet.value.worksheet_id !== null
  ) {
    await updateWorksheet(newWorksheet.value)
  } else {
    await createWorksheet(newWorksheet.value)
  }
}

const openCreateModal = () => {
  isViewing.value = false
  newWorksheet.value = { title: '', description: '', words: [''] }
  showModal.value = true
}

const openViewModal = (worksheet) => {
  isViewing.value = true
  newWorksheet.value = {...worksheet}
  showModal.value = true
}

const shuffleArray = (array) => {
  return array
    .map(value => ({ value, sort: Math.random() }))
    .sort((a, b) => a.sort - b.sort)
    .map(({ value }) => value)
}

const openSubmitModal = (worksheet) => {
  isSubmit.value = true
  newWorksheet.value = {
    ...worksheet,
    questions: worksheet.questions.map(question => ({
      ...question,
      words: shuffleArray([...question.words])
    }))
  }
  
  showSubmitModal.value = true
}

const deleteWorksheet = async (id) => {
  await api.delete(`/worksheets/${id}`)
}

const handleDelete = async (worksheet) => {
  if (!confirm('¿Estás seguro de eliminar esta ficha de trabajo?')) {
    return
  }

  await deleteWorksheet(worksheet.worksheet_id)
  fetchWorksheets()
}

const addSelectedWord = (question, word) => {
  selectedWord.value[question.question_id] = word
}

const handleSubmitResponse = async () => {
  if (!confirm('¿Estás seguro de quieres enviar tu respuesta?')) {
    return
  }

  await submitResponse()
}

const submitResponse = async () => {
  try {
    const responses = Object.keys(selectedWord.value).map(question_id => ({
      question_id,
      selected_word: selectedWord.value[question_id]
    }))
  
    await api.post(`/worksheets/${newWorksheet.value.worksheet_id}/submit`, {
      responses
    })
    showSubmitModal.value = false
    fetchWorksheets()
  } catch (error) {
    console.error('Error submitting worksheet:', error)
  }
}

watch(() => route.query.page, (newPage) => {
  offset.value = newPage ? (parseInt(newPage) - 1) * limit : 0
  fetchWorksheets()
})

onMounted(fetchWorksheets)
</script>

<template>
  <MainLayout title="Fichas de trabajo" activeMenu="worksheets">
    <div class="flex justify-end mb-4">
      <Button
        v-if="authStore.isTeacher"
        @click="openCreateModal()"
      >
        + Nueva ficha de trabajo
      </Button>
    </div>

    <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
      <thead>
        <tr class="text-left bg-gray-100">
          <th class="px-4 py-2 border-b">Título</th>
          <th class="px-4 py-2 text-center border-b">Preguntas</th>
          <th class="px-4 py-2 border-b" v-if="authStore.isStudent">Estado</th>
          <th class="px-4 py-2 text-right border-b"></th>
        </tr>
      </thead>
      <tbody v-if="isLoading" class="text-center text-gray-500">
        <tr v-for="i in 10" :key="i">
          <td class="px-4 py-2 border-b">
            <span class="block h-6 bg-gray-200 rounded-lg w-36"></span>
          </td>
          <td class="px-4 py-2 text-center border-b">
            <span class="block h-6 mx-auto bg-gray-200 rounded-lg w-36"></span>
          </td>
          <td class="px-4 py-2 border-b">
            <span class="block h-6 bg-gray-200 rounded-lg w-36"></span>
          </td>
          <td class="px-4 py-2 border-b"></td>
        </tr>
      </tbody>
      <tbody v-if="!isLoading">
        <tr v-for="worksheet in worksheets" :key="worksheet.worksheet_id">
          <td class="px-4 py-2 border-b">{{ worksheet.title }}</td>
          <td class="px-4 py-2 text-center border-b" v-if="authStore.isStudent">
            {{ worksheet.responses.length }} / {{ worksheet.questions.length }}
          </td>
          <td class="px-4 py-2 text-center border-b" v-else>
            {{ worksheet.questions.length }}
          </td>
          <td class="px-4 py-2 border-b" v-if="authStore.isStudent">
            <span v-if="worksheet.responses.length === worksheet.questions.length" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Terminado</span>
            <span v-else-if="worksheet.responses.length > 0" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-orange-800 dark:text-yellow-300">Pendiente</span>
            <span v-else class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-200 dark:text-gray-900">Sin empezar</span>
          </td>
          <td class="px-4 py-2 text-right border-b">
            <div class="flex gap-x-2.5 justify-end">
              <Button
                v-if="authStore.isTeacher"
                @click="handleDelete(worksheet)"
                size="sm"
                type="danger"
              >
                Eliminar
              </Button>
              <Button
                v-if="authStore.isTeacher"
                @click="openViewModal(worksheet)"
                size="sm"
              >
                Ver
              </Button>

              <Button
              v-if="authStore.isStudent"
                @click="openSubmitModal(worksheet)"
                size="sm"
              >
                Ver
              </Button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="flex justify-between mt-4">
      <button
      @click="prevPage"
      :disabled="offset === 0"
      class="px-3 py-1 text-white bg-gray-600 rounded-md"
      :class="{ 'opacity-50 cursor-not-allowed': offset === 0 }">
        Anterior
      </button>

      <span>Página: {{ offset / limit + 1 }} </span>

      <button
        @click="nextPage"
        :disabled="!hasMore"
        class="px-3 py-1 text-white bg-gray-600 rounded-md"
        :class="{ 'opacity-50 cursor-not-allowed': !hasMore }"
      >
        Siguiente
      </button>
    </div>

<div
  v-if="showModal"
  class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
>
  <div class="flex flex-col w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg gap-y-4">
    <h3 class="mb-4 text-xl font-semibold">
      {{ isViewing ? 'Detalles de la ficha de trabajo' : 'Nueva ficha de trabajo' }}
    </h3>
    <div class="mb-4">
      <label class="block mb-2 text-sm font-bold text-gray-700">Título</label>
      <input
        v-model="newWorksheet.title"
        type="text"
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
      />
    </div>

    <div class="flex flex-col px-4 mb-4 overflow-y-auto max-h-96 gap-y-4">
      <div
        v-for="(question, index) in newWorksheet.questions"
        :key="question.question_id"
        class="flex flex-col pb-4 mb-4 border-b border-gray-300 border-solid gap-y-2">
        <label class="block mb-2 text-sm font-bold text-gray-700">Pregunta {{  index + 1 }}</label>
        <input
          v-model="question.question"
          type="text"
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
        />

        <button
          @click="removeQuestion(index)"
          class="w-auto px-3 py-1 ml-auto text-sm text-white bg-red-500 rounded-lg hover:bg-red-600 justify-items-end"
          >Eliminar pregunta</button>
      
        <label class="block mb-2 text-sm font-bold text-gray-700">Palabras</label>
        <div
          v-for="(word, index) in question.words"
          :key="index"
          class="flex items-center gap-2 mb-2"
        >
          <input
            v-model="question.words[index]"
            type="text"
            class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
            placeholder="Escribe una palabra"
          />
          <input type="radio"
              v-model="question.correct_word"
              :checked="question.correct_word === question.words[index]"
              :value="question.words[index]"
              class="w-4 h-4 text-primary"
            />
          <button
            v-if="question.words.length > 1"
            @click="removeWord(question, index)"
            class="px-2 py-2 text-white rounded bg-rose-500 hover:bg-rose-600"
          >
            <IconClose :size="16" />
          </button>
        </div>
        <button
          @click="addWord(question)"
          class="w-auto px-3 py-1 ml-auto text-sm text-white rounded-lg bg-emerald-500 hover:bg-emerald-600 justify-items-end"
        >
          + Añadir palabra
        </button>
      </div>
      <button
        @click="addQuestion(newWorksheet)"
        class="w-auto px-3 py-1 ml-auto text-sm text-white rounded-lg bg-emerald-500 hover:bg-emerald-600 justify-items-end"
      >
        + Añadir pregunta
      </button>
    </div>

    <div class="flex justify-end gap-x-2">
      <button
        @click="showModal = false"
        class="px-4 py-2 mr-2 text-white transition bg-gray-400 rounded-lg hover:bg-gray-500"
      >
        Cancelar
      </button>
      <button
        @click="saveWorksheet"
        class="px-4 py-2 text-white transition rounded-lg bg-primary hover:bg-primary-dark"
      >
        Guardar
      </button>
    </div>
  </div>
</div>

<div
  v-if="showSubmitModal"
  class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
>
  <div class="flex flex-col w-full max-w-lg p-6 bg-white rounded-lg shadow-lg gap-y-4">
    <h3 class="mb-4 text-xl font-semibold">
      {{ newWorksheet.title }}
    </h3>
    <p>{{ newWorksheet.description }}</p>

    <section class="flex flex-col gap-y-4">
      <article
        class="pb-4 border-b border-gray-200 border-solid " 
        v-for="question in newWorksheet.questions"
        :key="question.question_id"
        >
        <h3>{{ question.question }}</h3>
        <div
          class="grid grid-cols-2 gap-4 md:grid-cols-3">
          <button
            v-for="word in question.words"
            :key="word"
            @click="addSelectedWord(question, word)"
            class="flex items-center justify-center p-4 text-sm transition-all duration-300 bg-gray-100 border-2 border-transparent border-solid rounded-lg hover:border-primary"
            :class="{ 'bg-primary text-white': selectedWord[question.question_id] === word }"
            >
              {{ word }}
          </button>
        </div>
      </article>
    </section>

    

    <div class="flex justify-end gap-x-2">
      <button
        @click="showSubmitModal = false"
        class="px-4 py-2 mr-2 text-white transition bg-gray-400 rounded-lg hover:bg-gray-500"
      >
        Cancelar
      </button>
      <button
        @click="handleSubmitResponse"
        class="px-4 py-2 text-white transition rounded-lg bg-primary hover:bg-primary-dark"
      >
        Enviar
      </button>
    </div>
  </div>
</div>
  </MainLayout>
</template>
