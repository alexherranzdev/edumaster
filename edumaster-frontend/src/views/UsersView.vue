<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import Table from '../components/Table.vue'
</script>

<template>
  <MainLayout title="Users" activeMenu="users">
    <section class="bg-white p-6 rounded-lg shadow-lg">
      <Table />
    </section>
  </MainLayout>
</template>
