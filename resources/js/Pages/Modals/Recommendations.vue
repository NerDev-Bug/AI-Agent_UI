<template>
    <div class="bg-white rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden md:m-4 md:max-h-[85vh] border border-gray-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-700 to-green-500 flex flex-col md:flex-row md:items-center justify-between p-5 md:p-6 sticky top-0 z-10 gap-3 md:gap-6 border-b border-green-700">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-xl md:text-2xl font-bold text-white">Recommendations</h2>
            </div>
            <div class="flex items-center gap-4">
                <!-- Legend -->
                <div class="flex items-center gap-3 text-xs md:text-sm bg-white/10 px-3 py-1.5 rounded-lg">
                    <span class="text-white font-medium">Priority:</span>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <span class="text-white text-xs">High</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        <span class="text-white text-xs">Medium</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <span class="text-white text-xs">Low</span>
                    </div>
                </div>
                <!-- Close Button -->
                <button
                    @click="$emit('close')"
                    class="text-white hover:bg-white/10 w-8 h-8 flex items-center justify-center transition-colors rounded-lg focus:outline-none focus:ring-2 focus:ring-white/50"
                    aria-label="Close modal"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-5 md:p-6 overflow-y-auto max-h-[calc(90vh-100px)] md:max-h-[calc(85vh-100px)] bg-gray-50">
            <div class="space-y-4">
                <div
                    v-for="(rec, i) in recommendations"
                    :key="i"
                    class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow"
                >
                    <div class="flex items-start gap-4">
                        <!-- Priority Indicator -->
                        <div class="flex-shrink-0 mt-1">
                            <div
                                class="w-3 h-3 rounded-full"
                                :class="{
                                    'bg-red-500': rec.priority?.toLowerCase() === 'high',
                                    'bg-green-500': rec.priority?.toLowerCase() === 'medium',
                                    'bg-blue-500': rec.priority?.toLowerCase() === 'low' || !rec.priority
                                }"
                            ></div>
                        </div>
                        <div class="flex-1">
                            <!-- Priority Badge -->
                            <div class="mb-3">
                                <span 
                                    class="inline-block px-2.5 py-1 rounded text-xs font-semibold"
                                    :class="{
                                        'bg-red-100 text-red-700': rec.priority?.toLowerCase() === 'high',
                                        'bg-green-100 text-green-700': rec.priority?.toLowerCase() === 'medium',
                                        'bg-blue-100 text-blue-700': rec.priority?.toLowerCase() === 'low' || !rec.priority
                                    }"
                                >
                                    {{ rec.priority?.toUpperCase() || 'STANDARD' }} PRIORITY
                                </span>
                            </div>
                            
                            <!-- Recommendation -->
                            <p class="text-base text-gray-900 mb-4 leading-relaxed font-medium">
                                {{ rec.recommendation }}
                            </p>
                            
                            <!-- Data Basis -->
                            <div class="mb-3 pb-3 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Data Basis</p>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ rec.data_basis }}</p>
                            </div>
                            
                            <!-- Expected Impact -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Expected Impact</p>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ rec.expected_impact }}</p>
                            </div>
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
/* Clean scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
