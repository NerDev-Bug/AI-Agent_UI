<template>
  <div class="bg-gradient-to-br from-background-light via-background-lighter to-background-light min-h-screen overflow-y-auto z-50">
    <!-- left leafs-->
    <div>
      <img src="/images/leaf2.png"
        class="absolute top-[60px] left-[110px] w-[40px] h-auto pointer-events-none z-20 rotate-[-75deg]">
      <img src="/images/leaf2.png"
        class="absolute w-[60px] h-auto pointer-events-none bottom-[300px] left-[486px] z-10">
      <img src="/images/leaf1.png"
        class="absolute top-[140px] left-[365px] w-[30px] h-auto pointer-events-none z-20 scale-x-[-1] rotate-[-70deg]">
      <img src="/images/leaf1.png"
        class="absolute top-[160px] left-[-60px] w-[270px] h-auto pointer-events-none z-20 rotate-[70deg]">
      <img src="/images/leaf1.png"
        class="absolute w-[46px] h-auto pointer-events-none bottom-[90px] left-[115px] scale-x-[-1] rotate-[-128deg] z-10">
      <img src="/images/leaf1.png"
        class="absolute w-[50px] h-auto pointer-events-none scale-x-[-1] bottom-[-120px] left-[70px] rotate-[-70deg] z-10">
      <img src="/images/Pandoy.png" alt="Pandoy"
        class="absolute w-[270px] h-auto pointer-events-none bottom-[-30px] left-[220px] z-10" />
    </div>

    <!-- right leafs-->
    <div>
      <img src="/images/leaf1.png"
        class="absolute top-[60px] right-[210px] w-[44px] h-auto pointer-events-none z-20 rotate-[56deg]">
      <img src="/images/leaf1.png"
        class="absolute w-[50px] h-auto pointer-events-none bottom-[180px] right-[494px] z-10 rotate-[70deg]">
      <img src="/images/leaf1.png"
        class="absolute w-[44px] h-auto pointer-events-none bottom-[260px] right-[274px] z-10 rotate-[70deg]">
      <div class="absolute inset-0 overflow-x-hidden overflow-y-hidden pointer-events-none">
        <img src="/images/leaf2.png" class="absolute w-[570px] bottom-[-130px] right-[-260px] rotate-[-47deg]" />
      </div>
      <img src="/images/leaf2.png"
        class="absolute w-[50px] h-auto pointer-events-none bottom-[-160px] right-[70px] rotate-[-70deg] z-10">
    </div>

    <!-- Top left image NFBT1-->
    <img src="/images/NFBT1.png" alt="Middle"
      class="absolute top-[160px] left-[230px] w-[90px] h-auto pointer-events-none z-20" />

    <!-- Top right images FO1-->
    <img src="/images/FO1.png" alt="Middle"
      class="absolute top-[190px] right-[210px] w-[90px] h-auto pointer-events-none z-20" />

    <!-- center right images iSBM-->
    <img src="/images/iSBM.png" alt="Middle"
      class="absolute top-[400px] right-[360px] w-[70px] h-auto pointer-events-none z-20" />

    <!-- ✅ Main Upload Form -->
    <div id="AI-AgentForm" class="min-h-screen flex flex-col items-center justify-center pt-20 pb-8 relative z-10">
      <div class="flex flex-col items-center justify-center mb-12 animate-fadeIn">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
          Product demo Trials Agents with
        </h1>
        <div class="mb-6 animate-scaleIn">
          <img src="/images/title_img.png" alt="AI Agent Logo" class="w-[400px] md:w-[500px] h-auto drop-shadow-large">
        </div>

        <!-- Top Description-->
        <div class="w-full max-w-2xl text-center px-4">
          <p class="text-base md:text-lg text-gray-700 leading-relaxed">
            Upload your Product Demo Trials forms and get instant <span class="font-semibold text-primary-600">AI-powered analytics</span>.
            Understand form performance, user behavior, and conversion insights in seconds.
          </p>
        </div>
      </div>

      <!-- ✅ Conditional success message OR upload box -->
      <transition name="scaleIn" mode="out-in">
        <div
          class="bg-white w-full max-w-md rounded-3xl shadow-large border-4 border-primary-500 flex flex-col items-center justify-center mb-10 px-6 py-6 relative animate-scaleIn hover:shadow-glow transition-all duration-300">

          <!-- ✅ Success message INSIDE card - covers upload area and filename, but NOT buttons -->
          <transition name="bounceIn">
            <div v-if="showSuccessMessage"
              class="absolute top-0 left-0 right-0 flex flex-col items-center justify-center text-center z-40 pointer-events-none bg-gradient-to-br from-green-50 to-emerald-50 rounded-t-3xl shadow-medium"
              style="height: calc(100% - 80px); bottom: 80px;">
              <div class="relative">
                <div class="absolute inset-0 bg-green-400 rounded-full blur-xl opacity-30 animate-pulse"></div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                  stroke="currentColor" class="w-20 h-20 text-primary-600 mb-4 relative z-10 animate-bounceIn">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <h2 class="text-xl font-bold text-primary-700 mb-2">{{ successMessage }}</h2>
              <p class="text-sm text-gray-600">Your analysis is ready!</p>
            </div>
          </transition>

          <!-- ✅ Upload Form -->
          <form data-uploadform @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave"
            @drop.prevent="handleDrop"
            class="relative bg-gradient-to-br from-gray-50 to-white w-full max-w-xs h-48 rounded-2xl shadow-soft flex flex-col items-center justify-center border-2 border-dashed transition-all duration-300"
            :class="isDragging ? 'border-primary-500 bg-primary-50 scale-105 shadow-glow' : 'border-gray-300 hover:border-primary-400 hover:bg-primary-50/50'">
            <input id="fileUpload" ref="fileInput" type="file" class="hidden" accept=".pdf,.jpeg,.jpg,.png"
              @change="handleFileUpload" />

            <label for="fileUpload"
              class="cursor-pointer flex flex-col items-center justify-center text-gray-600 hover:text-primary-600 transition-all duration-300 text-center group">
              <div class="mb-3 p-3 rounded-full bg-primary-100 group-hover:bg-primary-200 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" class="w-8 h-8 text-primary-600">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 16.5V3.75m0 0L6.75 9m5.25-5.25L17.25 9M3.75 19.5h16.5" />
                </svg>
              </div>
              <span class="text-sm font-semibold mb-1">
                Drag & Drop or Click to Upload
              </span>
              <span class="text-xs text-gray-500">(PDF, JPEG, JPG, PNG)</span>
            </label>

            <!-- Dragging Indicator -->
            <transition name="scaleIn">
              <div v-if="isDragging"
                class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-primary-600 to-primary-700 bg-opacity-95 rounded-2xl text-white text-lg font-semibold z-20 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 mb-2 animate-bounce">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span>Drop your file here</span>
              </div>
            </transition>

            <!-- Uploading Overlay -->
            <div v-if="isUploading"
              class="absolute inset-0 bg-white bg-opacity-70 flex flex-col items-center justify-center rounded-xl z-30">
              <svg class="animate-spin h-10 w-10 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
              <span class="text-sm text-gray-700 font-medium">Uploading...</span>
            </div>
          </form>

          <!-- Uploaded File Info -->
          <div v-if="uploadedFile"
            class="mt-3 flex items-center justify-center gap-3 text-gray-700 text-sm font-medium relative z-10">
            <span class="italic truncate max-w-[180px]">{{ uploadedFile.name }}</span>

            <!-- View -->
            <button @click="viewFile" class="text-green-700 hover:text-green-900 transition">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>

            <!-- Delete -->
            <button @click="deleteFile" class="text-red-600 hover:text-red-800 transition">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- ✅ Toggle Button for JSON/API Mode -->
          <!-- <div v-if="!isAnalyzed && !isUploading" class="flex items-center justify-center gap-3 mt-2 relative z-50">
            <span class="text-sm text-gray-700 font-medium">Use JSON File:</span>
            <button
              @click="toggleJsonMode"
              :class="[
                'relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2',
                useJsonFile ? 'bg-green-600' : 'bg-gray-300'
              ]">
              <span
                :class="[
                  'inline-block h-4 w-4 transform rounded-full bg-white transition-transform',
                  useJsonFile ? 'translate-x-6' : 'translate-x-1'
                ]"
              ></span>
            </button>
            <span class="text-xs text-gray-500">{{ useJsonFile ? 'ON' : 'OFF' }}</span>
          </div> -->

          <!-- ✅ Buttons - positioned at bottom, always visible above success overlay -->
          <transition name="fade" mode="out-in">
            <!-- Analyze -->
            <div data-analyzebtn v-if="!isAnalyzed && !isUploading" key="analyze"
              class="flex items-center justify-center gap-2 mt-6 relative z-50">
              <button @click="startAnalysis" :class="[
                'w-full max-w-[220px] h-12 rounded-xl text-white font-semibold transition-all duration-300 shadow-medium hover:shadow-glow transform hover:scale-105 active:scale-95',
                useJsonFile ? 'bg-gradient-to-r from-secondary-600 to-secondary-700 hover:from-secondary-700 hover:to-secondary-800' : 'bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800'
              ]">
                <span class="flex items-center justify-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                  </svg>
                  {{ useJsonFile ? 'Load from JSON' : 'Analyze Demo Form' }}
                </span>
              </button>
            </div>

            <!-- Save & Reanalyze -->
            <div v-else-if="isAnalyzed && !isUploading" key="save-reanalyze"
              class="flex items-center justify-center gap-3 mt-6 relative z-50">
              <button @click="saveAnalysis"
                class="bg-gradient-to-r from-primary-600 to-primary-700 w-full max-w-[120px] h-12 rounded-xl text-white font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-medium hover:shadow-glow transform hover:scale-105 active:scale-95">
                <span class="flex items-center justify-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                  </svg>
                  Save
                </span>
              </button>
              <button @click="reanalyze"
                class="bg-gradient-to-r from-red-600 to-red-700 w-full max-w-[200px] h-12 rounded-xl text-white font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-medium hover:shadow-lg transform hover:scale-105 active:scale-95">
                <span class="flex items-center justify-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                  </svg>
                  Re-analyze
                </span>
              </button>
            </div>
          </transition>
        </div>
      </transition>
    </div>

    <!-- Three Cards column-->
    <div class="flex items-center justify-center -mt-8 mb-8 px-4">
      <div class="flex flex-col md:flex-row gap-6 md:gap-8 max-w-6xl w-full">
        <!-- First card -->
        <div class="bg-white w-full md:w-80 h-auto rounded-2xl shadow-large px-6 py-6 z-20 transform transition-all duration-300 hover:scale-105 hover:shadow-glow animate-slideInLeft group">
          <div class="bg-gradient-to-br from-blue-100 to-blue-200 w-14 h-14 rounded-2xl flex justify-center items-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <img src="/images/magic.png" class="w-8 h-8 object-cover" alt="AI Magic Icon">
          </div>
          <h1 class="text-lg font-bold text-gray-800 mb-3">AI-Powered Analysis</h1>
          <p class="text-sm text-gray-600 leading-relaxed">Automatically extract and analyze form fields, patterns, and user behavior with advanced AI technology</p>
        </div>

        <!-- Second card -->
        <div class="bg-white w-full md:w-80 h-auto rounded-2xl shadow-large px-6 py-6 z-20 transform transition-all duration-300 hover:scale-105 hover:shadow-glow animate-slideInUp group">
          <div class="bg-gradient-to-br from-secondary-100 to-secondary-200 w-14 h-14 rounded-2xl flex justify-center items-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <img src="/images/graph.png" class="w-8 h-8 object-cover" alt="Dashboard Icon">
          </div>
          <h1 class="text-lg font-bold text-gray-800 mb-3">Interactive Dashboard</h1>
          <p class="text-sm text-gray-600 leading-relaxed">Visualize form metrics, completion rates, and conversion insights with beautiful, interactive charts</p>
        </div>

        <!-- Third card -->
        <div class="bg-white w-full md:w-80 h-auto rounded-2xl shadow-large px-6 py-6 z-20 transform transition-all duration-300 hover:scale-105 hover:shadow-glow animate-slideInRight group">
          <div class="bg-gradient-to-br from-primary-100 to-primary-200 w-14 h-14 rounded-2xl flex justify-center items-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <img src="/images/flash.png" class="w-8 h-8 object-cover" alt="Lightning Icon">
          </div>
          <h1 class="text-lg font-bold text-gray-800 mb-3">Instant Insights</h1>
          <p class="text-sm text-gray-600 leading-relaxed">Get actionable recommendations to improve form performance and drive better results</p>
        </div>
      </div>
    </div>

    <!-- Navbar -->
    <div>
      <Navbarheader @searchResults="handleSearchResults" />
    </div>

    <!-- Context -->
    <div id="AI-AgentContext" class="p-2 pt-24" data-resultssection>
      <AIAgentContext :analysisData="analysisData" :isSaved="isSaved" />
    </div>

    <!-- Tour -->
    <!-- <Tour ref="tour" />
    <button @click="startTour" class="fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 z-[9999]">
      Start Tour
    </button> -->

    <!-- ✅ SweetAlert-style Modal -->
    <transition name="scaleIn">
      <div v-if="alertVisible" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-[9999] p-4">
        <div class="bg-white rounded-3xl shadow-large w-full max-w-md p-8 text-center border-4 animate-scaleIn" :class="{
          'border-primary-500': alertType === 'success',
          'border-red-500': alertType === 'error',
          'border-yellow-400': alertType === 'warning'
        }">
          <div class="text-6xl mb-4 animate-bounceIn" :class="{
            'text-primary-600': alertType === 'success',
            'text-red-600': alertType === 'error',
            'text-yellow-500': alertType === 'warning'
          }">
            {{ alertIcon }}
          </div>
          <h2 class="text-2xl font-bold mb-3 text-gray-800">{{ alertTitle }}</h2>
          <p class="text-gray-600 mb-6 leading-relaxed">{{ alertMessage }}</p>
          <div class="flex justify-center gap-3">
            <button v-if="alertType === 'warning'" @click="confirmAction"
              class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-3 rounded-xl hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-medium hover:shadow-glow transform hover:scale-105 active:scale-95 font-semibold">
              Yes
            </button>
            <button @click="closeAlert" 
              class="bg-gradient-to-r from-gray-400 to-gray-500 text-white px-6 py-3 rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 shadow-medium hover:shadow-lg transform hover:scale-105 active:scale-95 font-semibold">
              {{ alertType === 'warning' ? 'Cancel' : 'OK' }}
            </button>
          </div>
        </div>
      </div>
    </transition>

    <LoadingPage :visible="loadingVisible" :job-id="jobId" :initial-text="loadingText" @complete="handleJobComplete"
      @error="handleJobError" />
    
    <!-- Loading Overlay for Save operation (similar to Export PDF) -->
    <LoadingOverlay :visible="isSaving" message="Saving your analysis..." />
  </div>
