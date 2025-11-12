<template>
  <div
    v-if="showResults"
    class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] bg-white rounded-xl shadow-2xl border-2 border-green-500 w-[90%] max-w-4xl max-h-[70vh] overflow-hidden flex flex-col"
  >
    <!-- Header -->
    <div class="bg-green-600 text-white px-6 py-4 flex justify-between items-center">
      <h3 class="text-xl font-bold">
        Search Results
        <span v-if="results.total_results !== undefined" class="text-sm font-normal">
          ({{ results.total_results }} found)
        </span>
      </h3>
      <button @click="closeResults" class="text-white hover:text-gray-200 text-2xl font-bold">
        ×
      </button>
    </div>

    <!-- Results List -->
    <div class="flex-1 overflow-y-auto p-4">
      <div v-if="results.results && results.results.length > 0" class="space-y-4">
        <div
          v-for="(result, index) in results.results"
          :key="index"
          class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer"
          @click="selectResult(result)"
        >
          <!-- Result Header -->
          <div class="flex justify-between items-start mb-2">
            <div>
              <h4 class="text-lg font-semibold text-gray-800">
                {{ result.product || 'Unknown Product' }}
              </h4>
              <p class="text-sm text-gray-600">
                {{ result.location || 'Unknown Location' }} • {{ result.crop || 'Unknown Crop' }}
              </p>
            </div>
            <div class="text-right">
              <span
                class="px-2 py-1 rounded text-xs font-semibold"
                :class="getScoreClass(result.score)"
              >
                Score: {{ (result.score * 100).toFixed(1) }}%
              </span>
            </div>
          </div>

          <!-- Basic Info -->
          <div class="grid grid-cols-2 gap-2 text-sm text-gray-700 mb-3">
            <div v-if="result.cooperator">
              <span class="font-semibold">Cooperator:</span> {{ result.cooperator }}
            </div>
            <div v-if="result.form_type">
              <span class="font-semibold">Form Type:</span> {{ result.form_type }}
            </div>
            <div v-if="result.report_number">
              <span class="font-semibold">Report #:</span> {{ result.report_number }}
            </div>
            <div v-if="result.improvement_percent !== undefined">
              <span class="font-semibold">Improvement:</span>
              <span :class="result.improvement_percent > 0 ? 'text-green-600' : 'text-red-600'">
                {{ result.improvement_percent.toFixed(2) }}%
              </span>
            </div>
          </div>

          <!-- Summary Preview -->
          <div v-if="result.summary" class="text-sm text-gray-600 italic border-t pt-2 mt-2">
            {{ truncateText(result.summary, 150) }}
          </div>

          <!-- Executive Summary Preview -->
          <div
            v-else-if="result.executive_summary"
            class="text-sm text-gray-600 italic border-t pt-2 mt-2"
          >
            {{ truncateText(result.executive_summary, 150) }}
          </div>
        </div>
      </div>

      <!-- No Results -->
      <div v-else class="text-center py-12">
        <div class="text-6xl mb-4">🔍</div>
        <p class="text-xl text-gray-600 mb-2">No results found</p>
        <p class="text-sm text-gray-500">
          {{ results.message || 'Try adjusting your search query' }}
        </p>
      </div>
    </div>

    <!-- Footer -->
    <div class="border-t bg-gray-50 px-6 py-3 flex justify-between items-center">
      <p class="text-sm text-gray-600">
        Query: <span class="font-semibold">{{ results.query }}</span>
      </p>
      <button
        @click="closeResults"
        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition"
      >
        Close
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  showResults: {
    type: Boolean,
    default: false,
  },
  results: {
    type: Object,
    default: () => ({
      query: "",
      total_results: 0,
      results: [],
      message: "",
    }),
  },
});

const emit = defineEmits(["close", "select"]);

function closeResults() {
  emit("close");
}

function selectResult(result) {
  emit("select", result);
}

function truncateText(text, maxLength) {
  if (!text || text.length <= maxLength) return text;
  return text.substring(0, maxLength) + "...";
}

function getScoreClass(score) {
  if (score >= 0.7) return "bg-green-500 text-white";
  if (score >= 0.4) return "bg-yellow-500 text-white";
  return "bg-red-500 text-white";
}
</script>

<style scoped>
/* Custom scrollbar */
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

