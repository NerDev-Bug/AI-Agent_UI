<template>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
        <!-- Header -->
        <div class="bg-green-600 rounded-t-lg flex items-center justify-between p-6 sticky top-0 z-10">
            <h2 class="text-2xl font-semibold text-white">Opportunities</h2>
            <div class="flex items-center gap-6">
                <!-- Legend -->
                <div class="flex items-center gap-3 text-sm">
                    <span class="text-white font-medium">Potential</span>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-white">High</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
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
                    class="text-white hover:text-gray-200 text-3xl font-bold w-8 h-8 flex items-center justify-center transition-colors"
                >
                    ×
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <ul class="space-y-4">
                <li
                    v-for="(op, i) in opportunities"
                    :key="i"
                    class="flex items-start gap-3"
                >
                    <!-- Red bullet point for all items -->
                    <span class="w-3 h-3 rounded-full mt-2 flex-shrink-0 bg-red-500"></span>
                    <div class="flex-1">
                        <p class="text-lg text-black">
                            <b>{{ op.opportunity }}:</b> {{ op.data_basis }} 
                            <span v-if="op.potential">(Potential: <b>{{ op.potential.toLowerCase() }}</b>)</span>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
defineProps({
    opportunities: {
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
