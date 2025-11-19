<template>
    <div class="min-h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-black">
                Agent Products Demo Trials Result:
            </h2>
        </div>

        <!-- Select and Export -->
        <div class="flex items-center gap-6 mb-8 px-2">
            <div class="flex-2">
                <br />
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
        <div v-if="currentReport && applicant" class="p-2">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                {{ currentReport.form_type }}
            </h3>

            <!-- Basic Info -->
            <div class="flex gap-4 w-full">
                <div v-if="currentReport.analysis?.basic_info"
                    class="bg-white border-l-4 p-8 rounded-xl h-full w-[1400px] animate-slideInLeft">
                    <h4 class="text-2xl font-semibold text-black mb-6 md:mb-8">
                        Basic Information
                    </h4>
                    <ul
                        class="text-sm md:text-lg grid grid-cols-2 gap-x-8 text-gray-700 before:absolute before:inset-0 before:animate-typewriter">
                        <li>
                            <b>Applicant:</b>
                            {{ currentReport.analysis.basic_info.applicant }}
                        </li>
                        <li>
                            <b>Application Date:</b>
                            {{
                                currentReport.analysis.basic_info
                                    .application_date
                            }}
                        </li>
                        <li>
                            <b>Cooperator:</b>
                            {{ currentReport.analysis.basic_info.cooperator }}
                        </li>
                        <li>
                            <b>Product:</b>
                            {{ currentReport.analysis.basic_info.product }}
                        </li>
                        <li>
                            <b>Location:</b>
                            {{ currentReport.analysis.basic_info.location }}
                        </li>
                        <li>
                            <b>Crop:</b>
                            {{ currentReport.analysis.basic_info.crop }}
                        </li>
                        <li>
                            <b>Plot Size:</b>
                            {{ currentReport.analysis.basic_info.plot_size }}
                        </li>
                        <li>
                            <b>Planting Date:</b>
                            {{
                                currentReport.analysis.basic_info.planting_date
                            }}
                        </li>
                    </ul>
                </div>
                <!-- Control + Leads Agri Metrics (Right Side of Basic Info) -->
                <div class="bg-white p-6 rounded-xl flex flex-col w-[900px]">
                    <div class="flex items-center mb-4">
                        <h4 class="text-2xl font-semibold text-black">
                            Performance Metrics
                        </h4>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Control Average -->
                        <div
                            class="bg-[linear-gradient(#1E3E8B,#346BF1)] text-white p-10 rounded-3xl shadow flex flex-col justify-center items-center h-44">
                            <p class="text-5xl font-bold mb-4">
                                {{
                                    currentReport.analysis.performance_analysis.calculated_metrics.control_average.toFixed(
                                        2
                                    )
                                }}
                            </p>
                            <p class="text-lg opacity-90">Control Average</p>
                        </div>

                        <!-- Leads Agri Average -->
                        <div
                            class="bg-[linear-gradient(#00853F,#4CAF50)] text-white p-10 rounded-3xl shadow flex flex-col justify-center items-center h-44">
                            <p class="text-5xl font-bold mb-4">
                                {{
                                    currentReport.analysis.performance_analysis.calculated_metrics.leads_average.toFixed(
                                        2
                                    )
                                }}
                            </p>
                            <p class="text-lg opacity-90">Leads Agri Average</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics Section -->
            <div v-if="currentReport.analysis?.performance_analysis" class="p-6 w-full">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 w-full">
                    <!-- Season -->
                    <div
                        class="bg-white border border-gray-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center">
                        <!-- Season Badge (top right) -->
                        <div :class="[
                            'absolute top-4 right-4 text-white text-sm font-semibold px-4 py-1 rounded-full capitalize',
                            currentReport.analysis.performance_analysis.statistical_assessment.season === 'Dry'
                                ? 'bg-yellow-400'
                                : 'bg-sky-400'
                        ]">
                            {{
                                currentReport.analysis.performance_analysis
                                    .statistical_assessment.season
                            }}
                        </div>
                        <!-- Season Icon -->
                        <div class="w-20 h-20 mb-3">
                            <img v-if="currentReport.analysis.performance_analysis.statistical_assessment.season === 'Dry'"
                                src="/images/sun.png" alt="Dry season" class="w-full h-full object-contain" />

                            <img v-else-if="currentReport.analysis.performance_analysis.statistical_assessment.season === 'Wet'"
                                src="/images/cloud_with_rain.png" alt="Wet season"
                                class="w-full h-full object-contain" />

                            <!-- Optional fallback for other values -->
                            <img v-else src="/images/sun.png" alt="Season" class="w-full h-full object-contain" />
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Season</p>
                    </div>

                    <!-- Relative Improvement -->
                    <div
                        class="bg-white border border-gray-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center relative">

                        <!-- Status badge -->
                        <span v-if="improvementValue > 0"
                            class="absolute top-4 left-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                            <span>↑</span>
                            <span>Improved</span>
                        </span>

                        <span v-else-if="improvementValue < 0"
                            class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                            <span>↓</span>
                            <span>Decreased</span>
                        </span>

                        <span v-else
                            class="absolute top-4 left-4 bg-gray-400 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                            <span>→</span>
                            <span>No Change</span>
                        </span>
                        <!-- Main Value -->
                        <p class="text-3xl font-semibold text-black mt-6">
                            {{ improvementValue.toFixed(2) }}%
                        </p>
                        <!-- Label -->
                        <p class="text-sm text-gray-500 mt-2">Relative Improvement</p>
                    </div>

                    <!-- Significance -->
                    <div
                        class="bg-white border border-gray-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center">
                        <p class="text-3xl font-semibold text-black capitalize">
                            {{
                                currentReport.analysis.performance_analysis
                                    .statistical_assessment
                                    .improvement_significance
                            }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">Significance</p>
                    </div>

                    <!-- Absolute Difference -->
                    <div
                        class="bg-white border border-gray-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center">
                        <p class="text-3xl font-semibold text-black">
                            {{
                                currentReport.analysis.performance_analysis.calculated_metrics.absolute_difference.toFixed(2)
                            }}
                            <span class="text-base text-gray-700">
                                {{
                                    currentReport.analysis.performance_analysis
                                        .calculated_metrics
                                        .absolute_difference_unit
                                }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-500 mt-2">Absolute Difference</p>
                    </div>
                </div>
            </div>

            <!-- 📊 Responsive Charts + Treatment Details -->
            <div v-if="currentReport.analysis?.performance_analysis || chartMap[currentReport.form_id]?.length"
                class="flex flex-col gap-6 mt-10 w-full">

                <template v-if="chartMap[currentReport.form_id]">
                    <div>
                        <!-- Count charts -->
                        <div class="hidden">
                            {{ chartCount = chartMap[currentReport.form_id]?.length || 0 }}
                        </div>
                        <!--
                            ODD chart count (1, 3, 5, 7) → grid (charts + treatment inside grid)
                            EVEN chart count (2, 4, 6) → grid for charts ONLY + treatment BELOW grid
                        -->
                        <div :class="[
                            'grid gap-6 w-full',
                            chartCount === 1 ? 'md:grid-cols-2' : // 1 chart: 2 cols (Chart 1 | Treatment Details)
                                chartCount === 2 ? 'md:grid-cols-2' :
                                    chartCount === 3 ? 'md:grid-cols-2' : // 3 charts: 2 cols (2x2 grid with Treatment Details)
                                        chartCount === 5 ? 'md:grid-cols-2 lg:grid-cols-3' : // 5 charts: 3 cols
                                            chartCount === 7 ? 'md:grid-cols-2 lg:grid-cols-3' : // 7 charts: 3 cols
                                                chartCount >= 4 && chartCount % 2 === 0 ? 'md:grid-cols-2 lg:grid-cols-3' : // Even 4, 6, 8+
                                                    chartCount >= 4 ? 'md:grid-cols-2 lg:grid-cols-3' : 'md:grid-cols-1'
                        ]">
                            <!-- Render CHARTS -->
                            <div v-for="(chart, idx) in chartMap[currentReport.form_id]" :key="idx"
                                class="chart-card bg-white rounded-lg shadow p-4">
                                <h5 class="text-2xl font-semibold mb-6 text-gray-800 px-2">
                                    {{ chart.title }}
                                </h5>

                                <component :is="chart.component" :data="chart.chart_data"
                                    :options="chart.chart_options" />

                                <p v-if="chart.description" class="text-gray-600 mb-3 text-sm italic mt-4 px-4">
                                    {{ chart.description }}
                                </p>
                            </div>

                            <!-- Render Treatment Details INSIDE GRID only if chartCount is ODD (1, 3, 5, 7) -->
                            <div v-if="chartCount % 2 === 1 && currentReport.analysis?.treatment_comparison" :class="[
                                'chart-card bg-white rounded-lg shadow p-4',
                                chartCount === 1 ? '' : // 1 chart: Normal grid item (side by side with chart)
                                    chartCount === 3 ? '' : // 3 charts: Normal grid item (no span, creates 2x2 grid)
                                        chartCount === 5 ? 'lg:col-span-1' : // 5 charts: Normal grid item (1 cell in 3-col grid)
                                            chartCount === 7 ? 'lg:col-span-1' : // 7 charts: Normal grid item (1 cell in 3-col grid)
                                                '' // Default: normal grid item (no span)
                            ]">
                                <h5 class="text-2xl font-semibold mb-6 text-gray-800 px-2">
                                    Treatment Details
                                </h5>
                                <hr class="border-t-2 border-gray-400 my-4" />

                                <div class="flex flex-col md:flex-row justify-between text-gray-800">
                                    <div class="flex-1 pr-4">
                                        <h6 class="text-2xl font-semibold text-blue-700 mb-3">
                                            Standard Practice
                                        </h6>
                                        <ul class="space-y-1 text-lg">
                                            <li><b>Product:</b> {{
                                                currentReport.analysis.treatment_comparison.control.product }}</li>
                                            <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.control.rate
                                                }}</li>
                                            <li><b>Timing:</b> {{
                                                currentReport.analysis.treatment_comparison.control.timing }}</li>
                                            <li><b>Method:</b> {{
                                                currentReport.analysis.treatment_comparison.control.method }}</li>
                                        </ul>
                                    </div>

                                    <div class="hidden md:block w-[1px] bg-gray-300 mx-6"></div>

                                    <div class="flex-1 pl-4">
                                        <h6 class="text-2xl font-semibold text-green-700 mb-3">
                                            Leads Agri Treatment
                                        </h6>
                                        <ul class="space-y-1 text-lg">
                                            <li><b>Product:</b> {{
                                                currentReport.analysis.treatment_comparison.leads_agri.product }}</li>
                                            <li><b>Rate:</b> {{
                                                currentReport.analysis.treatment_comparison.leads_agri.rate }}</li>
                                            <li><b>Timing:</b> {{
                                                currentReport.analysis.treatment_comparison.leads_agri.timing }}</li>
                                            <li><b>Method:</b> {{
                                                currentReport.analysis.treatment_comparison.leads_agri.method }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <p class="text-gray-600 mb-3 text-sm italic mt-4 px-4">
                                    {{ currentReport.analysis.treatment_comparison.protocol_assessment }}
                                </p>
                            </div>
                        </div>

                        <!-- Treatment Details BELOW GRID only if chartCount is EVEN -->
                        <div v-if="chartCount % 2 === 0 && currentReport.analysis?.treatment_comparison"
                            class="bg-white rounded-lg shadow p-4 mt-6">
                            <h5 class="text-2xl font-semibold mb-6 text-gray-800 px-2">
                                Treatment Details
                            </h5>
                            <hr class="border-t-2 border-gray-400 my-4" />

                            <div class="flex flex-col md:flex-row justify-between text-gray-800">
                                <div class="flex-1 pr-4">
                                    <h6 class="text-2xl font-semibold text-blue-700 mb-3">
                                        Standard Practice
                                    </h6>
                                    <ul class="space-y-1 text-lg">
                                        <li><b>Product:</b> {{
                                            currentReport.analysis.treatment_comparison.control.product }}</li>
                                        <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.control.rate }}
                                        </li>
                                        <li><b>Timing:</b> {{ currentReport.analysis.treatment_comparison.control.timing
                                            }}</li>
                                        <li><b>Method:</b> {{ currentReport.analysis.treatment_comparison.control.method
                                            }}</li>
                                    </ul>
                                </div>

                                <div class="hidden md:block w-[1px] bg-gray-300 mx-6"></div>

                                <div class="flex-1 pl-4">
                                    <h6 class="text-2xl font-semibold text-green-700 mb-3">
                                        Leads Agri Treatment
                                    </h6>
                                    <ul class="space-y-1 text-lg">
                                        <li><b>Product:</b> {{
                                            currentReport.analysis.treatment_comparison.leads_agri.product }}</li>
                                        <li><b>Rate:</b> {{ currentReport.analysis.treatment_comparison.leads_agri.rate
                                            }}</li>
                                        <li><b>Timing:</b> {{
                                            currentReport.analysis.treatment_comparison.leads_agri.timing }}</li>
                                        <li><b>Method:</b> {{
                                            currentReport.analysis.treatment_comparison.leads_agri.method }}</li>
                                    </ul>
                                </div>
                            </div>

                            <p class="text-gray-600 mb-3 text-lg italic mt-4 px-4">
                                {{ currentReport.analysis.treatment_comparison.protocol_assessment }}
                            </p>
                        </div>
                    </div>
                </template>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[840px_390px] gap-6 mt-6">
                <!-- World Map Card (No Data State) -->
                <div
                    class="bg-white p-8 rounded-xl shadow-lg flex flex-col items-center justify-center h-full min-h-[300px] w-[840px]">
                    <i class="fa-solid fa-earth-americas text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg font-medium">No data found</p>
                </div>

                <!-- Key Findings & Strategic Insights -->
                <div class="bg-white p-8 rounded-xl shadow-lg w-[390px]">
                    <h2 class="text-xl font-semibold mb-4">Key Findings & Strategic Insights</h2>

                    <!-- Opportunities -->
                    <div class="insight-item bg-gray-100" @click="showOpportunitiesModal = true">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">🎯</div>
                            <div>
                                <h4 class="text-lg font-semibold">Opportunities</h4>
                                <p class="text-gray-500 text-sm insight-sub">
                                    {{ currentReport.analysis.opportunities.length }} available
                                </p>
                            </div>
                        </div>

                        <button class="see-more bg-yellow-400 text-white text-xs px-3 py-1 rounded-full">
                            See more
                        </button>
                    </div>

                    <!-- Risks & Limitations -->
                    <div class="insight-item bg-gray-100" @click="showRiskLimitationsModal = true">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">⚠️</div>
                            <div>
                                <h4 class="text-lg font-semibold">Risks & Limitations</h4>
                                <p class="text-gray-500 text-sm insight-sub">
                                    {{ currentReport.analysis.risk_factors.length }} identified
                                </p>
                            </div>
                        </div>

                        <button class="see-more bg-yellow-400 text-white text-xs px-3 py-1 rounded-full">
                            See more
                        </button>
                    </div>

                    <!-- Executive Summary -->
                    <div class="insight-item bg-gray-100" @click="showExecutiveSummaryModal = true">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">📊</div>
                            <div>
                                <h4 class="text-lg font-semibold">Executive Summary</h4>
                                <p class="text-gray-500 text-sm insight-sub">Overview available</p>
                            </div>
                        </div>

                        <button class="see-more bg-yellow-400 text-white text-xs px-3 py-1 rounded-full">
                            See more
                        </button>
                    </div>

                    <!-- Recommendations -->
                    <div class="insight-item bg-gray-100" @click="showRecommendationsModal = true">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl">💡</div>
                            <div>
                                <h4 class="text-lg font-semibold">Recommendations</h4>
                                <p class="text-gray-500 text-sm insight-sub">
                                    {{ currentReport.analysis.recommendations.length }} provided
                                </p>
                            </div>
                        </div>

                        <button class="see-more bg-yellow-400 text-white text-xs px-3 py-1 rounded-full">
                            See more
                        </button>
                    </div>
                </div>
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
                    <h2 class="text-2xl font-semibold text-[#1f3b70]">
                        No Data Found
                    </h2>
                    <p class="text-gray-600 text-sm mt-2 max-w-md mx-auto">
                        Upload a file and click the Analyze Demo Form button to
                        show the analyzed result of your uploaded file.
                    </p>
                </div>
            </div>
        </div>

        <div>
            <LoadingOverlay :visible="isExporting" />
        </div>

        <!-- weetAlert-style Modal -->
        <transition name="fade">
            <div v-if="alertVisible"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]">
                <div class="bg-white rounded-2xl shadow-lg w-[360px] p-6 text-center border-4" :class="{
                    'border-green-600': alertType === 'success',
                    'border-red-600': alertType === 'error',
                    'border-yellow-500': alertType === 'warning',
                }">
                    <div class="text-5xl mb-3" :class="{
                        'text-green-600': alertType === 'success',
                        'text-red-600': alertType === 'error',
                        'text-yellow-500': alertType === 'warning',
                    }">
                        {{ alertIcon }}
                    </div>
                    <h2 class="text-2xl font-bold mb-2">{{ alertTitle }}</h2>
                    <p class="text-gray-600 mb-5">{{ alertMessage }}</p>
                    <div class="flex justify-center gap-3">
                        <button v-if="alertType === 'warning'" @click="confirmAction"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Yes
                        </button>
                        <button @click="closeAlert"
                            class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                            {{ alertType === "warning" ? "Cancel" : "OK" }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Opportunities Modal -->
        <transition name="fade">
            <div v-if="showOpportunitiesModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]"
                @click.self="showOpportunitiesModal = false">
                <OpportunitiesModal :opportunities="currentReport?.analysis?.opportunities || []"
                    @close="showOpportunitiesModal = false" />
            </div>
        </transition>

        <!-- Risk & Limitations Modal -->
        <transition name="fade">
            <div v-if="showRiskLimitationsModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]"
                @click.self="showRiskLimitationsModal = false">
                <RiskLimitationsModal :riskFactors="currentReport?.analysis?.risk_factors || []"
                    @close="showRiskLimitationsModal = false" />
            </div>
        </transition>

        <!-- Recommendations Modal -->
        <transition name="fade">
            <div v-if="showRecommendationsModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]"
                @click.self="showRecommendationsModal = false">
                <RecommendationsModal :recommendations="currentReport?.analysis?.recommendations || []"
                    @close="showRecommendationsModal = false" />
            </div>
        </transition>

        <!-- Executive Summary Modal -->
        <transition name="fade">
            <div v-if="showExecutiveSummaryModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999]"
                @click.self="showExecutiveSummaryModal = false">
                <ExecutiveSummaryModal :executiveSummary="currentReport?.analysis?.executive_summary || ''"
                    @close="showExecutiveSummaryModal = false" />
            </div>
        </transition>
    </div>
</template>

<script setup>
import LoadingOverlay from "../Components/LoadingOverlay.vue";
import OpportunitiesModal from "../Modals/Opportunities.vue";
import RiskLimitationsModal from "../Modals/Risk-Limitations.vue";
import RecommendationsModal from "../Modals/Recommendations.vue";
import ExecutiveSummaryModal from "../Modals/ExecutiveSummary.vue";
import { ref, watchEffect, computed, watch } from "vue";
import { Line, Bar, Pie, Radar, PolarArea, Scatter, Bubble } from "vue-chartjs";
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
        default: () => ({}),
    },
    isSaved: {
        type: Boolean,
        default: false,
    },
});

