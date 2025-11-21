<template>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
        <!-- Header -->
        <div class="bg-[linear-gradient(to_right,#00853F,#4CAF50)] rounded-lg max-w-4xl h-15 flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h2 class="text-3xl font-semibold text-white">Recommendations</h2>
            <div class="flex items-center gap-8">
                <!-- Legend -->
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-white font-medium">Priority:</span>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-white">High</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="text-white">medium</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="text-white">Low</span>
                    </div>
                </div>
                <!-- Close Button -->
                <button
                    @click="$emit('close')"
                    class="text-white hover:text-white text-5xl font-bold w-8 h-8 flex items-center justify-center"
                >
                    ×
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
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
                        <p class="text-lg text-black mb-2">
                            <b>{{ rec.priority?.toUpperCase() }} Priority:</b>
                            {{ rec.recommendation }}
                        </p>
                        <p class="text-gray-600 text-lg">
                            <b>Data Basis:</b> {{ rec.data_basis }}<br />
                            <b>Expected Impact:</b> {{ rec.expected_impact }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    recommendations: {
        type: Array,
        default: () => []
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
