<template>
    <div>
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-black">Agent Products Demo Trials</h2>
        </div>

        <!-- Select and Export -->
        <div class="flex items-center gap-6 mb-8 px-2">
            <div class="flex-2">
                <br>
                <button @click="handleExportClick" :disabled="isExporting"
                    class="bg-blue-500 w-[210px] h-12 rounded-lg text-white hover:bg-green-600 transition flex items-center justify-center gap-2">
                    <span v-if="!isExporting">Export to PDF</span>
                    <span v-else class="flex flex-row gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Exporting...
                    </span>
                </button>
            </div>

            <div class="ml-auto">
                <label class="block text-sm text-black mb-1">Select Cooperator:</label>
                <select v-model="selectedCooperator" class="p-2 rounded-md w-72">
                    <option value="">-- Choose Cooperator --</option>
                    <option v-for="coop in uniqueCooperators" :key="coop" :value="coop">
                        {{ coop }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Default placeholder shown only when no cooperator selected -->
        <div v-if="!selectedCooperator" class="text-black p-6 rounded-lg mt-10">
            <div class="flex items-center justify-center">
                <div class="bg-white w-[1200px] h-[440px] border-md rounded-lg px-4 py-4">
                    <h3 class="text-3xl font-semibold">Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        deleniti harum illum assumenda eos culpa quas ab molestias ipsa quisquam totam distinctio est.
                        Assumenda harum quam quasi earum repellendus eos!</h3>
                </div>
            </div>
        </div>

        <!-- Report Display -->
        <div v-if="currentReport && selectedCooperator" class="p-2 space-y-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">
                {{ currentReport.form_type }}
            </h3>

            <!-- Basic Info -->
            <div v-if="currentReport.analysis?.basic_info"
                class="bg-gray-50 border-l-4 border-green-500 p-4 rounded-md h-full">
                <h4 class="text-xl font-semibold text-green-700 mb-2">
                    🌾 Basic Information
                </h4>
                <ul class="grid grid-cols-2 gap-x-8 text-gray-700">
                    <li><b>Cooperator:</b> {{ currentReport.analysis.basic_info.cooperator }}</li>
                    <li><b>Product:</b> {{ currentReport.analysis.basic_info.product }}</li>
                    <li><b>Location:</b> {{ currentReport.analysis.basic_info.location }}</li>
                    <li><b>Crop:</b> {{ currentReport.analysis.basic_info.crop }}</li>
                    <li><b>Application Date:</b> {{ currentReport.analysis.basic_info.application_date }}</li>
                    <li><b>Planting Date:</b> {{ currentReport.analysis.basic_info.planting_date }}</li>
                </ul>
            </div>

            <!-- 🌟 Performance Metrics Section -->
            <div v-if="currentReport.analysis?.performance_analysis"
                class="bg-white border-l-4 border-purple-600 p-6 rounded-xl shadow-md mt-10">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700 mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a4 4 0 00-4-4H3m0 0a9 9 0 0118 0h-2a4 4 0 00-4 4v2M3 11l1.5-1.5M21 11l-1.5-1.5" />
                    </svg>
                    <h4 class="text-xl font-semibold text-purple-700">📈 Performance Metrics</h4>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center text-gray-800">
                    <!-- Control Average -->
                    <div>
                        <p class="text-sm text-gray-500">Control Average</p>
                        <p class="text-3xl font-bold">{{
                            currentReport.analysis.performance_analysis.calculated_metrics.control_average.toFixed(2) }}
                        </p>
                    </div>

                    <!-- Leads Agri Average -->
                    <div>
                        <p class="text-sm text-gray-500">Leads Agri Average</p>
                        <p class="text-3xl font-bold">{{
                            currentReport.analysis.performance_analysis.calculated_metrics.leads_average.toFixed(2) }}
                        </p>
                    </div>

                    <!-- Absolute Difference -->
                    <div>
                        <p class="text-sm text-gray-500">Absolute Difference</p>
                        <p class="text-3xl font-bold">
                            {{
                                currentReport.analysis.performance_analysis.calculated_metrics.absolute_difference.toFixed(2)
                            }}
                            <span class="text-base text-gray-500">
                                {{
                                    currentReport.analysis.performance_analysis.calculated_metrics.absolute_difference_unit
                                }}
                            </span>
                        </p>
                    </div>

                    <!-- Relative Improvement -->
                    <div>
                        <p class="text-sm text-gray-500">Relative Improvement</p>
                        <p :class="[
                            'text-3xl font-bold',
                            improvementValue > 0
                                ? 'text-green-600'
                                : improvementValue < 0
                                    ? 'text-red-600'
                                    : 'text-yellow-600'
                        ]">
                            {{ improvementValue.toFixed(2) }}%
                        </p>
                        <span :class="[
                            'inline-block text-xs px-2 py-0.5 rounded-full mt-1',
                            improvementValue > 0
                                ? 'bg-green-100 text-green-700'
                                : improvementValue < 0
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-yellow-100 text-yellow-700'
                        ]">
                            <template v-if="improvementValue > 0">↑ Improved</template>
                            <template v-else-if="improvementValue < 0">↓ Decreased</template>
                            <template v-else>→ No Change</template>
                        </span>
                    </div>

                    <!-- Significance -->
                    <div>
                        <p class="text-sm text-gray-500">Significance</p>
                        <p class="text-3xl font-bold text-purple-700 capitalize">
                            {{
                                currentReport.analysis.performance_analysis.statistical_assessment.improvement_significance
                            }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- ✅ Performance Analysis -->
            <div v-if="currentReport.analysis?.performance_analysis"
                class="bg-purple-50 border-l-4 border-purple-600 p-4 rounded-md">
                <h4 class="text-xl font-semibold text-purple-700 mb-2">
                    📈 Performance Analysis
                </h4>
                <p class="text-gray-700 mb-3 italic">
                    {{ currentReport.analysis.performance_analysis.scale_info }}
                </p>
                <div class="overflow-x-auto mb-4" v-if="currentReport.analysis?.performance_analysis?.raw_data">
                    <table class="min-w-full text-sm border border-gray-300">
                        <thead class="bg-purple-100 text-gray-700">
                            <tr>
                                <!-- First column header -->
                                <th class="border px-3 py-2">Time Period</th>

                                <!-- Dynamic headers for each treatment -->
                                <th v-for="(values, treatment) in currentReport.analysis.performance_analysis.raw_data"
                                    :key="treatment" class="border px-3 py-2 capitalize">
                                    <!-- Rename control -> Standard Practice -->
                                    {{
                                        treatment === "control"
                                            ? "Standard Practice"
                                            : treatment.replace(/_/g, " ")
                                    }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-center text-gray-800">
                            <!-- Create rows dynamically for each DAA -->
                            <tr v-for="(daaLabel, index) in Object.keys(
                                currentReport.analysis.performance_analysis.raw_data.control
                            )" :key="index">
                                <!-- DAA label -->
                                <td class="border px-3 py-2 font-semibold">{{ daaLabel }}</td>

                                <!-- Each treatment’s values -->
                                <td v-for="(values, treatment) in currentReport.analysis.performance_analysis.raw_data"
                                    :key="treatment" class="border px-3 py-2">
                                    {{ values[daaLabel] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- 🔬 Treatment Details -->
                <div v-if="currentReport.analysis?.treatment_comparison"
                    class="bg-white border border-purple-200 rounded-lg p-6 mb-4">
                    <h5 class="font-semibold text-purple-700 mb-2">🔬 Treatment Details</h5>
                    <hr class="border-t-2 border-gray-400 my-4" />
                    <div class="flex flex-col md:flex-row justify-between text-gray-800">
                        <!-- Left: Standard Practice -->
                        <div class="flex-1 pr-4">
                            <h6 class="text-lg font-semibold text-green-700 mb-2">
                                Standard Practice
                            </h6>
                            <ul class="space-y-1 text-sm">
                                <li><b>Product:</b> {{ currentReport.analysis.treatment_comparison.control.product
                                    }}</li>
                                <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.control.rate }}</li>
                                <li><b>Timing:</b> {{ currentReport.analysis.treatment_comparison.control.timing }}
                                </li>
                                <li><b>Method:</b> {{ currentReport.analysis.treatment_comparison.control.method }}
                                </li>
                            </ul>
                        </div>
                        <div class="hidden md:block w-[1px] bg-gray-300 mx-6"></div>
                        <!-- Right: Leads Agri Treatment -->
                        <div class="flex-1 pl-4">
                            <h6 class="text-lg font-semibold text-purple-700 mb-2">
                                Leads Agri Treatment
                            </h6>
                            <ul class="space-y-1 text-sm">
                                <li><b>Product:</b> {{
                                    currentReport.analysis.treatment_comparison.leads_agri.product }}</li>
                                <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.rate }}
                                </li>
                                <li><b>Timing:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.timing
                                    }}</li>
                                <li><b>Method:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.method
                                    }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Statistical Assessment -->
                <div class="bg-white border border-purple-200 rounded-lg p-4 mb-4">
                    <h5 class="font-semibold text-purple-700 mb-2">
                        📏 Statistical Assessment
                    </h5>
                    <p>
                        <b>Significance:</b>
                        {{
                            currentReport.analysis.performance_analysis.statistical_assessment
                                .improvement_significance
                        }}
                    </p>
                    <p>
                        <b>Basis:</b>
                        {{
                            currentReport.analysis.performance_analysis.statistical_assessment
                                .significance_basis
                        }}
                    </p>
                    <p>
                        <b>Consistency:</b>
                        {{
                            currentReport.analysis.performance_analysis.statistical_assessment
                                .performance_consistency
                        }}
                    </p>
                    <p>
                        <b>Confidence Level:</b>
                        {{
                            currentReport.analysis.performance_analysis.statistical_assessment
                                .confidence_level
                        }}
                    </p>
                    <p class="italic text-gray-600">
                        {{
                            currentReport.analysis.performance_analysis.statistical_assessment
                                .notes
                        }}
                    </p>
                </div>

                <!-- Trend Summary -->
                <div class="bg-white border border-purple-200 rounded-lg p-4">
                    <h5 class="font-semibold text-purple-700 mb-2">
                        📈 Trend Analysis
                    </h5>
                    <ul class="list-disc ml-6 text-gray-700">
                        <li>
                            <b>Control Trend:</b>
                            {{
                                currentReport.analysis.performance_analysis.trend_analysis
                                    .control_trend
                            }}
                        </li>
                        <li>
                            <b>Leads Agri Trend:</b>
                            {{
                                currentReport.analysis.performance_analysis.trend_analysis
                                    .leads_trend
                            }}
                        </li>
                        <li>
                            <b>Early Performance:</b>
                            {{
                                currentReport.analysis.performance_analysis.trend_analysis
                                    .early_performance
                            }}
                        </li>
                        <li>
                            <b>Late Performance:</b>
                            {{
                                currentReport.analysis.performance_analysis.trend_analysis
                                    .late_performance
                            }}
                        </li>
                        <li>
                            <b>Observation:</b>
                            {{
                                currentReport.analysis.performance_analysis.trend_analysis
                                    .key_observation
                            }}
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Charts + Performance + Opportunities + Risks -->
            <div v-if="chartMap[currentReport.form_id]?.length" class="mt-10 space-y-10">
                <!-- Charts -->
                <h4 class="text-xl font-semibold text-black border-b">
                    📊 Data Visualizations
                </h4>

                <div class="grid gap-8 sm:grid-cols-1 lg:grid-cols-2 items-stretch content-start">
                    <div v-for="(chart, idx) in chartMap[currentReport.form_id]" :key="idx"
                        class="chart-card bg-white rounded-lg shadow p-4">
                        <h5 class="text-lg font-semibold mb-2 text-gray-800">
                            {{ chart.title }}
                        </h5>
                        <component :is="chart.component" :data="chart.chart_data" :options="chart.chart_options" />
                        <p v-if="chart.description" class="text-gray-600 mb-3 text-sm italic mt-4 px-4">
                            {{ chart.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Executive Summary -->
            <div v-if="currentReport.analysis?.executive_summary"
                class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md h-full">
                <h4 class="text-xl font-semibold text-blue-700 mb-2">
                    🧾 Executive Summary
                </h4>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ currentReport.analysis.executive_summary }}
                </p>
            </div>

            <!-- Opportunities + Risks below -->
            <div v-if="
                (currentReport.analysis?.opportunities?.length ||
                    currentReport.analysis?.risk_factors?.length)
            " class="grid sm:grid-cols-1 lg:grid-cols-2 gap-6">
                <div v-if="currentReport.analysis?.opportunities?.length"
                    class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                    <h4 class="text-xl font-semibold text-green-700 mb-2">
                        💡 Opportunities
                    </h4>
                    <ul class="list-disc ml-6 space-y-1 text-gray-700">
                        <li v-for="(op, i) in currentReport.analysis.opportunities" :key="i">
                            <b>{{ op.opportunity }}</b> — {{ op.data_basis }}
                            (Potential: <b>{{ op.potential }}</b>)
                        </li>
                    </ul>
                </div>
                <div v-if="currentReport.analysis?.risk_factors?.length"
                    class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <h4 class="text-xl font-semibold text-red-700 mb-2">
                        ⚠️ Risks / Limitations
                    </h4>
                    <ul class="list-disc ml-6 space-y-1 text-gray-700">
                        <li v-for="(risk, i) in currentReport.analysis.risk_factors" :key="i">
                            <b>{{ risk.risk }}</b> — {{ risk.data_basis }} (Severity:
                            <b>{{ risk.severity }}</b>)
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Recommendations -->
            <div v-if="currentReport.analysis?.recommendations?.length"
                class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-md">
                <h4 class="text-xl font-semibold text-yellow-700 mb-2">
                    🧠 Recommendations
                </h4>
                <div v-for="(rec, i) in currentReport.analysis.recommendations" :key="i" class="mb-3">
                    <p class="text-gray-800">
                        <b>{{ rec.priority.toUpperCase() }} Priority:</b>
                        {{ rec.recommendation }}
                    </p>
                    <p class="text-gray-600 text-sm">
                        <b>Data Basis:</b> {{ rec.data_basis }}<br />
                        <b>Expected Impact:</b> {{ rec.expected_impact }}
                    </p>
                </div>
            </div>
        </div>
        <!-- Loading/Error -->
        <div v-else-if="!currentReport" class="text-center text-black mt-24">
            <p v-if="isLoading">Loading data...</p>
            <p v-else-if="error">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, watchEffect, computed, watch } from "vue";