const reports = ref([]);
const applicant = ref("");
const isLoading = ref(true);
const error = ref(null);
const chartMap = ref({});
const currentReport = ref(null);
const isExporting = ref(false);
const showOpportunitiesModal = ref(false);
const showRiskLimitationsModal = ref(false);
const showRecommendationsModal = ref(false);
const showExecutiveSummaryModal = ref(false);

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
    console.log(
        "🔍 AI-AgentContext received analysisData:",
        props.analysisData
    );
    console.log(
        "🔍 AnalysisData keys:",
        props.analysisData ? Object.keys(props.analysisData) : "null/undefined"
    );

    if (!props.analysisData || Object.keys(props.analysisData).length === 0) {
        console.log("⚠️ AnalysisData is empty, returning early");
        return;
    }

    try {
        const rep = props.analysisData;
        console.log("📋 Processing report with form_id:", rep.form_id);

        const charts = rep.graph_suggestions?.suggested_charts || [];
        console.log("📊 Charts found:", charts.length);
        chartMap.value[rep.form_id] = charts.map((chart) => {
            let component;
            let options = chart.chart_options || {};
            const type = chart.chart_type?.toLowerCase() || "";

            if (type.includes("line") || type.includes("bar")) {
                const chartData = chart.chart_data;
                if (chartData && chartData.datasets) {

                    let maxValue = 0;
                    chartData.datasets.forEach((dataset) => {
                        if (dataset.data && Array.isArray(dataset.data)) {
                            const datasetMax = Math.max(...dataset.data.filter(v => typeof v === 'number'));
                            if (datasetMax > maxValue) {
                                maxValue = datasetMax;
                            }
                        }
                    });

                    const newMax = maxValue + 1;

                    if (type.includes("line")) {
                        component = Line;
                        options = {
                            ...options,
                            scales: {
                                ...options.scales,
                                y: {
                                    ...options.scales?.y,
                                    max: newMax, 
                                    beginAtZero: options.scales?.y?.beginAtZero ?? true,
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                }
                            }
                        };
                    } else if (type.includes("horizontal_bar")) {
                        component = Bar;
                        options = {
                            ...options,
                            indexAxis: "y",
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    max: newMax, 
                                    beginAtZero: options.scales?.x?.beginAtZero ?? true,
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                }
                            }
                        };
                    } else {
                        component = Bar;
                        options = {
                            ...options,
                            scales: {
                                ...options.scales,
                                y: {
                                    ...options.scales?.y,
                                    max: newMax, 
                                    beginAtZero: options.scales?.y?.beginAtZero ?? true,
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                }
                            }
                        };
                    }
                } else {

                    if (type.includes("line")) {
                        component = Line;
                        options = {
                            ...options,
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                }
                            }
                        };
                    } else if (type.includes("horizontal_bar")) {
                        component = Bar;
                        options = {
                            ...options,
                            indexAxis: "y",
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                }
                            }
                        };
                    } else {
                        component = Bar;
                        options = {
                            ...options,
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                }
                            }
                        };
                    }
                }
            } else if (type.includes("pie") || type.includes("doughnut")) {
                component = Pie;

                const { scales, ...optionsWithoutScales } = options;
                options = {
                    ...optionsWithoutScales,
                    plugins: {
                        ...options.plugins,
                        title: {
                            ...options.plugins?.title,
                            display: false
                        }
                    }
                };
                if (type.includes("doughnut"))
                    options = { ...options, cutout: "50%" };
            } else if (type.includes("radar")) component = Radar;
            else if (type.includes("polar")) component = PolarArea;
            else if (type.includes("scatter")) component = Scatter;
            else if (type.includes("bubble")) component = Bubble;
            else component = Bar;

            if (!type.includes("pie") && !type.includes("doughnut")) {
                options = {
                    ...options,
                    plugins: {
                        ...options.plugins,
                        title: {
                            ...options.plugins?.title,
                            display: false
                        }
                    }
                };
            }

            return {
                title: chart.title,
                description: chart.description,
                component,
                chart_data: chart.chart_data,
                chart_options: options,
            };
        });

        currentReport.value = rep;
        applicant.value = rep.analysis?.basic_info?.applicant || "";
        isLoading.value = false;
        error.value = null;
        console.log("✅ Current report set:", currentReport.value);
        console.log("✅ Report has analysis:", !!currentReport.value?.analysis);
        console.log(
            "✅ Report has graph_suggestions:",
            !!currentReport.value?.graph_suggestions
        );
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
        showAlert(
            "error",
            "Export Failed",
            "No report data available to export."
        );
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
        const csrf = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        const response = await fetch("/export-report-pdf", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
                Accept: "application/pdf",
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            // Try to get error message from response
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                const errorData = await response.json();
                throw new Error(
                    errorData.error ||
                    errorData.message ||
                    "Failed to export PDF"
                );
            }
            throw new Error(
                `Failed to export PDF: ${response.status} ${response.statusText}`
            );
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
        showAlert(
            "success",
            "Export Successful",
            "Analyze Report was successfully exported to PDF!"
        );
    } catch (error) {
        console.error("PDF Export Error:", error);
        showAlert(
            "error",
            "Error exporting PDF: " + (error.message || "Please try again.")
        );
    } finally {
        isExporting.value = false;
    }
};

const isValidReport = computed(() => !!currentReport.value);

const handleExportClick = () => {
    if (!isValidReport.value) {
        showAlert(
            "warning",
            "⚠️ Please select a valid report before exporting to PDF."
        );
        return;
    }
    exportToPDF();
};

watch(isExporting, (newVal) => {
    if (newVal) {
        document.body.style.overflow = "hidden"; // disable scroll
    } else {
        document.body.style.overflow = ""; // restore scroll
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

/* Insight Item Styles */
.insight-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 0.75rem;
    transition: all 300ms;
    position: relative;
    cursor: pointer;
}

.insight-item:hover {
    background: linear-gradient(to right, #00853F, #4CAF50);
    color: white !important;
}

/* Show the button only on hover */
.insight-item .see-more {
    opacity: 0;
    transition: opacity 0.3s;
}

.insight-item:hover .see-more {
    opacity: 1;
}
</style>