<script setup>
import { ref, onMounted } from 'vue'

import MainLayout from '../layouts/MainLayout.vue'
import KPI from '../components/KPI.vue'
import api from '../services/api'
import { useAuthStore } from '../stores/auth'

const totalWorksheets = ref(0)
const totalCompletedWorksheets = ref(0)
const totalInProgressWorksheets = ref(0)

const fetchTotals = async () => {
  try {
    const response = await api.get('/stats/totals')
    totalWorksheets.value = response.data.total_worksheets
    totalInProgressWorksheets.value = response.data.total_in_progress_worksheets
    totalCompletedWorksheets.value = response.data.total_completed_worksheets
  } catch (error) {
    if (error.status === 401) {
      useAuthStore().logout()
      window.location.reload()
    }
    console.error('Failed to fetch totals:', error)
  }
}

onMounted(fetchTotals)
</script>

<template>
  <MainLayout title="Dashboard" activeMenu="dashboard">
    <section class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
      <KPI title="Fichas Totales" :value="totalWorksheets" />
      <KPI title="Fichas empezadas" :value="totalInProgressWorksheets" />
      <KPI title="Fichas completadas" :value="totalCompletedWorksheets" />
    </section>
  </MainLayout>
</template>
