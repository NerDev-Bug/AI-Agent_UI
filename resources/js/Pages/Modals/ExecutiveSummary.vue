<template>
    <div class="bg-white rounded-t-2xl md:rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto md:m-4 md:max-h-[85vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-700 to-green-500 rounded-lg flex items-center justify-between p-4 md:p-6 sticky top-0 z-10">
            <h2 class="text-xl md:text-3xl font-semibold text-white">Executive Summary</h2>
            <!-- Close Button -->
            <button
                @click="$emit('close')"
                class="text-white hover:text-gray-200 text-2xl md:text-3xl font-bold w-8 h-8 flex items-center justify-center transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 rounded"
                aria-label="Close modal"
            >
                ×
            </button>
        </div>

        <!-- Content -->
        <div class="p-4 md:p-6">
            <p class="text-base md:text-lg text-gray-900 whitespace-pre-line leading-relaxed">
                {{ executiveSummary }}
            </p>
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
