<template>
    <div class="w-full md:w-auto md:ml-auto" v-if="uniqueApplicants.length > 1">
        <label class="block text-sm text-black mb-1">Select Applicant:</label>
        <select 
            :modelValue="modelValue" 
            @update:modelValue="$emit('update:modelValue', $event)"
            class="p-2 rounded-md w-full md:w-72" 
            :disabled="!currentReport">
            <option value="">-- Choose Applicant --</option>
            <option v-for="app in uniqueApplicants" :key="app" :value="app">
                {{ app }}
            </option>
        </select>
    </div>
</template>

<script setup>
defineProps({
    uniqueApplicants: {
        type: Array,
        required: true
    },
    modelValue: {
        type: String,
        default: ""
    },
    currentReport: {
        type: Object,
        default: null
    }
});

defineEmits(['update:modelValue']);
</script>

