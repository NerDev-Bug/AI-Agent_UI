<template>
    <div class="bg-white rounded-t-2xl md:rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto md:m-4 md:max-h-[85vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-700 to-green-500 rounded-lg flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 sticky top-0 z-10 gap-3 md:gap-8">
            <h2 class="text-xl md:text-3xl font-semibold text-white">Recommendations</h2>
            <div class="flex items-center gap-3 md:gap-8 flex-wrap">
                <!-- Legend -->
                <div class="flex items-center gap-2 md:gap-4 text-xs md:text-sm">
                    <span class="text-white font-medium">Priority:</span>
                    <div class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-red-500"></span>
                        <span class="text-white">High</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-green-500"></span>
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
            <div class="space-y-6">
                <div
                    v-for="(rec, i) in recommendations"
                    :key="i"
                    class="flex items-start gap-3"
                >
                    <!-- Bullet point with color based on priority -->
                    <span
                        class="w-3 h-3 rounded-full mt-2 flex-shrink-0"
                        :class="{
                            'bg-red-500': rec.priority?.toLowerCase() === 'high',
                            'bg-green-500': rec.priority?.toLowerCase() === 'medium',
                            'bg-blue-500': rec.priority?.toLowerCase() === 'low' || !rec.priority
                        }"
                    ></span>
                    <div class="flex-1">
                        <p class="text-base md:text-lg text-gray-900 mb-2 leading-relaxed">
                            <b class="text-gray-900">{{ rec.priority?.toUpperCase() }} Priority:</b>
                            <span class="text-gray-700">{{ rec.recommendation }}</span>
                        </p>
                        <div class="text-sm md:text-base text-gray-600 space-y-1">
                            <p><b class="text-gray-800">Data Basis:</b> {{ rec.data_basis }}</p>
                            <p><b class="text-gray-800">Expected Impact:</b> {{ rec.expected_impact }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

defineProps({
    recommendations: {
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
