<template>
    <transition name="fade">
        <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9998]">
            <div class="bg-white p-12 w-[400px] h-auto rounded-2xl shadow-lg flex flex-col items-center justify-center space-y-4">
                <div class="relative w-full h-40">
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <div class="w-2 h-6 bg-green-500 rounded-full origin-bottom animate-grow delay-[0ms]"></div>
                        <div class="w-2 h-8 bg-green-400 rounded-full origin-bottom animate-grow delay-[150ms]"></div>
                        <div class="w-2 h-7 bg-green-500 rounded-full origin-bottom animate-grow delay-[300ms]"></div>
                    </div>

                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 animate-breathe">
                        <img src="/images/title_img.png" alt="LeadsAgri Logo"
                            class="w-[320px] h-[70px] drop-shadow-lg" />
                    </div>
                </div>

                <p class="text-green-900 font-semibold text-lg animate-pulse">
                    {{ message }}
                </p>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-300 ease-linear relative"
                        :style="{ width: progress + '%' }">
                        <div class="absolute inset-0 bg-white opacity-30 animate-shimmer"></div>
                    </div>
                </div>

                <!-- Progress Info -->
                <div class="flex items-center justify-between w-full text-sm">
                    <p class="text-gray-600 font-medium">{{ Math.floor(progress) }}%</p>
                    <p class="text-gray-500 text-xs">
                        <span v-if="estimatedTime > 0">~{{ estimatedTime }}s remaining</span>
                        <span v-else-if="progress < 50">Analyzing...</span>
                        <span v-else-if="progress < 90">Processing data...</span>
                        <span v-else>Finalizing...</span>
                    </p>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
import { ref, watch, onUnmounted, nextTick } from 'vue';
import axios from 'axios';
import { ProgressSimulator } from '../../utils/progressSimulator.js';
import { getUserFriendlyError } from '../../utils/errorMessages.js';

const props = defineProps({
    visible: {
        type: Boolean,
        default: false,
    },
    jobId: {
        type: String,
        default: null,
    },
    initialText: {
        type: String,
        default: "Processing your file...",
    }
});

const emit = defineEmits(['complete', 'error']);

const progress = ref(0);
const message = ref(props.initialText);
const estimatedTime = ref(0);
let pollInterval = null;
let isPolling = false;
let isRequestInProgress = false;
let currentJobId = null; // Track current job to prevent duplicate polling
let progressSimulator = null; // Progress simulator instance
let startTime = null; // Track start time for estimation

// Initialize progress simulator
const initProgressSimulator = () => {
    if (!progressSimulator) {
        progressSimulator = new ProgressSimulator();
    }
    progressSimulator.reset();
    
    // Start simulator with callback
    progressSimulator.start((simulatedProgress, simulatedMessage) => {
        // Only update if we don't have backend status yet or simulator is ahead
        if (!isPolling || progress.value < simulatedProgress) {
            progress.value = simulatedProgress;
            message.value = simulatedMessage;
        }
    });
};

// Helper function to stop polling
const stopPolling = () => {
    if (pollInterval) {
        clearInterval(pollInterval);
        pollInterval = null;
    }
    isPolling = false;
    currentJobId = null;
    
    // Stop progress simulator
    if (progressSimulator) {
        progressSimulator.stop();
    }
    
    // ✅ CRITICAL FIX: Reset progress when stopping (for Re-analyze and Save buttons)
    // Don't reset if we're just temporarily stopping (component still visible)
    if (!props.visible) {
        progress.value = 0;
        message.value = props.initialText;
    }
};

// Helper function to start polling
const startPolling = () => {
    // Prevent duplicate polling for same job
    if (isPolling && currentJobId === props.jobId) {
        return;
    }
    
    // Clear any existing interval first
    stopPolling();
    
    if (!props.jobId || !props.visible) {
        return;
    }
    
    isPolling = true;
    currentJobId = props.jobId;
    startTime = Date.now(); // Record start time
    estimatedTime.value = 0;
    
    // Start progress simulator
    initProgressSimulator();
    
    // Use nextTick to ensure we only start once
    nextTick(() => {
        // Double-check we still should poll
        if (!props.jobId || !props.visible || currentJobId !== props.jobId) {
            stopPolling();
            return;
        }
        
        // Poll immediately
        pollProgress();
        
        // Then poll every 2 seconds
        pollInterval = setInterval(() => {
            // Double-check before each poll
            if (currentJobId !== props.jobId || !props.visible) {
                stopPolling();
                return;
            }
            pollProgress();
        }, 2000);
    });
};

