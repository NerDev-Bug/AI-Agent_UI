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
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Type to search..."
      class="w-[250px] rounded-full text-black outline-none shadow-md"
    />
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

const showSearch = ref(false);
const searchQuery = ref("");
const searchBtn = ref(null);
const searchBarStyle = ref({});
const activeSection = ref("home");
const showChat = ref(false);

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