</template>

<script setup>
import AIAgentContext from "./AI-AgentContext.vue";
import Navbarheader from "../Layouts/Header.vue";
import LoadingPage from "../Components/LoadingPage.vue";
import LoadingOverlay from "../Components/LoadingOverlay.vue";
import Tour from "../Layouts/Tour.vue";
import { ref } from "vue";
import axios from "axios";
import { getUserFriendlyError, getUserFriendlyErrorTitle } from '../../utils/errorMessages.js';

const isDragging = ref(false);
const isUploading = ref(false);
const isAnalyzed = ref(false);
const isSaved = ref(false); // Track if analysis has been saved (for Export PDF button)
const isSaving = ref(false); // Track if save operation is in progress (for LoadingOverlay)
const uploadedFile = ref(null);
const uploadedFileURL = ref(null);
const analysisData = ref(null);
const cacheId = ref(null); // Store cache_id for save operation
const fileInput = ref(null);
const jobId = ref(null);
const useJsonFile = ref(false); // Toggle state: true = use JSON file, false = use API
const isReanalyzing = ref(false);

const successMessage = ref(""); // store text like "Successfully Analyze!" or "Successfully Re-analyze!"
const showSuccessMessage = ref(false); // control showing success box

const loadingVisible = ref(false); // control LoadingPage visibility
const loadingText = ref(""); // text to display in LoadingPage
const loadingProgress = ref(0);
let progressInterval = null;

