<template>
  <button
    :type="type"
    :disabled="disabled"
    :class="[
      'font-semibold rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2',
      sizeClass,
      variantClass,
      disabledClass,
      className
    ]"
    :aria-label="ariaLabel"
    @click="$emit('click', $event)"
  >
    <span v-if="loading" class="flex items-center justify-center gap-2">
      <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
      </svg>
      <span v-if="loadingText">{{ loadingText }}</span>
    </span>
    <span v-else class="flex items-center justify-center gap-2">
      <slot />
    </span>
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'primary', // 'primary', 'secondary', 'success', 'danger', 'warning', 'outline', 'ghost'
  },
  size: {
    type: String,
    default: 'md', // 'sm', 'md', 'lg', 'xl'
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  loadingText: {
    type: String,
    default: '',
  },
  type: {
    type: String,
    default: 'button',
  },
  className: {
    type: String,
    default: '',
  },
  ariaLabel: {
    type: String,
    default: '',
  },
});

defineEmits(['click']);

const sizeClass = computed(() => {
  const sizeMap = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-base',
    lg: 'px-6 py-3 text-lg',
    xl: 'px-8 py-4 text-xl',
  };
  return sizeMap[props.size] || sizeMap.md;
});

const variantClass = computed(() => {
  const variantMap = {
    primary: 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 shadow-soft hover:shadow-medium',
    secondary: 'bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500 shadow-soft hover:shadow-medium',
    success: 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 shadow-soft hover:shadow-medium',
    danger: 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 shadow-soft hover:shadow-medium',
    warning: 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500 shadow-soft hover:shadow-medium',
    outline: 'bg-transparent border-2 border-primary-600 text-primary-600 hover:bg-primary-50 focus:ring-primary-500',
    ghost: 'bg-transparent text-primary-600 hover:bg-primary-50 focus:ring-primary-500',
  };
  return variantMap[props.variant] || variantMap.primary;
});

const disabledClass = computed(() => {
  if (props.disabled || props.loading) {
    return 'opacity-50 cursor-not-allowed';
  }
  return '';
});
</script>

