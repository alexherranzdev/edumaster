<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'primary',
  },
  size: {
    type: String,
    default: 'md',
  },
  isDisabled: {
    type: Boolean,
    default: false,
  },
})

const computedClasses = computed(() => {
  let baseClasses = 'font-medium transition rounded-lg'

  if (props.isDisabled) {
    baseClasses += ` opacity-50 cursor-not-allowed`
  } else {
    baseClasses += ` cursor-pointer`
  }

  const typeClasses = {
    primary: 'bg-primary hover:bg-primary-dark text-white',
    secondary: 'bg-secondary hover:bg-secondary-dark text-white',
    default: 'bg-gray-400 hover:bg-gray-500 text-white',
    success: 'bg-teal-500 hover:bg-teal-600 text-white',
    danger: 'bg-rose-500 hover:bg-rose-600 text-white',
  }

  const sizeClasses = {
    sm: 'text-sm px-3 py-2',
    md: 'text-base px-4 py-2',
    lg: 'text-lg px-6 py-3',
  }

  return `${baseClasses} ${typeClasses[props.type] || typeClasses.primary} ${sizeClasses[props.size] || sizeClasses.md}`
})
</script>

<template>
  <button :disabled="isDisabled" @click="$emit('handleClick')" :class="computedClasses">
    <slot />
  </button>
</template>