// 🧩 Custom Alert System
const alertVisible = ref(false);
const alertType = ref("success");
const alertTitle = ref("");
const alertMessage = ref("");
const alertIcon = ref("");
let confirmCallback = null;

function showAlert(type, title, message, onConfirm = null) {
  alertType.value = type;
  alertTitle.value = title;
  alertMessage.value = message;
  alertVisible.value = true;
  confirmCallback = onConfirm;
  alertIcon.value =
    type === "success" ? "✔️" : type === "error" ? "❌" : "⚠️";
}
function closeAlert() {
  alertVisible.value = false;
}
async function confirmAction() {
  // ✅ CRITICAL FIX: Close alert FIRST before executing callback
  // This prevents LoadingPage from showing behind the alert
  closeAlert();
  
  // Small delay to ensure alert closes before showing loading
  await new Promise(resolve => setTimeout(resolve, 150));
  
  // Now execute the callback (which may show loading)
  if (confirmCallback) await confirmCallback();
}


// Helper function to extract error message from error object
function getErrorMessage(err) {
  if (!err) return "An error occurred. Please try again.";

  // Extract raw error message first
  let rawError = "";

  // Try to get error from response data
  if (err.response?.data) {
    const data = err.response.data;
    // If error is a string, use it
    if (typeof data.error === "string") {
      rawError = data.error;
    }
    // If error is an object, try to extract message
    else if (typeof data.error === "object" && data.error !== null) {
      rawError = data.error.message || data.error.error || JSON.stringify(data.error);
    }
    // Try message field
    else if (typeof data.message === "string") {
      rawError = data.message;
    }
    // If data itself is a string
    else if (typeof data === "string") {
      rawError = data;
    }
  }

  // Fallback to err.message
  if (!rawError) {
    if (typeof err.message === "string") {
      rawError = err.message;
    } else if (typeof err.message === "object") {
      rawError = err.message?.message || JSON.stringify(err.message);
    }
  }

  // Convert to user-friendly message
  return getUserFriendlyError(rawError || err);
}

