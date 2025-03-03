<script setup>
defineProps(['title', 'value'])
</script>

<template>
  <div class="flex flex-col items-center px-6 py-12 bg-white rounded-lg shadow-md">
    <h3 class="text-lg font-medium text-gray-500">{{ title }}</h3>
    <p class="text-2xl font-bold">{{ value }}</p>
  </div>
</template>