import {
    Line,
    Bar,
    Pie,
    Radar,
    PolarArea,
    Scatter,
    Bubble,
} from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    ArcElement,
    CategoryScale,
    LinearScale,
    PointElement,
    RadialLinearScale,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    ArcElement,
    CategoryScale,
    LinearScale,
    PointElement,
    RadialLinearScale
);

const props = defineProps({
  analysisData: {
    type: Object,
    default: () => ({})
  }
});

const reports = ref([]);
const selectedCooperator = ref("");
const isLoading = ref(true);
const error = ref(null);
const chartMap = ref({});
const currentReport = ref(null);
const isExporting = ref(false);

watchEffect(() => {
  console.log("🔍 AI-AgentContext received analysisData:", props.analysisData);
  console.log("🔍 AnalysisData keys:", props.analysisData ? Object.keys(props.analysisData) : "null/undefined");
  
  if (!props.analysisData || Object.keys(props.analysisData).length === 0) {
    console.log("⚠️ AnalysisData is empty, returning early");
    return;
  }

  try {
    const rep = props.analysisData;
    console.log("📋 Processing report with form_id:", rep.form_id);

    // 🧩 Build chart map for the received report
    const charts = rep.graph_suggestions?.suggested_charts || [];
    console.log("📊 Charts found:", charts.length);
    chartMap.value[rep.form_id] = charts.map((chart) => {
      let component;
      const type = chart.chart_type?.toLowerCase() || "";
      if (type.includes("line")) component = Line;
      else if (type.includes("horizontal_bar")) component = Bar;
      else if (type.includes("bar")) component = Bar;
      else if (type.includes("pie")) component = Pie;
      else if (type.includes("doughnut")) component = Pie;
      else if (type.includes("radar")) component = Radar;
      else if (type.includes("polar")) component = PolarArea;
      else if (type.includes("scatter")) component = Scatter;
      else if (type.includes("bubble")) component = Bubble;
      else component = Bar;

      let options = chart.chart_options || {};
      if (type.includes("horizontal_bar")) {
        options = { ...options, indexAxis: "y" };
      }

      return {
        title: chart.title,
        description: chart.description,
        component,
        chart_data: chart.chart_data,
        chart_options: options,
      };
    });

    // ✅ Update state dynamically
    currentReport.value = rep;
    selectedCooperator.value = rep.analysis?.basic_info?.cooperator || "";
    isLoading.value = false;
    error.value = null;
    console.log("✅ Current report set:", currentReport.value);
    console.log("✅ Report has analysis:", !!currentReport.value?.analysis);
    console.log("✅ Report has graph_suggestions:", !!currentReport.value?.graph_suggestions);
  } catch (err) {
    error.value = err.message;
    isLoading.value = false;
  }
});


