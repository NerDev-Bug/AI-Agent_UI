<template>
  <!-- Navigation Bar -->
  <nav class="text-white rounded-full px-3 sm:px-6 py-2 sm:py-3 w-[92vw] sm:w-full max-w-[680px]
         flex flex-row sm:flex-row items-center justify-between gap-2
         fixed top-3 sm:top-5 left-1/2 -translate-x-1/2 z-50
         shadow-large backdrop-blur-sm transition-all duration-300"
    style="background: linear-gradient(135deg, #16a34a 0%, #15803d 50%, #166534 100%);">

    <!-- HOME -->
    <button @click="scrollToSection('home')" :class="[
      'flex-1 sm:flex-none font-semibold px-4 py-2 rounded-full transition-all duration-300 text-center hover:scale-105 active:scale-95',
      activeSection === 'home'
        ? 'bg-white text-primary-600 shadow-medium'
        : 'hover:bg-white hover:text-primary-600 hover:shadow-soft'
    ]">
      Home
    </button>

    <!-- DASHBOARD -->
    <button @click="scrollToSection('dashboard')" :class="[
      'flex-1 sm:flex-none font-semibold px-4 py-2 rounded-full transition-all duration-300 text-center hover:scale-105 active:scale-95',
      activeSection === 'dashboard'
        ? 'bg-white text-primary-600 shadow-medium'
        : 'hover:bg-white hover:text-primary-600 hover:shadow-soft'
    ]">
      Dashboard
    </button>

    <!-- LIST BUTTON -->
    <button @click="showListCard = !showListCard"
      class="flex-1 sm:flex-none font-semibold px-4 py-2 rounded-full transition-all duration-300 text-center hover:bg-white hover:text-primary-600 hover:scale-105 active:scale-95 relative group">
      <span class="flex items-center justify-center sm:gap-2 gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          class="w-4 h-4 sm:w-5 sm:h-5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v..." />
        </svg>
        <span class="hidden sm:inline">List</span>
      </span>

      <!-- Tooltip (mobile-safe) -->
      <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 px-2 py-1.5 bg-gray-900 text-white text-xs rounded-lg
             opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap hidden sm:block z-50">
        View all reports (Coming soon)
        <span class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></span>
      </span>
    </button>

    <!-- DASHBOARD -->
    <button class="
      'flex-1 sm:flex-none font-semibold px-4 py-2 rounded-full transition-all duration-300 text-center hover:scale-105 active:scale-95',
      'hover:bg-white hover:text-white hover:shadow-soft'">
      Logout
    </button>
  </nav>

  <!-- HALF SCREEN RIGHT PANEL -->
  <div v-if="showListCard" class="fixed top-0 right-0 h-full w-full md:w-2/3 bg-white shadow-2xl border-l border-gray-300 z-50
         animate-slide-left flex flex-col">
    <div class="p-4 border-b flex items-center justify-between">
      <h2 class="text-xl font-semibold">All Reports</h2>

      <button @click="showListCard = false"
        class="text-gray-600 hover:bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center">
        ✕
      </button>
    </div>

    <!-- Content inside the panel -->
    <div class="p-4 overflow-y-auto flex-1">
      <p class="text-gray-600">List contents will go here…</p>
    </div>
  </div>


  <!-- Search Input + Dropdown Panel -->
  <!-- <div v-if="showSearch" class="absolute z-50 w-full px-4 sm:px-0" :style="searchBarStyle">
    <div
      class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 bg-white rounded-2xl sm:rounded-full shadow-lg border-2 p-3 sm:p-2"
      :class="isSearching ? 'border-blue-500' : 'border-green-500'">
      <input type="text" v-model="searchQuery" @keyup.enter="performSearch" placeholder="Search analysis reports..."
        :disabled="isSearching"
        class="w-full sm:w-72 rounded-full text-black outline-none px-4 py-2 disabled:opacity-50 disabled:cursor-not-allowed" />
      <button @click="performSearch" :disabled="isSearching || !searchQuery.trim()"
        class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
        <svg v-if="!isSearching" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
          stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        <svg v-else class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <span v-if="!isSearching">Search</span>
        <span v-else>Searching...</span>
      </button>
    </div>

    <div class="mt-2 w-full max-w-sm bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">

      <div v-if="isSearching" class="p-3 text-center">
        <p class="text-blue-600 font-medium animate-pulse text-sm">Searching for results...</p>
      </div>

      <div v-else-if="searchPerformed && searchResults.length === 0" class="p-3 text-center text-gray-500 text-sm">
        No results found for "{{ lastSearchedQuery }}"
      </div>

      <div v-else-if="searchResults.length > 0" class="max-h-[280px] overflow-y-auto">
        <div v-for="(result, index) in searchResults" :key="result.form_id"
          class="px-4 py-2 hover:bg-green-100 cursor-pointer border-b last:border-b-0"
          @click="selectSearchResult(result)">
          <p class="font-semibold text-black">{{ result.analysis.basic_info.applicant || result.file_name }}</p>
          <p class="text-sm text-gray-600">{{ result.analysis.basic_info.product || result.form_type }} • Score: {{
            result._searchScore }}</p>
        </div>
      </div>
    </div>
  </div> -->



  <!-- Chat Container -->
  <div class="fixed bottom-6 right-6 flex flex-col items-end gap-4 z-50">
    <!-- Chat Window -->
    <div v-if="showChat"
      class="bg-white w-[90vw] max-w-md h-[70vh] max-h-[520px] rounded-2xl border border-gray-300 shadow-xl flex flex-col overflow-hidden">
      <!-- Chat Header -->
      <div
        class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-5 py-4 font-semibold flex justify-between items-center shadow-medium">
        <h1 class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
          </svg>
          Pandoy AI Assistant
        </h1>
        <button @click="showChat = false"
          class="text-white font-bold text-2xl hover:bg-white hover:bg-opacity-20 rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200"
          aria-label="Close chat">×</button>
      </div>

      <!-- Messages -->
      <div ref="chatBody" class="flex-1 overflow-y-auto p-4 bg-white flex flex-col items-center justify-center">
        <!-- Coming Soon Message -->
        <div class="flex flex-col items-center justify-center text-center px-6 py-8">
          <div class="bg-gradient-to-br from-primary-100 to-primary-50 rounded-full p-6 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-12 h-12 text-primary-600">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Coming Soon</h3>
          <p class="text-gray-600 text-sm leading-relaxed max-w-sm">
            Pandoy AI Assistant is currently under development. We're working hard to bring you an intelligent assistant
            that can help answer your questions about your analysis reports.
          </p>
          <div class="mt-4 flex items-center gap-2 text-primary-600 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Stay tuned for updates!</span>
          </div>
        </div>
      </div>

      <!-- Input (Disabled) -->
      <div class="flex items-center gap-2 p-3 border-t border-gray-200 bg-gray-50">
        <input type="text" placeholder="Coming soon..." disabled
          class="flex-1 border border-gray-200 rounded-full px-4 py-2 text-sm bg-white text-gray-400 cursor-not-allowed" />
        <button type="button" disabled
          class="bg-gray-300 text-gray-500 px-5 py-2 rounded-full cursor-not-allowed font-semibold">
          Send
        </button>
      </div>
    </div>

    <!-- Chat Avatar -->
    <button @click="showChat = !showChat"
      class="bg-white w-14 h-14 sm:w-[60px] sm:h-[60px] rounded-full border-4 border-primary-500 shadow-large overflow-hidden hover:scale-110 hover:shadow-glow transition-all duration-300 transform hover:rotate-6 active:scale-95"
      aria-label="Open AI Assistant Chat">
      <img src="/images/Pandoy.png" alt="Chat Avatar" class="w-full h-full object-cover" />
    </button>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount, nextTick } from "vue";
