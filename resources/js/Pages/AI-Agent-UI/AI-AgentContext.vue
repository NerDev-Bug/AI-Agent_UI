<template>
    <div class="min-h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-black">Agent Products Demo Trials</h2>
        </div>

        <!-- Select and Export -->
        <div class="flex items-center gap-6 mb-8 px-2">
            <div class="flex-2">
                <br>
                <!-- ✅ Export PDF button - only show after save (for Quadrant memory storage) -->
                <button v-if="currentReport && isSaved" @click="handleExportClick" :disabled="isExporting"
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

            <div class="ml-auto" v-if="uniqueApplicants.length > 1">
                <label class="block text-sm text-black mb-1">Select Applicant:</label>
                <select v-model="applicant" class="p-2 rounded-md w-72" :disabled="!currentReport">
                    <option value="">-- Choose Applicant --</option>
                    <option v-for="app in uniqueApplicants" :key="app" :value="app">
                        {{ app }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Report Display -->
        <div v-if="currentReport && applicant" class="p-2 space-y-8">
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
                    <li><b>Applicant:</b> {{ currentReport.analysis.basic_info.applicant }}</li>
                    <li><b>Application Date:</b> {{ currentReport.analysis.basic_info.application_date }}</li>
                    <li><b>Cooperator:</b> {{ currentReport.analysis.basic_info.cooperator }}</li>
                    <li><b>Product:</b> {{ currentReport.analysis.basic_info.product }}</li>
                    <li><b>Location:</b> {{ currentReport.analysis.basic_info.location }}</li>
                    <li><b>Crop:</b> {{ currentReport.analysis.basic_info.crop }}</li>
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

            <!-- ✅ Performance Analysis + Treatment Details side-by-side -->
            <div v-if="currentReport.analysis?.performance_analysis"
                class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">

                <!-- Left: Performance Analysis -->
                <div class="bg-purple-50 border-l-4 border-purple-600 p-4 rounded-md">
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
                                    <th class="border px-3 py-2">Time Period</th>
                                    <th v-for="(values, treatment) in currentReport.analysis.performance_analysis.raw_data"
                                        :key="treatment" class="border px-3 py-2 capitalize">
                                        {{ treatment === 'control' ? 'Standard Practice' : treatment.replace(/_/g, ' ')
                                        }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center text-gray-800">
                                <tr v-for="(daaLabel, index) in Object.keys(currentReport.analysis.performance_analysis.raw_data.control)"
                                    :key="index">
                                    <td class="border px-3 py-2 font-semibold">{{ daaLabel }}</td>
                                    <td v-for="(values, treatment) in currentReport.analysis.performance_analysis.raw_data"
                                        :key="treatment" class="border px-3 py-2">
                                        {{ values[daaLabel] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Treatment Details -->
                <div v-if="currentReport.analysis?.treatment_comparison"
                    class="bg-white border border-purple-200 rounded-lg p-6 mb-4">
                    <h5 class="font-semibold text-purple-700 mb-2">🔬 Treatment Details</h5>
                    <hr class="border-t-2 border-gray-400 my-4" />
                    <div class="flex flex-col md:flex-row justify-between text-gray-800">
                        <div class="flex-1 pr-4">
                            <h6 class="text-lg font-semibold text-green-700 mb-2">Standard Practice</h6>
                            <ul class="space-y-1 text-sm">
                                <li><b>Product:</b> {{ currentReport.analysis.treatment_comparison.control.product }}
                                </li>
                                <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.control.rate }}</li>
                                <li><b>Timing:</b> {{ currentReport.analysis.treatment_comparison.control.timing }}</li>
                                <li><b>Method:</b> {{ currentReport.analysis.treatment_comparison.control.method }}</li>
                            </ul>
                        </div>
                        <div class="hidden md:block w-[1px] bg-gray-300 mx-6"></div>
                        <div class="flex-1 pl-4">
                            <h6 class="text-lg font-semibold text-purple-700 mb-2">Leads Agri Treatment</h6>
                            <ul class="space-y-1 text-sm">
                                <li><b>Product:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.product }}
                                </li>
                                <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.rate }}</li>
                                <li><b>Timing:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.timing }}
                                </li>
                                <li><b>Method:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.method }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p>{{ currentReport.analysis.treatment_comparison.protocol_assessment }}</p>
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

            <!-- ✅ Separate Statistical Assessment and Trend Summary below -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <div class="bg-white border border-purple-200 rounded-lg p-4 mb-4">
                    <h5 class="font-semibold text-purple-700 mb-2">📏 Statistical Assessment</h5>
                    <p><b>Significance:</b>
                        {{ currentReport.analysis.performance_analysis.statistical_assessment.improvement_significance
                        }}</p>
                    <p><b>Basis:</b>
                        {{ currentReport.analysis.performance_analysis.statistical_assessment.significance_basis }}</p>
                    <p><b>Consistency:</b>
                        {{ currentReport.analysis.performance_analysis.statistical_assessment.performance_consistency }}
                    </p>
                    <p><b>Confidence Level:</b>
                        {{ currentReport.analysis.performance_analysis.statistical_assessment.confidence_level }}</p>
                    <p class="italic text-gray-600">
                        {{ currentReport.analysis.performance_analysis.statistical_assessment.notes }}
                    </p>
                </div>

                <div class="bg-white border border-purple-200 rounded-lg p-4">
                    <h5 class="font-semibold text-purple-700 mb-2">📈 Trend Analysis</h5>
                    <ul class="list-disc ml-6 text-gray-700">
                        <li><b>Control Trend:</b> {{
                            currentReport.analysis.performance_analysis.trend_analysis.control_trend }}
                        </li>
                        <li><b>Leads Agri Trend:</b> {{
                            currentReport.analysis.performance_analysis.trend_analysis.leads_trend }}
                        </li>
                        <li><b>Early Performance:</b> {{
                            currentReport.analysis.performance_analysis.trend_analysis.early_performance }}</li>
                        <li><b>Late Performance:</b> {{
                            currentReport.analysis.performance_analysis.trend_analysis.late_performance
                            }}</li>
                        <li><b>Observation:</b> {{
                            currentReport.analysis.performance_analysis.trend_analysis.key_observation }}
                        </li>
                    </ul>
                </div>
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
        </div>
        <!-- Loading/Error -->
        <!-- <div v-else-if="!currentReport" class="text-center text-black mt-24">
            <p v-if="isLoading">Loading data...</p>
            <p v-else-if="error">{{ error }}</p>
        </div> -->
        <!-- Loading/Error/Empty Placeholder -->
        <div v-else-if="!currentReport"
            class="flex flex-col items-center justify-center h-[440px] mt-10 bg-[#e6e9f7] rounded-lg">
            <div class="relative flex flex-col items-center justify-center">
                <div class="bg-white w-32 h-32 rounded-full flex items-center justify-center shadow-md">
                    <span class="text-[#1f3b70] text-7xl font-semibold">?</span>
                </div>

                <!-- Text Section -->
                <div class="text-center mt-8">
                    <h2 class="text-2xl font-semibold text-[#1f3b70]">No Data Found</h2>
                    <p class="text-gray-600 text-sm mt-2 max-w-md mx-auto">
                        Upload a file and click the Analyze Demo Form button to show the analyzed result of your
                        uploaded file.
                    </p>
                </div>
            </div>
        </div>

        <div>
            <LoadingOverlay :visible="isExporting" />
        </div>

        <!-- ✅ SweetAlert-style Modal -->
        <transition name="fade">
            <div v-if="alertVisible"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]">
                <div class="bg-white rounded-2xl shadow-lg w-[360px] p-6 text-center border-4" :class="{
                    'border-green-600': alertType === 'success',
                    'border-red-600': alertType === 'error',
                    'border-yellow-500': alertType === 'warning'
                }">
                    <div class="text-5xl mb-3" :class="{
                        'text-green-600': alertType === 'success',
                        'text-red-600': alertType === 'error',
                        'text-yellow-500': alertType === 'warning'
                    }">
                        {{ alertIcon }}
                    </div>
                    <h2 class="text-2xl font-bold mb-2">{{ alertTitle }}</h2>
                    <p class="text-gray-600 mb-5">{{ alertMessage }}</p>
                    <div class="flex justify-center gap-3">
                        <button v-if="alertType === 'warning'" @click="confirmAction"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Yes</button>
                        <button @click="closeAlert"
                            class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                            {{ alertType === 'warning' ? 'Cancel' : 'OK' }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import LoadingOverlay from "../Components/LoadingOverlay.vue";
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
    },
    isSaved: {
        type: Boolean,
        default: false
    }
});