// Poll progress when jobId is provided
const pollProgress = async () => {
    // Prevent multiple simultaneous requests
    if (isRequestInProgress) {
        return;
    }
    
    if (!props.jobId || !props.visible || currentJobId !== props.jobId) {
        stopPolling();
        return;
    }
    
    isRequestInProgress = true;
    
    try {
        const response = await axios.get(`/api/ai-agent/progress/${props.jobId}`);
        const data = response.data;
        
        // Update simulator based on backend status
        if (data.status && progressSimulator) {
            progressSimulator.updateFromBackend(data.status);
        }
        
        // Calculate estimated time remaining
        if (startTime && progress.value > 0 && progress.value < 100) {
            const elapsed = (Date.now() - startTime) / 1000; // seconds
            const rate = progress.value / elapsed; // % per second
            if (rate > 0) {
                estimatedTime.value = Math.ceil((100 - progress.value) / rate);
            }
        }
        
        // Check if job is complete - VERIFY RESULT EXISTS FIRST
        if (data.status === 'complete') {
            // ✅ CRITICAL FIX: Verify result exists before marking complete
            // Backend might return 'complete' but result not ready yet
            if (!data.result || (!data.result.analysis && !data.result.reports && !data.analysis)) {
                // Backend says complete but no result yet - keep polling
                console.warn('⚠️ Backend returned complete but no result yet, continuing to poll...');
                message.value = 'Finalizing result...';
                // Don't stop polling - wait for actual result
                isRequestInProgress = false;
                return;
            }
            
            stopPolling();
            progress.value = 100; // Jump to 100% immediately
            message.value = 'Complete!';
            estimatedTime.value = 0;
            
            // Emit complete event with result
            emit('complete', data.result || data);
        } else if (data.status === 'failed') {
            // Job failed - stop polling and show error
            stopPolling();
            progress.value = 0; // Reset progress on failure
            
            // Get raw error message from backend
            const rawErrorMessage = data.error || data.message || 'Job processing failed';
            
            // Convert to user-friendly message for display
            const userFriendlyMessage = getUserFriendlyError(rawErrorMessage);
            message.value = userFriendlyMessage;
            
            // Emit error event with both raw (for logging) and friendly (for display) messages
            emit('error', {
                message: userFriendlyMessage,  // User-friendly message
                rawMessage: rawErrorMessage,   // Technical message for debugging
                jobId: props.jobId,
                status: 'failed'
            });
        }
        // If still in_progress, simulator continues (max 99%)
        // Progress will stay at 99% until backend confirms completion
    } catch (error) {
        // Handle 404 (job not found) or other errors
        if (error.response && error.response.status === 404) {
            stopPolling();
            progress.value = 0;
            const rawErrorMessage = 'Job not found. It may have expired or been cleaned up.';
            const userFriendlyMessage = getUserFriendlyError(rawErrorMessage);
            message.value = userFriendlyMessage;
            emit('error', {
                message: userFriendlyMessage,
                rawMessage: rawErrorMessage,
                jobId: props.jobId,
                status: 'not_found'
            });
        } else if (error.response && error.response.data) {
            // Handle other API errors with error messages
            stopPolling();
            progress.value = 0;
            const rawErrorMessage = error.response.data.error || error.response.data.message || 'Failed to check job progress';
            const userFriendlyMessage = getUserFriendlyError(rawErrorMessage);
            message.value = userFriendlyMessage;
            emit('error', {
                message: userFriendlyMessage,
                rawMessage: rawErrorMessage,
                jobId: props.jobId,
                status: 'error'
            });
        } else {
            console.error('Progress polling error:', error);
            // Don't stop polling on network errors - might be temporary
            // Only stop if it's a clear API error
        }
    } finally {
        isRequestInProgress = false;
    }
};

// Single watcher that watches both jobId and visible
watch(
    () => [props.jobId, props.visible],
    ([newJobId, isVisible]) => {
        // ✅ CRITICAL FIX: Reset progress when component becomes visible
        if (isVisible) {
            progress.value = 0; // Reset progress to 0 when LoadingPage becomes visible
            message.value = props.initialText; // Reset message
        }
        
        if (newJobId && isVisible) {
            startPolling();
        } else {
            stopPolling();
        }
    },
    { immediate: true }
);

// Cleanup on unmount
onUnmounted(() => {
    stopPolling();
});
</script>

<style scoped>
/* ... existing styles ... */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes grow {
    0%, 100% {
        transform: scaleY(0.6);
    }
    50% {
        transform: scaleY(1.2);
    }
}

@keyframes breathe {
    0%, 100% {
        transform: translateX(-50%) scale(0.9);
    }
    50% {
        transform: translateX(-50%) scale(1.1);
    }
}

@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.animate-shimmer {
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}

.animate-grow {
    animation: grow 1.4s ease-in-out infinite;
}

.animate-breathe {
    animation: breathe 2.5s ease-in-out infinite;
}
</style>