import axios from "axios";

// Define emits for parent component
const emit = defineEmits(["searchResults"]);

const SEARCH_PANEL_WIDTH = 360;
const showListCard = ref(false);

const showSearch = ref(false);
const searchQuery = ref("");
const searchBtn = ref(null);
const searchBarStyle = ref({});
const activeSection = ref("home");
const showChat = ref(false);
const isSearching = ref(false);

const searchResults = ref([]);
const searchPerformed = ref(false);
const lastSearchedQuery = ref(""); // Store the last query that was actually searched

const messages = ref([]);
const newMessage = ref("");
const chatBody = ref(null);
const handleResize = () => {
  if (showSearch.value) updateSearchBarPosition();
};

function sendMessage() {
  // Disabled - Coming Soon
  return;
}

function scrollToSection(section) {
  const el = document.getElementById(
    section === "home" ? "AI-AgentForm" : "AI-AgentContext"
  );
  if (el) el.scrollIntoView({ behavior: "smooth" });
  activeSection.value = section;
}

function handleScroll() {
  const homeSection = document.getElementById("AI-AgentForm");
  const dashboardSection = document.getElementById("AI-AgentContext");
  if (!homeSection || !dashboardSection) return;

  const scrollY = window.scrollY;
  const homeTop = homeSection.offsetTop - 150;
  const dashboardTop = dashboardSection.offsetTop - 150;

  activeSection.value = scrollY >= dashboardTop ? "dashboard" : "home";
}

