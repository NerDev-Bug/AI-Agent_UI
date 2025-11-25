<template>
    <div class="bg-white rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden md:m-4 md:max-h-[85vh] border border-gray-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-700 to-green-500 flex items-center justify-between p-5 md:p-6 sticky top-0 z-10 border-b border-green-700">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <h2 class="text-xl md:text-2xl font-bold text-white">Executive Summary</h2>
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

        <!-- Content -->
        <div class="p-5 md:p-6 overflow-y-auto max-h-[calc(90vh-100px)] md:max-h-[calc(85vh-100px)] bg-gray-50">
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <p class="text-base md:text-lg text-gray-900 whitespace-pre-line leading-relaxed">
                    {{ executiveSummary }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

defineProps({
    executiveSummary: {
        type: String,
        default: ''
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
