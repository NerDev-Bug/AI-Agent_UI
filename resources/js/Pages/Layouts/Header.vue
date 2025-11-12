<template>
  <!-- Navigation Bar -->
  <nav
    class="text-white rounded-full px-6 py-2 w-[650px] h-10 flex items-center justify-between
           fixed top-5 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300"
    style="background: linear-gradient(to right, #00953F, #005F0F);"
  >
    <button
      @click="scrollToSection('home')"
      :class="[
        'font-semibold px-4 py-1 rounded-full transition',
        activeSection === 'home'
          ? 'bg-white text-[#00853F]'
          : 'hover:bg-white hover:text-[#00853F]'
      ]"
    >
      Home
    </button>

    <button
      @click="scrollToSection('dashboard')"
      :class="[
        'font-semibold px-4 py-1 rounded-full transition',
        activeSection === 'dashboard'
          ? 'bg-white text-[#00853F]'
          : 'hover:bg-white hover:text-[#00853F]'
      ]"
    >
      Dashboard
    </button>

    <button
      ref="searchBtn"
      @click="showSearch = !showSearch"
      class="font-semibold px-4 py-1 hover:bg-white hover:text-[#00853F] rounded-full transition relative"
    >
      Search
    </button>
  </nav>

  <!-- Search Input -->
  <div v-if="showSearch" class="absolute z-50" :style="searchBarStyle">
    <div class="flex items-center gap-2 bg-white rounded-full shadow-lg border-2 border-green-500 p-2">
      <input
        type="text"
        v-model="searchQuery"
        @keyup.enter="performSearch"
        placeholder="Search analysis reports..."
        class="w-[300px] rounded-full text-black outline-none px-4 py-2"
      />
      <button
        @click="performSearch"
        :disabled="isSearching || !searchQuery.trim()"
        class="bg-green-600 text-white px-4 py-2 rounded-full hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
      >
        <svg
          v-if="!isSearching"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          class="w-5 h-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
          />
        </svg>
        <svg
          v-else
          class="animate-spin h-5 w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
          ></path>
        </svg>
        <span v-if="!isSearching">Search</span>
        <span v-else>Searching...</span>
      </button>
    </div>
  </div>


  <!-- Chat Container -->
  <div class="fixed bottom-6 right-6 flex flex-col items-end gap-4 z-50">
    <!-- Chat Window -->
    <div
      v-if="showChat"
      class="bg-white w-[450px] h-[520px] rounded-2xl border border-gray-300 shadow-xl flex flex-col overflow-hidden"
    >
      <!-- Chat Header -->
      <div class="bg-green-500 text-white px-4 py-4 font-semibold flex justify-between items-center">
        <h1>Pandoy AI Assistant</h1>
        <button @click="showChat = false" class="text-white font-bold text-xl">×</button>
      </div>

      <!-- Messages -->
<div ref="chatBody" class="flex-1 overflow-y-auto p-4 bg-white flex flex-col space-y-3">
  <div
    v-for="(msg, index) in messages"
    :key="index"
    :class="[
      'p-3 rounded-2xl max-w-[75%] break-words',
      msg.sender === 'ai'
        ? 'bg-gray-200 text-gray-800 self-start ml-2'
        : 'bg-green-500 text-white self-end mr-2'
    ]"
  >
    {{ msg.text }}
  </div>
</div>


      <!-- Input -->
      <form @submit.prevent="sendMessage" class="flex items-center gap-2 p-3 border-t border-gray-200">
        <input
          v-model="newMessage"
          type="text"
          placeholder="Type a message..."
          class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        />
        <button
          type="submit"
          class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition-colors duration-300"
        >
          Send
        </button>
      </form>
    </div>

    <!-- Chat Avatar -->
    <button
      @click="showChat = !showChat"
      class="bg-gray-400 w-[60px] h-[60px] rounded-full border-2 border-green-500 shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300"
    >
      <img src="/images/Pandoy.png" alt="Chat Avatar" class="w-full h-full object-cover" />
    </button>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount, nextTick } from "vue";
import axios from "axios";

// Define emits for parent component
const emit = defineEmits(["searchResults"]);

const showSearch = ref(false);
const searchQuery = ref("");
const searchBtn = ref(null);
const searchBarStyle = ref({});
const activeSection = ref("home");
const showChat = ref(false);
const isSearching = ref(false);

const messages = ref([
  { text: "Hello! How can I help you today?", sender: "ai" },
]);

const newMessage = ref("");
const chatBody = ref(null);

function sendMessage() {
  if (!newMessage.value.trim()) return;

  // Push user's message
  messages.value.push({ text: newMessage.value, sender: "user" });
  newMessage.value = "";

  // Auto scroll to bottom
  nextTick(() => {
    chatBody.value.scrollTop = chatBody.value.scrollHeight;
  });
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
    searchBarStyle.value = {
      top: `${rect.bottom + 10}px`,
      left: `${rect.right - 225}px`,
      position: "fixed",
    };
  }
}

watch(showSearch, (val) => {
  if (val) updateSearchBarPosition();
});

// Search functionality
async function performSearch() {
  if (!searchQuery.value.trim() || isSearching.value) return;

  isSearching.value = true;
  showSearch.value = false; // Close search input

  try {
    const response = await axios.post("/api/analysis-search", {
      query: searchQuery.value.trim(),
      top_k: 10,
    });

    // Transform search results to match analysis data format
    const searchData = transformSearchResultsToAnalysisData(response.data);
    
    // Emit search results to parent component
    emit("searchResults", searchData);
    
    // Scroll to dashboard section
    scrollToSection("dashboard");
    
    // Clear search query
    searchQuery.value = "";
  } catch (error) {
    console.error("Search error:", error);
    // Emit error state
    emit("searchResults", {
      error: true,
      message: error.response?.data?.error || "Search failed. Please try again.",
      query: searchQuery.value,
    });
  } finally {
    isSearching.value = false;
  }
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

  // Return the first result as default, but include all results for selection
  return {
    ...transformedResults[0], // Default to first result (highest score)
    _searchResults: transformedResults, // All transformed results for selection
    _isSearchResult: true,
    _searchQuery: searchResponse.query,
    _totalResults: transformedResults.length,
  };
}

onMounted(() => {
  window.addEventListener("resize", () => {
    if (showSearch.value) updateSearchBarPosition();
  });
  window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", handleScroll);
});
</script>