function updateSearchBarPosition() {
  if (searchBtn.value) {
    const rect = searchBtn.value.getBoundingClientRect();
    const availableWidth = window.innerWidth - 32;
    const panelWidth = Math.min(SEARCH_PANEL_WIDTH, availableWidth);
    const desiredLeft = rect.left + rect.width / 2 - panelWidth / 2;
    const maxLeft = window.innerWidth - panelWidth - 16;
    const clampedLeft = Math.max(16, Math.min(desiredLeft, maxLeft));
    searchBarStyle.value = {
      top: `${rect.bottom + 10}px`,
      left: `${clampedLeft}px`,
      width: `${panelWidth}px`,
      position: "fixed",
    };
  }
}

watch(showSearch, (val) => {
  if (val) updateSearchBarPosition();
  // Reset search state when closing search
  if (!val) {
    searchQuery.value = "";
    searchResults.value = [];
    searchPerformed.value = false;
    lastSearchedQuery.value = "";
  }
});

// Watch search query changes to reset search state when user types new text
watch(searchQuery, (newQuery, oldQuery) => {
  // Only reset if not currently searching and a search was previously performed
  if (!isSearching.value && searchPerformed.value) {
    // Reset search results and performed flag when query changes
    searchResults.value = [];
    searchPerformed.value = false;
    lastSearchedQuery.value = "";
  }
});

watch(showListCard, (isOpen) => {
  if (isOpen) {
    document.body.style.overflow = "hidden";   // ❌ Disable background scrolling
  } else {
    document.body.style.overflow = "";         // ✔ Restore scrolling
  }
});


async function performSearch() {
  if (!searchQuery.value.trim() || isSearching.value) return;

  isSearching.value = true;
  searchPerformed.value = false;
  searchResults.value = [];
  const currentQuery = searchQuery.value.trim();
  lastSearchedQuery.value = currentQuery; // Store the query being searched

  try {
    const response = await axios.post("/api/analysis-search", {
      query: currentQuery,
      top_k: 10,
    });

    const searchData = transformSearchResultsToAnalysisData(response.data);

    if (searchData._searchResults) {
      searchResults.value = searchData._searchResults;
    }

    emit("searchResults", searchData);
    searchPerformed.value = true;
  } catch (error) {
    console.error("Search error:", error);
    searchPerformed.value = true;
    searchResults.value = [];
    emit("searchResults", {
      error: true,
      message: error.response?.data?.error || "Search failed. Please try again.",
      query: currentQuery,
    });
  } finally {
    isSearching.value = false;
  }
}

function selectSearchResult(result) {
  emit("searchResults", result);
  showSearch.value = false;
  searchQuery.value = "";
  searchResults.value = [];
  searchPerformed.value = false;
  lastSearchedQuery.value = "";
}

