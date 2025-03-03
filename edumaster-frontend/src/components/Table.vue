<script setup>
const users = [
  { id: 1, name: 'Alice', email: 'alice@example.com', role: 'Admin' },
  { id: 2, name: 'Bob', email: 'bob@example.com', role: 'User' },
  { id: 3, name: 'Charlie', email: 'charlie@example.com', role: 'Editor' },
]
</script>

<template>
  <table class="w-full border-collapse">
    <thead>
      <tr class="bg-gray-200">
        <th class="p-3 text-left">Name</th>
        <th class="p-3 text-left">Email</th>
        <th class="p-3 text-left">Role</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in users" :key="user.id" class="border-t">
        <td class="p-3">{{ user.name }}</td>
        <td class="p-3">{{ user.email }}</td>
        <td class="p-3">{{ user.role }}</td>
      </tr>
    </tbody>
  </table>
</template>
