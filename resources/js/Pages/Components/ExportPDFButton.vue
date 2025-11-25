<template>
    <button 
        v-if="currentReport && isSaved" 
        @click="handleExportClick" 
        :disabled="isExporting"
        class="bg-gradient-to-r from-secondary-600 to-secondary-700 w-full md:w-[220px] h-12 rounded-xl text-white hover:from-secondary-700 hover:to-secondary-800 transition-all duration-300 shadow-medium hover:shadow-glow-blue flex items-center justify-center gap-2 font-semibold transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2">
        <span v-if="!isExporting" class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export to PDF
        </span>
        <span v-else class="flex flex-row gap-2">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Exporting...
        </span>
    </button>
</template>

<script setup>
defineProps({
    currentReport: {
        type: Object,
        default: null
    },
    isSaved: {
        type: Boolean,
        default: false
    },
    isExporting: {
        type: Boolean,
        default: false
    },
    handleExportClick: {
        type: Function,
        required: true
    }
});
</script>