function onDragOver() {
  isDragging.value = true;
}
function onDragLeave() {
  isDragging.value = false;
}

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
    showAlert("error", "Invalid file type", "Invalid file type. Only PDF, JPG, JPEG, PNG allowed.");
    return;
  }
  uploadedFile.value = file;
  uploadedFileURL.value = URL.createObjectURL(file);
  isUploading.value = true;
  setTimeout(() => {
    isUploading.value = false;
  }, 2000);
}

// ✅ Toggle JSON file mode
function toggleJsonMode() {
  useJsonFile.value = !useJsonFile.value;
  console.log("🔄 Toggle JSON mode:", useJsonFile.value ? "ON (Using JSON file)" : "OFF (Using API)");
}

// ✅ Load analysis from JSON file
async function loadFromJsonFile() {
  try {
    loadingText.value = "Loading from JSON file...";
    loadingVisible.value = true;
    loadingProgress.value = 0;

    const response = await axios.get("/json_file/demo_output.json");
    console.log("📄 JSON File Response:", response.data);

    // Extract the first report from the JSON structure
    // JSON structure: { result: { reports: [...] } }
    const jsonData = response.data;
    let reportData = null;

    if (jsonData.result && jsonData.result.reports && jsonData.result.reports.length > 0) {
      reportData = jsonData.result.reports[0];
    } else if (jsonData.reports && jsonData.reports.length > 0) {
      reportData = jsonData.reports[0];
    } else if (jsonData.analysis) {
      // If it's already in the expected format
      reportData = jsonData;
    } else {
      throw new Error("Invalid JSON structure. Expected 'result.reports[0]' or 'reports[0]' or 'analysis'");
    }

    // Set the analysis data
    analysisData.value = reportData;
    console.log("✅ Analysis data loaded from JSON:", analysisData.value);
    console.log("✅ Has form_id:", analysisData.value?.form_id);
    console.log("✅ Has analysis:", !!analysisData.value?.analysis);

    // Set cache_id if available
    if (reportData.cache_id) {
      cacheId.value = reportData.cache_id;
    } else if (jsonData.cache_id) {
      cacheId.value = jsonData.cache_id;
    }

    loadingVisible.value = false;
    loadingProgress.value = 0;

    isAnalyzed.value = true;
    isSaved.value = false;
    showAlert("success", "Analysis Complete", "Analysis loaded from JSON file successfully!");

    successMessage.value = "Successfully Analyze!";
    showSuccessMessage.value = true;

  } catch (err) {
    console.error("❌ JSON file loading error:", err);
    showAlert("error", "Load Failed", `Failed to load JSON file: ${getErrorMessage(err)}`);
    loadingVisible.value = false;
    loadingProgress.value = 0;
  }
}