const reports = ref([]);
const applicant = ref("");
const isLoading = ref(true);
const error = ref(null);
const chartMap = ref({});
const currentReport = ref(null);
const isExporting = ref(false);

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
function confirmAction() {
    if (confirmCallback) confirmCallback();
    closeAlert();
}

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
        applicant.value = rep.analysis?.basic_info?.applicant || "";
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


const uniqueApplicants = computed(() => {
    const apps = reports.value
        .map((r) => r.analysis?.basic_info?.applicant)
        .filter(Boolean);
    return [...new Set(apps)];
});

// Automatically select the first applicant when there's only one
watch(uniqueApplicants, (apps) => {
    if (apps.length === 1) {
        applicant.value = apps[0];
        const match = reports.value.find(
            (r) => r.analysis?.basic_info?.applicant === apps[0]
        );
        currentReport.value = match || null;
    }
});

const improvementValue = computed(() => {
    return (
        currentReport.value?.analysis?.performance_analysis?.calculated_metrics
            ?.relative_improvement_percent || 0
    );
});
watch(applicant, (newApplicant) => {
    if (!newApplicant) {
        currentReport.value = null;
        localStorage.removeItem("applicant");
        return;
    }

    localStorage.setItem("applicant", newApplicant);
    const match = reports.value.find(
        (r) => r.analysis?.basic_info?.applicant === newApplicant
    );
    currentReport.value = match || null;
});

const exportToPDF = async () => {
    if (!currentReport.value) {
        showAlert("error", "Export Failed", "No report data available to export.");
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

        if (!response.ok) {
            // Try to get error message from response
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                const errorData = await response.json();
                throw new Error(errorData.error || errorData.message || "Failed to export PDF");
            }
            throw new Error(`Failed to export PDF: ${response.status} ${response.statusText}`);
        }

        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = `Report-${new Date().toISOString().slice(0, 10)}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        setTimeout(() => URL.revokeObjectURL(url), 1000);
        showAlert("success", "Export Successful", "Analyze Report was successfully exported to PDF!");
    } catch (error) {
        console.error("PDF Export Error:", error);
        showAlert("error", "Error exporting PDF: " + (error.message || "Please try again."));
    } finally {
        isExporting.value = false;
    }
};

const isValidReport = computed(() => !!currentReport.value);

const handleExportClick = () => {
    if (!isValidReport.value) {
        showAlert("warning", "⚠️ Please select a valid report before exporting to PDF.");
        return;
    }
    exportToPDF();
};

watch(isExporting, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden'; // disable scroll
    } else {
        document.body.style.overflow = ''; // restore scroll
    }
});


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