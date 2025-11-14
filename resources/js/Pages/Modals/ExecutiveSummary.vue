<template>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h2 class="text-3xl font-semibold text-black">Executive Summary</h2>
            <!-- Close Button -->
            <button
                @click="$emit('close')"
                class="text-gray-500 hover:text-gray-700 text-5xl font-bold w-8 h-8 flex items-center justify-center"
            >
                ×
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <p class="text-lg text-black whitespace-pre-line leading-relaxed">
                {{ executiveSummary }}
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    executiveSummary: {
        type: String,
        default: ''
    }
});

defineEmits(['close']);
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
