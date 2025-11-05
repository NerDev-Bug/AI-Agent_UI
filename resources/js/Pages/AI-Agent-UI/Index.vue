<template>
  <div class="mt-32">
    <div class="flex items-center justify-center">
      <select 
        v-model="selected" 
        class="border-xl rounded-md mr-56 p-2 pr-4 border"
      >
        <option value="" disabled>Select</option>
        <option value="ai-agent">AI Agent</option>
      </select>
    </div>

    <!-- Modal appears when AI Agent is selected -->
    <AIForm v-if="selected === 'ai-agent'" @close="selected = ''" />
  </div>
</template>

<script setup>
// import { ref } from 'vue'
// import AIForm from './AI-AgentForm.vue'

// const selected = ref('')
</script>