// ✅ Analyze button — send file to API or load from JSON
// ✅ Analyze button — send file to API with background support
async function startAnalysis() {
  // ✅ If toggle is ON, use JSON file
  if (useJsonFile.value) {
    await loadFromJsonFile();
    return;
  }

  // ✅ Otherwise, use API (original behavior)
  if (!uploadedFile.value) {
    showAlert("warning", "No file", "Please upload a file first!");
    return;
  }

  loadingText.value = "Analyzing file...";
  loadingVisible.value = true;
  loadingProgress.value = 0;

  isUploading.value = true;
  try {
    const formData = new FormData();
    formData.append("file", uploadedFile.value);
    formData.append("background", "true"); // ✅ Enable background processing

    const { data } = await axios.post("/api/analyze-file", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    console.log("📊 API Response:", data);

    // ✅ Check if background job was queued
    if (data.status === 'queued' && data.job_id) {
      // Background mode - use LoadingPage with jobId for progress polling
      jobId.value = data.job_id;
      loadingText.value = data.message || "Processing started in background...";
      // LoadingPage component will automatically poll for progress
      // Don't hide loading yet - wait for job to complete
      // Keep isUploading = true to prevent buttons from showing prematurely
      return;
    }

    // ✅ Synchronous mode (old behavior) - process immediately
    // Store cache_id if available
    if (data.cache_id) {
      cacheId.value = data.cache_id;
      console.log("✅ Cache ID stored:", cacheId.value);
    } else if (data.analysis?.cache_id) {
      cacheId.value = data.analysis.cache_id;
      console.log("✅ Cache ID stored from analysis:", cacheId.value);
    }

    // Set the analysis data
    // The component expects the full report object (with form_id, analysis, graph_suggestions, etc.)
    if (data.analysis) {
      analysisData.value = data.analysis;
      console.log("✅ Analysis data set:", analysisData.value);
      console.log("✅ Has form_id:", analysisData.value?.form_id);
      console.log("✅ Has analysis:", !!analysisData.value?.analysis);
    } else {
      console.warn("⚠️ No 'analysis' key found, using full response");
      analysisData.value = data;
    }

    // Ensure loading is hidden
    loadingVisible.value = false;
    loadingProgress.value = 0;

    isAnalyzed.value = true;
    isSaved.value = false;
    isUploading.value = false; // ✅ Set to false for synchronous mode success
    showAlert("success", "Analysis Complete", "Your file has been analyzed successfully!");

    successMessage.value = "Successfully Analyze!";
    showSuccessMessage.value = true;

    // Hide loading for synchronous mode
    loadingVisible.value = false;
    loadingProgress.value = 0;
  } catch (err) {
    console.error("❌ Analysis error:", err);
    showAlert("error", "Analyze failed", getErrorMessage(err));
    loadingVisible.value = false;
    loadingProgress.value = 0;
    isUploading.value = false; // ✅ Set to false on error for synchronous mode
  }
  // Note: For background jobs, isUploading is set to false in handleJobComplete/handleJobError
}
// ✅ Handle job completion from LoadingPage
function handleJobComplete(result) {
  console.log("✅ Job completed with result:", result);

  try {
    // Result structure from backend:
    // {
    //   job_id: string,
    //   status: "complete",
    //   progress: 100,
    //   message: "Complete!",
    //   result: {
    //     analysis: {...},    // The actual report data
    //     status: "success",
    //     total_reports: 1,
    //     cache_id: "..."
    //   }
    // }

    if (!result || (!result.reports && !result.analysis)) {  // ✅ Check for actual data
      showAlert("error", "Invalid Result", "...");
      return;
    }
    const jobResult = result;  // ✅ Use result directly (no nesting)



    // ✅ Extract cache_id first (important for save operation)
    if (jobResult.cache_id) {
      cacheId.value = jobResult.cache_id;
      console.log("✅ Cache ID stored:", cacheId.value);
    }

    // ✅ Extract analysis data
    if (jobResult.analysis) {
      // Backend already formatted it for us
      analysisData.value = jobResult.analysis;
      console.log("✅ Analysis data set from formatted result");
    } else if (jobResult.reports && jobResult.reports.length > 0) {
      // Fallback: extract from reports array
      const firstReport = jobResult.reports[0];
      analysisData.value = firstReport;

      // Try to get cache_id from report if not already set
      if (!cacheId.value && firstReport.cache_id) {
        cacheId.value = firstReport.cache_id;
      }
      console.log("✅ Analysis data set from reports array");
    } else {
      console.error("❌ No analysis data found in result");
      showAlert("error", "No Data", "No analysis data found in the result");
      return;
    }

    // ✅ Update UI state
    isAnalyzed.value = true;
    isSaved.value = false;

    // ✅ Show success message
    successMessage.value = "Successfully Analyzed!";
    showSuccessMessage.value = true;

    showAlert("success", "Analysis Complete", "Your file has been analyzed successfully!");

    console.log("✅ Final state:", {
      hasAnalysisData: !!analysisData.value,
      hasCacheId: !!cacheId.value,
      cacheId: cacheId.value
    });

  } catch (err) {
    console.error("❌ Error processing job result:", err);
    showAlert("error", "Processing Error", "Failed to process analysis result");
  } finally {
    // ✅ Hide loading and clear job ID
    loadingVisible.value = false;
    loadingProgress.value = 0;
    jobId.value = null;
    isUploading.value = false; // ✅ Set to false when job completes (success or error)
  }
}

// ✅ Handle job error from LoadingPage
function handleJobError(errorInfo) {
  // Log technical error for debugging
  console.error("❌ Job failed (technical):", errorInfo);

  // Extract raw error message
  const rawErrorMessage = typeof errorInfo === 'string'
    ? errorInfo
    : errorInfo?.message || errorInfo?.error || 'Job processing failed';

  // Convert to user-friendly message
  const userFriendlyMessage = getUserFriendlyError(rawErrorMessage);
  const userFriendlyTitle = getUserFriendlyErrorTitle(rawErrorMessage);

  // Hide loading page
  loadingVisible.value = false;
  loadingProgress.value = 0;

  // Reset job ID
  jobId.value = null;

  // Show user-friendly error alert
  showAlert(
    "error",
    userFriendlyTitle,
    userFriendlyMessage
  );

  // ✅ Reset upload state when job fails
  isUploading.value = false;
}

// ✅ Re-analyze (re-send the same file)
async function reanalyze() {
  isReanalyzing.value = true;

  // ✅ CRITICAL FIX: Reset all state BEFORE showing loading
  showSuccessMessage.value = false;
  isAnalyzed.value = false;
  isSaved.value = false;
  analysisData.value = null;
  cacheId.value = null;
  jobId.value = null; // ✅ Clear jobId FIRST
  
  // ✅ Hide loading first, then show again to force reset
  loadingVisible.value = false;
  await new Promise(resolve => setTimeout(resolve, 100)); // Small delay to ensure reset
  
  // ✅ Now set loading state with fresh values
  loadingText.value = "Re-analyzing file...";
  loadingProgress.value = 0;
  loadingVisible.value = true;

  try {
    await startAnalysis();
  } finally {
    isReanalyzing.value = false;
  }
}


// ✅ Save button (send confirmation)
async function saveAnalysis() {
  if (!cacheId.value) {
    showAlert("error", "Missing cache Id", "Error: No cache ID found. Please analyze the file first.");
    console.error("❌ No cache_id available for save operation");
    return;
  }

  // 🟡 Step 1: Ask for confirmation before saving
  showAlert(
    "warning",
    "Confirm Save",
    "Are you sure you want to save it? If yes, click 'Yes'. If not, click 'Cancel' and reanalyze it again.",
    async () => {
      // ✅ Note: Alert is already closed by confirmAction() before this callback runs
      // ✅ Use LoadingOverlay (similar to Export PDF) - no progress bar
      isSaving.value = true;
      
      try {
        const cacheIdString = String(cacheId.value);
        console.log("💾 Saving analysis with cache_id:", cacheIdString);
        
        const response = await axios.post("/api/confirm-analysis", {
          cache_id: cacheIdString,
          approved: true,
        });

        console.log("✅ Save response:", response.data);

        // 🟢 Step 2: Mark as saved (for Export PDF button to appear)
        isSaved.value = true;

        // 🟢 Step 3: Hide success message and reset to original upload state
        showSuccessMessage.value = false;
        isAnalyzed.value = false; // Reset to show "Analyze Form" button instead of Save/Re-analyze

        // 🟢 Step 4: Show success alert
        showAlert("success", "Saved Successfully!", "Your analysis has been saved successfully! You can now export to PDF.");

      } catch (err) {
        console.error("❌ Save error:", err);
        showAlert("error", "Save Failed", getErrorMessage(err));
      } finally {
        // ✅ Always hide loading overlay after save completes
        isSaving.value = false;
      }
    }
  );
}

function viewFile() {
  if (uploadedFileURL.value) {
    window.open(uploadedFileURL.value, "_blank");
  }
}

function deleteFile() {
  showAlert(
    "warning",
    "Delete File?",
    "Are you sure you want to delete this file?",
    () => {
      // ✅ Only executes when the user clicks "Yes"
      if (uploadedFileURL.value) URL.revokeObjectURL(uploadedFileURL.value);
      uploadedFile.value = null;
      uploadedFileURL.value = null;
      isAnalyzed.value = false;
      isSaved.value = false; // Reset saved state when deleting file
      analysisData.value = null;
      cacheId.value = null; // Clear cache_id when deleting

      // 🧹 Reset input so re-upload works immediately
      if (fileInput.value) fileInput.value.value = "";

      console.log("🗑️ File deleted successfully");
      showAlert("success", "Deleted!", "The uploaded file has been removed successfully.");
    }
  );
}

// ✅ Handle search results from Header component
function handleSearchResults(searchResult) {
  console.log("🔍 Search result received:", searchResult);

  // Check if it's an error
  if (searchResult && searchResult.error) {
    console.error("❌ Search error:", searchResult.message);
    showAlert("error", "Search Failed", searchResult.message || "No results found.");
    return;
  }

  // Check if search result has the required structure
  if (!searchResult || (!searchResult.analysis && !searchResult._searchResults)) {
    console.warn("⚠️ Invalid search result structure:", searchResult);
    // Don't show alert for initial search (when _searchResults exists)
    if (!searchResult || !searchResult._searchResults) {
      showAlert("warning", "Invalid Result", "The search result format is invalid.");
    }
    return;
  }

  // ✅ PRIORITY: If it's multiple results (from initial search), do nothing
  // This means user just performed a search - only show results in dropdown
  // The user needs to click on a specific result to load it
  if (searchResult._searchResults) {
    console.log("📋 Multiple search results available, waiting for user selection...");
    // Do NOT process or display anything - just show results in dropdown
    return;
  }

  // ✅ If it's a single result (from clicking on a search result item)
  // This means user clicked on a specific result from the dropdown
  if (searchResult.analysis) {
    // Ensure the result has all required fields
    const formattedResult = {
      form_id: searchResult.form_id || `search_${Date.now()}`,
      file_name: searchResult.file_name || "Search Result",
      form_type: searchResult.form_type || "Search Result",
      report_number: searchResult.report_number || 1,
      analysis: searchResult.analysis,
      graph_suggestions: searchResult.graph_suggestions || { suggested_charts: [] },
      ...searchResult // Include any other properties
    };

    // Set the analysis data to display in AI-AgentContext
    analysisData.value = formattedResult;
    isSaved.value = true; // Assume search results are from saved analyses

    // Scroll to dashboard section
    setTimeout(() => {
      const dashboardSection = document.getElementById("AI-AgentContext");
      if (dashboardSection) {
        dashboardSection.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    }, 100);

    console.log("✅ Search result loaded:", analysisData.value);
    showAlert("success", "Result Loaded", "Search result has been loaded successfully!");
  }
}

const tour = ref(null);
function startTour() {
  tour.value.start()
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

.scaleIn-enter-active {
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.scaleIn-leave-active {
  transition: all 0.2s ease-in;
}

.scaleIn-enter-from {
  opacity: 0;
  transform: scale(0.8);
}

.scaleIn-leave-to {
  opacity: 0;
  transform: scale(0.9);
}

.bounceIn-enter-active {
  animation: bounceIn 0.6s ease-out;
}

.bounceIn-leave-active {
  transition: all 0.3s ease-in;
}

.bounceIn-enter-from,
.bounceIn-leave-to {
  opacity: 0;
}
</style>