// Transform search results to match the analysis data format used in dashboard
// Note: full_analysis from search is the EXACT same JSON structure saved in database
// Returns ALL search results transformed, not just the first one
function transformSearchResultsToAnalysisData(searchResponse) {
  if (!searchResponse.results || searchResponse.results.length === 0) {
    return {
      error: true,
      message: searchResponse.message || "No results found",
      query: searchResponse.query,
    };
  }

  // Log the raw results to verify order
  console.log("🔍 Raw search results:", searchResponse.results);
  console.log("🔍 First result applicant:", searchResponse.results[0]?.full_analysis?.basic_info?.applicant || searchResponse.results[0]?.cooperator);
  console.log("🔍 First result score:", searchResponse.results[0]?.score);

  // Transform ALL search results, not just the first one
  const transformedResults = searchResponse.results.map((result, index) => {
    // full_analysis is the EXACT same JSON structure that was saved
    // It already has the complete analysis structure (basic_info, performance_analysis, etc.)
    if (result.full_analysis && typeof result.full_analysis === 'object' && Object.keys(result.full_analysis).length > 0) {
      // full_analysis is already the complete analysis object, just wrap it with metadata
      return {
        form_id: result.id || `search_${Date.now()}_${index}`,
        file_name: `${result.product || "Search Result"} - ${result.location || ""}`,
        form_type: result.form_type || "Search Result",
        report_number: result.report_number || (index + 1),
        // full_analysis is the EXACT saved JSON - same format as analysis from upload
        analysis: result.full_analysis,
        graph_suggestions: result.graph_suggestions || { suggested_charts: [] },
        _searchScore: result.score || 0,
        _searchIndex: index,
      };
    }

    // Fallback: If full_analysis is missing (shouldn't happen if data was saved properly)
    console.warn(`⚠️ Search result #${index} missing full_analysis, using fallback structure`);
    return {
      form_id: result.id || `search_${Date.now()}_${index}`,
      file_name: `${result.product || "Search Result"} - ${result.location || ""}`,
      form_type: result.form_type || "Search Result",
      report_number: result.report_number || (index + 1),
      analysis: {
        basic_info: {
          applicant: result.product || "",
          application_date: "",
          cooperator: result.cooperator || "",
          product: result.product || "",
          location: result.location || "",
          crop: result.crop || "",
          plot_size: "",
          planting_date: "",
        },
        performance_analysis: {
          calculated_metrics: {
            control_average: result.control_average || 0,
            leads_average: result.leads_average || 0,
            absolute_difference: (result.leads_average || 0) - (result.control_average || 0),
            relative_improvement_percent: result.improvement_percent || 0,
          },
          statistical_assessment: {
            improvement_significance: result.performance_significance || "moderate",
            significance_basis: "",
            performance_consistency: "medium",
            confidence_level: "medium",
          },
          scale_info: "",
          raw_data: {},
          trend_analysis: {},
        },
        treatment_comparison: {},
        executive_summary: result.executive_summary || result.summary || "",
        opportunities: [],
        risk_factors: [],
        recommendations: [],
      },
      graph_suggestions: result.graph_suggestions || { suggested_charts: [] },
      _searchScore: result.score || 0,
      _searchIndex: index,
    };
  });

  // Verify first result is the highest score
  const firstResult = transformedResults[0];
  console.log("🔍 First transformed result:", firstResult);
  console.log("🔍 First result applicant:", firstResult?.analysis?.basic_info?.applicant);
  console.log("🔍 First result form_id:", firstResult?.form_id);
  console.log("🔍 First result score:", firstResult?._searchScore);

  // Return the first result as default (should be highest score from backend)
  // Include all results for selection dropdown
  return {
    ...firstResult, // Default to first result (highest score from backend)
    _searchResults: transformedResults, // All transformed results for selection
    _isSearchResult: true,
    _searchQuery: searchResponse.query,
    _totalResults: transformedResults.length,
  };
}

onMounted(() => {
  window.addEventListener("resize", handleResize);
  window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", handleScroll);
  window.removeEventListener("resize", handleResize);
});
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(-4px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.18s ease-out;
}
</style>