<template>
  <VOnboardingWrapper ref="wrapper" :steps="steps">
    <template #default="{ previous, next, step, exit, isFirst, isLast, index }">
      <VOnboardingStep>
        <div class="bg-white shadow sm:rounded-lg p-4 max-w-sm">
          <div v-if="step.content">
            <h3 v-if="step.content.title" class="text-lg font-medium text-gray-900">{{ step.content.title }}</h3>
            <div v-if="step.content.description" class="mt-2 text-sm text-gray-500">
              <p>{{ step.content.description }}</p>
            </div>
          </div>
          <div class="mt-4 flex justify-end space-x-2">
            <button v-if="!isFirst" @click="previous"
              class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">Previous</button>
            <button @click="isLast ? exit() : next"
              class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">{{ isLast ? 'Finish' : 'Next' }}</button>
            <span class="ml-2 text-xs text-gray-600">{{ index + 1 }}/{{ steps.length }}</span>
          </div>
        </div>
      </VOnboardingStep>
    </template>
  </VOnboardingWrapper>
</template>

<script setup>
import { ref } from 'vue'
import { VOnboardingWrapper, VOnboardingStep, useVOnboarding } from 'v-onboarding'

const wrapper = ref(null)
const { start } = useVOnboarding(wrapper)

// Define your steps using data attributes from AI-AgentForm
const steps = [
  {
    attachTo: { element: '[data-uploadform]', on: 'bottom' },
    content: {
      title: 'Upload Your Form',
      description: 'Drag & drop or click to select a file (PDF, JPEG, JPG, PNG).'
    }
  },
  {
    attachTo: { element: '[data-analyzebtn]', on: 'top' },
    content: {
      title: 'Analyze Demo Form',
      description: 'Click here to analyze your uploaded form.'
    }
  },
  {
    attachTo: { element: '[data-resultssection]', on: 'top' },
    content: {
      title: 'View Your Results',
      description: 'After analyzing, your results and insights appear here.'
    }
  }
]

defineExpose({
  start
})
</script>
