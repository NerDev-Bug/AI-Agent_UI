<template>
  <nav
    class="text-white rounded-full px-6 py-2 w-[650px] h-10 flex items-center justify-between
           fixed top-5 left-1/2 transform -translate-x-1/2 z-50"
    style="background: linear-gradient(to right, #00953F, #005F0F);"
  >
    <!-- Navbar buttons -->
    <button class="font-semibold px-4 py-1 hover:bg-white hover:text-[#00853F] rounded-full transition">
      Home
    </button>
    <button class="font-semibold px-4 py-1 hover:bg-white hover:text-[#00853F] rounded-full transition">
      Dashboard
    </button>
    
    <!-- Search button -->
    <button
      ref="searchBtn"
      @click="showSearch = !showSearch"
      class="font-semibold px-4 py-1 hover:bg-white hover:text-[#00853F] rounded-full transition relative"
    >
      Search
    </button>
  </nav>

  <!-- Search bar below the Search button -->
  <div
    v-if="showSearch"
    class="absolute z-50"
    :style="searchBarStyle"
  >
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Type to search..."
      class="w-[250px] rounded-full text-black outline-none shadow-md"
    />
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";

const showSearch = ref(false);
const searchQuery = ref("");
const searchBtn = ref(null);
const searchBarStyle = ref({});

function updateSearchBarPosition() {
  if (searchBtn.value) {
    const rect = searchBtn.value.getBoundingClientRect();
    searchBarStyle.value = {
      top: `${rect.bottom + 10}px`,      // a little below the button
      left: `${rect.right - 225}px`,    // align right edge of search bar with button
      position: "absolute",
    };
  }
}

// Watch for toggle
watch(showSearch, (val) => {
  if (val) {
    updateSearchBarPosition();
  }
});

onMounted(() => {
  window.addEventListener("resize", () => {
    if (showSearch.value) updateSearchBarPosition();
  });
});
</script>
