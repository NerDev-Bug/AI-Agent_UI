<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div
            class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 text-center animate-fade-in"
        >
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div
                    :class="type === 'success'
                        ? 'bg-green-100 text-green-600'
                        : 'bg-red-100 text-red-600'"
                    class="w-14 h-14 rounded-full flex items-center justify-center"
                >
                    <svg v-if="type === 'success'" class="w-7 h-7" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>

                    <svg v-else class="w-7 h-7" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-xl font-bold mb-2">
                {{ title }}
            </h2>

            <!-- Message -->
            <p class="text-gray-600 mb-6">
                {{ message }}
            </p>

            <!-- Button -->
            <button
                @click="$emit('close')"
                class="w-full bg-gradient-to-r from-[#0EA5E9] to-[#22D3EE]
                       hover:from-[#0284C7] hover:to-[#06B6D4]
                       text-white font-semibold py-2 rounded-xl transition"
            >
                OK
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    show: Boolean,
    title: String,
    message: String,
    type: {
        type: String,
        default: 'success' // success | error
    }
})
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.animate-fade-in {
    animation: fade-in 0.2s ease-out;
}
</style>
