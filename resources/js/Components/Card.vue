<template>
  <div
    :class="[
      'bg-white rounded-2xl shadow-soft transition-all duration-300',
      paddingClass,
      hoverClass,
      className
    ]"
    :style="style"
  >
    <slot />
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  padding: {
    type: String,
    default: 'default', // 'none', 'sm', 'default', 'md', 'lg', 'xl'
  },
  hover: {
    type: Boolean,
    default: false,
  },
  className: {
    type: String,
    default: '',
  },
  style: {
    type: Object,
    default: () => ({}),
  },
});

const paddingClass = computed(() => {
  const paddingMap = {
    none: '',
    sm: 'p-3',
    default: 'p-4',
    md: 'p-6',
    lg: 'p-8',
    xl: 'p-10',
  };
  return paddingMap[props.padding] || paddingMap.default;
});

const hoverClass = computed(() => {
  if (!props.hover) return '';
  return 'hover:shadow-medium hover:-translate-y-1 cursor-pointer';
});
</script>

