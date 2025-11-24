<template>
    <div class="bg-white rounded-t-2xl md:rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto md:m-4 md:max-h-[85vh]">
        <!-- Header -->
        <div class="bg-green-600 rounded-t-lg flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 sticky top-0 z-10 gap-3 md:gap-6">
            <h2 class="text-xl md:text-2xl font-semibold text-white">Opportunities</h2>
            <div class="flex items-center gap-3 md:gap-6 flex-wrap">
                <!-- Legend -->
                <div class="flex items-center gap-2 md:gap-3 text-xs md:text-sm">
                    <span class="text-white font-medium">Potential</span>
                    <div class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-red-500"></span>
                        <span class="text-white">High</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-yellow-500"></span>
                        <span class="text-white">medium</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-blue-500"></span>
                        <span class="text-white">Low</span>
                    </div>
                </div>
                <!-- Close Button -->
                <button
                    @click="$emit('close')"
                    class="text-white hover:text-gray-200 text-2xl md:text-3xl font-bold w-8 h-8 flex items-center justify-center transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 rounded"
                    aria-label="Close modal"
                >
                    ×
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 md:p-6">
            <ul class="space-y-4">
                <li
                    v-for="(op, i) in opportunities"
                    :key="i"
                    class="flex items-start gap-3"
                >
                    <!-- Bullet point with color based on potential -->
                    <span
                        class="w-3 h-3 rounded-full mt-2 flex-shrink-0"
                        :class="{
                            'bg-red-500': op.potential?.toLowerCase() === 'high',
                            'bg-yellow-500': op.potential?.toLowerCase() === 'medium',
                            'bg-blue-500': op.potential?.toLowerCase() === 'low' || !op.potential
                        }"
                    ></span>
                    <div class="flex-1">
                        <p class="text-base md:text-lg text-gray-900 leading-relaxed">
                            <b class="text-gray-900">{{ op.opportunity }}:</b> 
                            <span class="text-gray-700">{{ op.data_basis }}</span>
                            <span v-if="op.potential" class="text-gray-600 text-sm md:text-base"> (Potential: <b>{{ op.potential.toLowerCase() }}</b>)</span>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

defineProps({
    opportunities: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['close']);

// ESC key handler
const handleEscKey = (event) => {
    if (event.key === 'Escape') {
        emit('close');
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleEscKey);
});

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleEscKey);
});
</script>

<style scoped>
/* Custom scrollbar for modal */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
