<template>
  <nav class="text-white rounded-full px-6 py-2 w-[650px] h-10 flex items-center justify-between
           fixed top-5 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300"
    style="background: linear-gradient(to right, #00953F, #005F0F);">

    <button @click="scrollToSection('home')" :class="[
      'font-semibold px-4 py-1 rounded-full transition',
      activeSection === 'home'
        ? 'bg-white text-[#00853F]'
        : 'hover:bg-white hover:text-[#00853F]'
    ]">
      Home
    </button>

    <button @click="scrollToSection('dashboard')" :class="[
      'font-semibold px-4 py-1 rounded-full transition',
      activeSection === 'dashboard'
        ? 'bg-white text-[#00853F]'
        : 'hover:bg-white hover:text-[#00853F]'
    ]">
      Dashboard
    </button>

    <button ref="searchBtn" @click="showSearch = !showSearch"
      class="font-semibold px-4 py-1 hover:bg-white hover:text-[#00853F] rounded-full transition relative">
      Search
    </button>
  </nav>

  <div v-if="showSearch" class="absolute z-50" :style="searchBarStyle">
    <input type="text" v-model="searchQuery" placeholder="Type to search..."
      class="w-[250px] rounded-full text-black outline-none shadow-md" />
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";

const showSearch = ref(false);
const searchQuery = ref("");
const searchBtn = ref(null);
const searchBarStyle = ref({});
const activeSection = ref("home");

function scrollToSection(section) {
  const el = document.getElementById(section === "home" ? "AI-AgentForm" : "AI-AgentContext");
  if (el) {
    el.scrollIntoView({ behavior: "smooth" });
  }
  activeSection.value = section;
}

function handleScroll() {
  const homeSection = document.getElementById("AI-AgentForm");
  const dashboardSection = document.getElementById("AI-AgentContext");
  if (!homeSection || !dashboardSection) return;

  const scrollY = window.scrollY;
  const homeTop = homeSection.offsetTop - 150;
  const dashboardTop = dashboardSection.offsetTop - 150;

  if (scrollY >= dashboardTop) {
    activeSection.value = "dashboard";
  } else {
    activeSection.value = "home";
  }
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
