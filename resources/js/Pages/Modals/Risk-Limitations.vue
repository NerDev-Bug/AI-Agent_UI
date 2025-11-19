<template>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
        <!-- Header -->
        <div class="bg-[linear-gradient(to_right,#00853F,#4CAF50)] rounded-lg max-w-4xl h-15 flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h2 class="text-3xl font-semibold text-black">Risks & Limitations</h2>
            <div class="flex items-center gap-8">
                <!-- Legend -->
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-gray-700 font-medium">Severity:</span>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-gray-700">High</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="text-gray-700">medium</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="text-gray-700">Low</span>
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
            <ul class="space-y-4">
                <li
                    v-for="(risk, i) in riskFactors"
                    :key="i"
                    class="flex items-start gap-3"
                >
                    <!-- Bullet point with color based on severity -->
                    <span
                        class="w-3 h-3 rounded-full mt-2 flex-shrink-0"
                        :class="{
                            'bg-red-500': risk.severity?.toLowerCase() === 'high',
                            'bg-green-500': risk.severity?.toLowerCase() === 'medium',
                            'bg-blue-500': risk.severity?.toLowerCase() === 'low' || !risk.severity
                        }"
                    ></span>
                    <div class="flex-1">
                        <p class="text-lg text-black">
                            <b>{{ risk.risk }}</b> — 
                            {{ risk.data_basis }} 
                            <span v-if="risk.severity">(Severity: <b>{{ risk.severity }}</b>)</span>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
defineProps({
    riskFactors: {
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