const uniqueCooperators = computed(() => {
    const coops = reports.value
        .map((r) => r.analysis?.basic_info?.cooperator)
        .filter(Boolean);
    return [...new Set(coops)];
});

const improvementValue = computed(() => {
    return (
        currentReport.value?.analysis?.performance_analysis?.calculated_metrics
            ?.relative_improvement_percent || 0
    );
});
watch(selectedCooperator, (newCoop) => {
    if (!newCoop) {
        currentReport.value = null;
        localStorage.removeItem("selectedCooperator");
        return;
    }

    localStorage.setItem("selectedCooperator", newCoop);
    const match = reports.value.find(
        (r) => r.analysis?.basic_info?.cooperator === newCoop
    );
    currentReport.value = match || null;
});

const exportToPDF = async () => {
    if (!currentReport.value) {
        alert("No report data available to export.");
        return;
    }

    isExporting.value = true;
    try {
        const chartImages = [];
        const chartsData = chartMap.value[currentReport.value.form_id] || [];
        const canvases = document.querySelectorAll("canvas");

        const targetWidth = 1200;
        const targetHeight = 700;
        const exportScale = 2.5;

        canvases.forEach((canvas, index) => {
            const tmpCanvas = document.createElement("canvas");
            tmpCanvas.width = targetWidth * exportScale;
            tmpCanvas.height = targetHeight * exportScale;
            const ctx = tmpCanvas.getContext("2d");
            ctx.fillStyle = "#fff";
            ctx.fillRect(0, 0, tmpCanvas.width, tmpCanvas.height);
            ctx.drawImage(canvas, 0, 0, tmpCanvas.width, tmpCanvas.height);

            chartImages.push({
                title: chartsData[index]?.title || `Chart ${index + 1}`,
                description: chartsData[index]?.description || "",
                data: tmpCanvas.toDataURL("image/png"),
            });
        });

        const payload = { report: currentReport.value, charts: chartImages };
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

        const response = await fetch("/export-report-pdf", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
                "Accept": "application/pdf",
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) throw new Error("Failed to export PDF");
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        window.open(url, "_blank");
        setTimeout(() => URL.revokeObjectURL(url), 1000);
    } catch (error) {
        console.error(error);
        alert("Error exporting PDF. Please try again.");
    } finally {
        isExporting.value = false;
    }
};

const isValidReport = computed(() => !!currentReport.value);

const handleExportClick = () => {
    if (!isValidReport.value) {
        alert("⚠️ Please select a valid report before exporting to PDF.");
        return;
    }
    exportToPDF();
};

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