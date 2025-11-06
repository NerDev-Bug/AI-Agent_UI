<template>
  <div class="bg-[#E2E8F3] min-h-screen overflow-y-auto">
    <!-- Blurry green fade at the bottom -->
    <div
      class="absolute -bottom-4 left-0 right-0 h-1/4 bg-gradient-to-t from-green-700/100 to-transparent blur-md pointer-events-none">
    </div>
    <!-- PNG curved green line above the blur -->
    <img src="/images/Line 1.png" alt="Curved green line"
      class="absolute -bottom-2 left-0 w-full h-auto pointer-events-none z-10" />

    <!-- Two overlapping images at the bottom right -->
    <div class="absolute bottom-0 right-36 pointer-events-none z-20">
      <!-- Bottom image (Rectangle 5) -->
      <img src="/images/Rectangle 5.png" alt="Rectangle 5" class="w-[270px] h-auto relative z-0" />

      <!-- Top image (Pandoy) -->
      <img src="/images/Pandoy.png" alt="Pandoy" class="w-[330px] h-auto absolute bottom-0 right-0 z-10" />
    </div>

    <!-- Top right image -->
    <img src="/images/nutrition 1.png" alt="Top Right Image"
      class="absolute top-22 -right-0 w-[350px] h-auto pointer-events-none z-20" />

    <!-- Left stair images -->
    <div class="absolute left-8 top-1/2 transform -translate-y-1/2 pointer-events-none z-20">
      <img src="/images/iSBM.png" alt="Bottom" class="w-[190px] h-auto relative z-0 -ml-[-170px] mb-[-190px]" />
      <img src="/images/NFBT1.png" alt="Middle" class="w-[190px] h-auto relative z-10 -ml-[-115px] mb-[-220px]" />
      <img src="/images/FO1.png" alt="Top" class="w-[200px] h-auto relative z-20 -ml-[-60px] mb-[-90px]" />
    </div>

    <div id="AI-AgentForm" class="min-h-screen flex flex-col items-center justify-center pt-2 relative z-10">
      <div class="flex flex-col items-center justify-center mb-14">
        <h1 class="text-xl font-bold text-gray-800 mb-2">Product demo Trials Agents with</h1>
        <img src="/images/title_img.png" alt="AI Agent Logo" class="w-[500px] h-[120px]">
      </div>
      <div
        class="bg-white w-[360px] h-[260px] rounded-xl shadow-md border-4 border-green-700 flex flex-col items-center justify-center mb-10">
        <form @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop"
          class="relative bg-white w-[280px] h-[160px] rounded-xl shadow-md flex flex-col items-center justify-center border-4 border-dashed transition"
          :class="isDragging ? 'border-green-700 bg-green-50' : 'border-green-600 hover:border-green-700'">
          <input id="fileUpload" type="file" class="hidden" accept=".pdf,.jpeg,.jpg,.png" @change="handleFileUpload" />

          <label for="fileUpload"
            class="cursor-pointer flex flex-col items-center justify-center text-gray-600 hover:text-green-600 transition text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-12 h-12 mb-2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 16.5V3.75m0 0L6.75 9m5.25-5.25L17.25 9M3.75 19.5h16.5" />
            </svg>
            <span class="text-sm font-medium">
              Drag & Drop or Click to Upload<br />
              <span class="text-xs text-gray-500">(PDF, JPEG, JPG, PNG)</span>
            </span>
          </label>

          <div v-if="isUploading"
            class="absolute inset-0 bg-white bg-opacity-70 flex flex-col items-center justify-center rounded-xl">
            <svg class="animate-spin h-10 w-10 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span class="text-sm text-gray-700 font-medium">Uploading...</span>
          </div>
        </form>

        <div v-if="uploadedFile" class="mt-3 text-gray-700 text-sm italic">
          {{ uploadedFile.name }}
        </div>

        <transition name="fade" mode="out-in">
          <!-- Always show Analyze button if not analyzed and not uploading -->
          <div v-if="!isAnalyzed && !isUploading" key="analyze" class="flex items-center justify-center gap-2 mt-4">
            <button @click="startAnalysis"
              class="bg-[#00853F] w-[200px] h-10 rounded-lg text-white font-semibold hover:bg-[#00953F] transition">
              Analyze Demo Form
            </button>
          </div>

          <!-- Show Save / Re-analyze after analysis is done -->
          <div v-else-if="isAnalyzed && !isUploading" key="save-reanalyze"
            class="flex items-center justify-center gap-4 mt-4">
            <button class="bg-[#00853F] w-[100px] h-10 rounded-lg text-white font-semibold hover:bg-green-600 transition">
              Save
            </button>
            <button @click="reanalyze"
              class="bg-red-600 w-[200px] h-10 rounded-lg text-white font-semibold hover:bg-red-700 transition">
              Re-analyze
            </button>
          </div>
        </transition>
      </div>
    </div>

    <div>
      <Navbarheader />
    </div>

    <!-- Context-->
    <div id="AI-AgentContext" class="p-8 pt-24">
      <AIAgentContext />
    </div>
  </div>
</template>

<script setup>
import AIAgentContext from "./AI-AgentContext.vue";
import Navbarheader from "../Layouts/Header.vue";
import { ref } from "vue";

const isDragging = ref(false);
const isUploading = ref(false);
const isAnalyzed = ref(false);
const uploadedFile = ref(null);

function handleFileUpload(e) {
  const file = e.target.files[0];
  processFile(file);
}

function handleDrop(e) {
  isDragging.value = false;
  const file = e.dataTransfer.files[0];
  processFile(file);
}

function processFile(file) {
  if (!file) return;
  const validTypes = ["application/pdf", "image/jpeg", "image/png"];
  if (!validTypes.includes(file.type)) {
    alert("Invalid file type. Only PDF, JPG, JPEG, PNG allowed.");
    return;
  }
  uploadedFile.value = file;
  isUploading.value = true;
  setTimeout(() => {
    isUploading.value = false;
  }, 2000);
}

function startAnalysis() {
  isAnalyzed.value = true;
}

function reanalyze() {
  isAnalyzed.value = false;
  uploadedFile.value = null;
}

</script>

<style scoped>
canvas {
  max-height: 400px;
}

.chart-card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
