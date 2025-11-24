<template>
  <div
    :class="[
      'relative rounded-3xl p-6 md:p-8 flex flex-col items-center justify-center text-white shadow-large transition-all duration-300',
      gradientClass,
      hoverClass
    ]"
  >
    <!-- Value -->
    <p :class="[
      'font-semibold leading-none text-center',
      valueSizeClass
    ]">
      {{ formattedValue }}
    </p>
    
    <!-- Label -->
    <p :class="[
      'absolute bottom-3 left-6 text-sm opacity-90 font-medium',
      labelClass
    ]">
      {{ label }}
    </p>
    
    <!-- Optional Badge -->
    <div v-if="badge" :class="[
      'absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-medium',
      badgeClass
    ]">
      {{ badge }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  value: {
    type: [Number, String],
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  variant: {
    type: String,
    default: 'primary', // 'primary', 'secondary', 'success', 'info'
  },
  size: {
    type: String,
    default: 'lg', // 'sm', 'md', 'lg', 'xl'
  },
  badge: {
    type: String,
    default: '',
  },
  format: {
    type: String,
    default: 'number', // 'number', 'percent', 'currency'
  },
  decimals: {
    type: Number,
    default: 2,
  },
  hover: {
    type: Boolean,
    default: false,
  },
});

const gradientClass = computed(() => {
  const gradientMap = {
    primary: 'bg-gradient-to-r from-secondary-700 to-secondary-500',
    secondary: 'bg-gradient-to-r from-primary-700 to-primary-500',
    success: 'bg-gradient-to-r from-green-600 to-green-400',
    info: 'bg-gradient-to-r from-blue-600 to-blue-400',
  };
  return gradientMap[props.variant] || gradientMap.primary;
});

const valueSizeClass = computed(() => {
  const sizeMap = {
    sm: 'text-3xl',
    md: 'text-4xl',
    lg: 'text-5xl',
    xl: 'text-6xl',
  };
  return sizeMap[props.size] || sizeMap.lg;
});

const labelClass = computed(() => {
  return 'text-white';
});

const badgeClass = computed(() => {
  return 'bg-white bg-opacity-20 text-white';
});

const hoverClass = computed(() => {
  if (!props.hover) return '';
  return 'hover:scale-105 hover:shadow-glow';
});

const formattedValue = computed(() => {
  if (typeof props.value === 'string') return props.value;
  
  const numValue = Number(props.value);
  if (isNaN(numValue)) return props.value;
  
  if (props.format === 'percent') {
    return `${numValue.toFixed(props.decimals)}%`;
  } else if (props.format === 'currency') {
    return `$${numValue.toFixed(props.decimals)}`;
  } else {
    return numValue.toFixed(props.decimals);
  }
});
</script>

