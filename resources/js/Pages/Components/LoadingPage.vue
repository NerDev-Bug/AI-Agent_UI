<template>
    <transition name="fade">
        <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-2xl shadow-lg flex flex-col items-center justify-center space-y-4">
                <div class="relative w-24 h-24">
                    <div class="absolute bottom-0 left-0 w-full h-4 bg-green-700 rounded-full"></div>

                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <div class="w-2 h-6 bg-green-500 rounded-full origin-bottom animate-grow delay-[0ms]"></div>
                        <div class="w-2 h-8 bg-green-400 rounded-full origin-bottom animate-grow delay-[150ms]"></div>
                        <div class="w-2 h-7 bg-green-500 rounded-full origin-bottom animate-grow delay-[300ms]"></div>
                    </div>

                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 animate-breathe">
                        <img src="/images/title_img.png" alt="LeadsAgri Logo"
                            class="w-16 h-16 object-contain drop-shadow-lg" />
                    </div>
                </div>

                <p class="text-green-900 font-semibold text-lg animate-pulse">
                    {{ text }}
                </p>
            </div>
        </div>
    </transition>
</template>

<script setup>
const props = defineProps({
    visible: {
        type: Boolean,
        default: false,
    },
    text: {
        type: String,
        default: "",
    }
});
</script>

<style scoped>

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes grow {

    0%,
    100% {
        transform: scaleY(0.6);
    }

    50% {
        transform: scaleY(1.2);
    }
}

@keyframes breathe {

    0%,
    100% {
        transform: translateX(-50%) scale(0.9);
    }

    50% {
        transform: translateX(-50%) scale(1.1);
    }
}

.animate-grow {
    animation: grow 1.4s ease-in-out infinite;
}

.animate-breathe {
    animation: breathe 2.5s ease-in-out infinite;
}
</style>
