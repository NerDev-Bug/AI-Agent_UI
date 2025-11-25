<template>
    <div class="bg-gradient-to-br from-emerald-50/50 via-green-50/30 to-teal-50/50 min-h-screen w-full mt-24 relative">
        <!-- Subtle pattern overlay -->
        <div class="fixed inset-0 opacity-[0.02] pointer-events-none z-0"
            style="background-image: radial-gradient(circle at 2px 2px, #16a34a 1px, transparent 0); background-size: 40px 40px;">
        </div>
        <!-- Select and Export -->
        <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6 mb-8 px-2">
            <div class="flex-2 w-full md:w-auto">
                <br />
                <!-- ✅ Export PDF button - only show after save (for Quadrant memory storage) -->
                <ExportPDFButton
                    :currentReport="currentReport"
                    :isSaved="isSaved"
                    :isExporting="isExporting"
                    :handleExportClick="handleExportClick"
                />
            </div>

            <ApplicantSelector
                :uniqueApplicants="uniqueApplicants"
                v-model="applicant"
                :currentReport="currentReport"
            />
        </div>

        <!-- Report Display -->
        <div v-if="currentReport && applicant" class="p-2">
            <h3 class="text-2xl font-bold text-gray-800 mb-2 ml-4">
                {{ currentReport.form_type }}
            </h3>

            <!-- Basic Info -->
            <div class="flex flex-col xl:flex-row gap-2 w-full">
                <div v-if="currentReport.analysis?.basic_info"
                    class="bg-white border-l-4 border-primary-500 p-6 rounded-2xl h-full flex-1 w-full animate-slideInLeft shadow-large hover:shadow-glow transition-all duration-300">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6 text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Basic Information
                    </h4>
                    <ul class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800">
                        <!-- Item -->
                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-user"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Applicant</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.applicant }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Application Date</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.application_date
                                }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-handshake"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Cooperator</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.cooperator }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-box-open"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Product</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.product }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Location</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.location }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-leaf"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Crop</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.crop }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-ruler-combined"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Plot Size</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.plot_size }}</span>
                            </div>
                        </li>

                        <li class="flex items-start gap-3">
                            <span class="text-primary-600 pt-1">
                                <i class="fas fa-seedling"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">Planting Date</span>
                                <span class="text-gray-700">{{ currentReport.analysis.basic_info.planting_date }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Control + Leads Agri Metrics (Right Side of Basic Info) -->
                <div class="border-l-4 border-secondary-500 bg-gradient-to-br from-white via-secondary-50/20 to-white p-6 rounded-2xl flex flex-col flex-1 w-full xl:mt-0 mt-4 shadow-large hover:shadow-glow transition-all duration-300"
                    style="box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1), 0 4px 6px -2px rgba(37, 99, 235, 0.05);">
                    <div class="flex items-center mb-6">
                        <h4 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-6 h-6 text-secondary-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                            Performance Metrics
                        </h4>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Control Average -->
                        <div
                            class="relative rounded-3xl bg-gradient-to-br from-secondary-700 via-secondary-600 to-secondary-500 text-white h-40 px-6 shadow-large flex items-center justify-center transform transition-all duration-300 hover:scale-105 hover:shadow-glow-blue">
                            <!-- Centered Number -->
                            <p class="text-5xl font-bold leading-none">
                                {{
                                    currentReport.analysis.performance_analysis.calculated_metrics.control_average.toFixed(
                                        2
                                    )
                                }}
                            </p>
                            <!-- Bottom-Left Label -->
                            <p class="absolute bottom-4 left-6 text-sm font-medium opacity-95">
                                Control Average
                            </p>
                        </div>

                        <!-- Leads Agri Average -->
                        <div
                            class="relative rounded-3xl bg-gradient-to-br from-primary-700 via-primary-600 to-primary-500 text-white h-40 px-6 shadow-large flex items-center justify-center transform transition-all duration-300 hover:scale-105 hover:shadow-glow">
                            <!-- Centered Number -->
                            <p class="text-5xl font-bold leading-none">
                                {{
                                    currentReport.analysis.performance_analysis.calculated_metrics.leads_average.toFixed(
                                        2
                                    )
                                }}
                            </p>
                            <!-- Bottom-Left Label -->
                            <p class="absolute bottom-4 left-6 text-sm font-medium opacity-95">
                                Leads Agri Average
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics Section -->
            <div v-if="currentReport.analysis?.performance_analysis">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 pt-4">
                    <!-- Season -->
                    <div :class="[
                        'overflow-hidden bg-gradient-to-br rounded-2xl p-8 flex flex-col items-center justify-center relative min-h-[180px] shadow-large hover:shadow-glow transition-all duration-300 transform hover:scale-105 border-2',
                        currentReport.analysis.basic_info.season === 'dry'
                            ? 'from-yellow-100 via-amber-100/80 to-yellow-100 border-yellow-300/60'
                            : 'from-sky-100 via-blue-100/80 to-sky-100 border-sky-300/60'
                    ]"
                        :style="currentReport.analysis.basic_info.season === 'dry'
                            ? 'box-shadow: 0 10px 15px -3px rgba(250, 204, 21, 0.15), 0 4px 6px -2px rgba(250, 204, 21, 0.1);'
                            : 'box-shadow: 0 10px 15px -3px rgba(56, 189, 248, 0.15), 0 4px 6px -2px rgba(56, 189, 248, 0.1);'">
                        <!-- Decorative corner accent -->
                        <div :class="[
                            'absolute top-0 right-0 w-20 h-20 rounded-bl-full opacity-10',
                            currentReport.analysis.basic_info.season === 'dry'
                                ? 'bg-yellow-700'
                                : 'bg-sky-700'
                        ]"></div>
                        <!-- Season Badge (top right) -->
                        <div :class="[
                            'absolute top-4 right-4 text-white text-sm font-semibold px-4 py-1.5 rounded-full capitalize shadow-medium z-10',
                            currentReport.analysis.basic_info.season === 'dry'
                                ? 'bg-gradient-to-r from-yellow-400 to-amber-500'
                                : 'bg-gradient-to-r from-sky-400 to-blue-500'
                        ]">
                            {{
                                currentReport.analysis.basic_info.season
                            }}
                        </div>
                        <!-- Display Based on Season -->
                        <div class="flex items-center justify-center mt-4 relative z-10">
                            <!-- DRY = Sun icon -->
                            <img v-if="currentReport.analysis.basic_info.season === 'dry'" src="/images/sun.png"
                                alt="Dry Season Icon" class="w-24 h-auto drop-shadow-md" />

                            <!-- WET = Cloud/rain icon -->
                            <img v-else src="/images/cloud_with_rain.png" alt="Wet Season Icon"
                                class="w-24 h-auto drop-shadow-md" />
                        </div>

                        <!-- Season Label (bottom left) -->
                        <p class="text-sm font-semibold text-gray-700 absolute bottom-4 left-4 z-10">Season</p>
                    </div>

                    <!-- Relative Improvement -->
                    <div :class="[
                        'overflow-hidden bg-gradient-to-br rounded-2xl p-8 flex flex-col items-center justify-center text-center relative shadow-large hover:shadow-glow transition-all duration-300 transform hover:scale-105 border-2',
                        improvementValue > 0
                            ? 'from-green-100 via-emerald-100/80 to-green-100 border-green-300/60'
                            : improvementValue < 0
                                ? 'from-red-100 via-rose-100/80 to-red-100 border-red-300/60'
                                : 'from-gray-100 via-slate-100/80 to-gray-100 border-gray-300/60'
                    ]"
                        :style="improvementValue > 0
                            ? 'box-shadow: 0 10px 15px -3px rgba(34, 197, 94, 0.15), 0 4px 6px -2px rgba(34, 197, 94, 0.1);'
                            : improvementValue < 0
                                ? 'box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.15), 0 4px 6px -2px rgba(239, 68, 68, 0.1);'
                                : 'box-shadow: 0 10px 15px -3px rgba(107, 114, 128, 0.1), 0 4px 6px -2px rgba(107, 114, 128, 0.05);'">
                        <!-- Decorative corner accent -->
                        <div :class="[
                            'absolute top-0 right-0 w-20 h-20 rounded-bl-full opacity-10',
                            improvementValue > 0
                                ? 'bg-green-700'
                                : improvementValue < 0
                                    ? 'bg-red-700'
                                    : 'bg-gray-700'
                        ]"></div>
                        <!-- Status badge -->
                        <span v-if="improvementValue > 0"
                            class="absolute top-4 right-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-medium animate-pulse z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            </svg>
                            <span>Improved</span>
                        </span>

                        <span v-else-if="improvementValue < 0"
                            class="absolute top-4 right-4 bg-gradient-to-r from-red-600 to-rose-600 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-medium z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                            <span>Decreased</span>
                        </span>

                        <span v-else
                            class="absolute top-4 right-4 bg-gradient-to-r from-gray-400 to-slate-500 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-medium z-10">
                            <span>→</span>
                            <span>No Change</span>
                        </span>
                        <!-- Icon background -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                stroke="currentColor" class="w-32 h-32">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                            </svg>
                        </div>
                        <!-- Main Value -->
                        <p :class="[
                            'text-3xl md:text-4xl font-bold relative z-10',
                            improvementValue > 0
                                ? 'text-green-700'
                                : improvementValue < 0
                                    ? 'text-red-700'
                                    : 'text-gray-700'
                        ]">
                            {{ improvementValue.toFixed(2) }}%
                        </p>
                        <!-- Label -->
                        <p
                            class="absolute bottom-3 left-4 md:left-6 text-xs md:text-sm text-gray-700 font-semibold z-10">
                            Relative Improvement</p>
                    </div>

                    <!-- Significance -->
                    <div class="relative overflow-hidden bg-gradient-to-br from-blue-100 via-indigo-100/80 to-blue-100 rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-large hover:shadow-glow transition-all duration-300 transform hover:scale-105 border border-blue-300/60"
                        style="box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.15), 0 4px 6px -2px rgba(59, 130, 246, 0.1);">
                        <!-- Decorative corner accent -->
                        <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-full bg-blue-700 opacity-10"></div>
                        <!-- Icon background -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                stroke="currentColor" class="w-32 h-32">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <p class="text-3xl md:text-4xl font-bold text-blue-700 capitalize relative z-10">
                            {{
                                currentReport.analysis.performance_analysis
                                    .statistical_assessment
                                    .improvement_significance
                            }}
                        </p>
                        <p
                            class="absolute bottom-3 left-4 md:left-6 text-xs md:text-sm text-gray-700 font-semibold z-10">
                            Significance</p>
                    </div>

                    <!-- Absolute Difference -->
                    <div class="relative overflow-hidden bg-gradient-to-br 
    from-purple-100 via-violet-100/80 to-purple-100 
    rounded-2xl p-8 flex flex-col items-center justify-center 
    text-center shadow-large hover:shadow-glow transition-all 
    duration-300 transform hover:scale-105 border border-purple-300/60" style="box-shadow: 0 10px 15px -3px rgba(168, 85, 247, 0.15),
    0 4px 6px -2px rgba(168, 85, 247, 0.1);">
                        <!-- Decorative corner accent -->
                        <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-full bg-purple-700 opacity-10"></div>
                        <!-- Icon background -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                stroke="currentColor" class="w-32 h-32">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </div>
                        <p class="text-3xl md:text-4xl font-bold text-purple-700 relative z-10">
                            {{
                                currentReport.analysis.performance_analysis.calculated_metrics.absolute_difference.toFixed(2)
                            }}
                            <span class="text-sm md:text-base text-purple-600 font-normal">
                                {{
                                    currentReport.analysis.performance_analysis
                                        .calculated_metrics
                                        .absolute_difference_unit
                                }}
                            </span>
                        </p>
                        <p
                            class="absolute bottom-3 left-4 md:left-6 text-xs md:text-sm text-gray-700 font-semibold z-10">
                            Absolute Difference</p>
                    </div>
                </div>
            </div>

            <!-- Responsive Charts + Treatment Details -->
            <div v-if="currentReport.analysis?.performance_analysis || chartMap[currentReport.form_id]?.length"
                class="flex flex-col gap-2 pt-4 w-full">

                <template v-if="chartMap[currentReport.form_id]">

                    <!-- Count charts -->
                    <div class="hidden">
                        {{ chartCount = chartMap[currentReport.form_id]?.length || 0 }}
                    </div>

                    <!-- 2-column grid ALWAYS -->
                    <div class="grid gap-2 w-full md:grid-cols-2">

                        <!-- Render CHARTS -->
                        <div v-for="(chart, idx) in chartMap[currentReport.form_id]" :key="idx" :class="[
                            'chart-card bg-gradient-to-br rounded-2xl shadow-large p-6 hover:shadow-glow transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden border',
                            idx % 2 === 0
                                ? 'border-primary-500 from-white via-primary-50/20 to-white'
                                : 'border-secondary-500 from-white via-secondary-50/20 to-white'
                        ]"
                            :style="idx % 2 === 0
                                ? 'box-shadow: 0 10px 15px -3px rgba(22, 163, 74, 0.12), 0 4px 6px -2px rgba(22, 163, 74, 0.08);'
                                : 'box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.12), 0 4px 6px -2px rgba(37, 99, 235, 0.08);'">
                            <!-- Chart type icon -->
                            <div class="absolute top-4 right-4 opacity-10">
                                <svg v-if="chart.chart_type?.toLowerCase().includes('line')"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            <h5 :class="[
                                'text-2xl font-semibold mb-6 px-2 relative z-10',
                                idx % 2 === 0
                                    ? 'text-primary-800'
                                    : 'text-secondary-800'
                            ]">
                                {{ chart.title }}
                            </h5>

                            <div class="relative z-10 min-h-[350px] flex items-center justify-center">
                                <component :is="chart.component" :data="chart.chart_data"
                                    :options="chart.chart_options" />
                            </div>

                            <p v-if="chart.description"
                                class="text-gray-700 mb-3 text-sm md:text-base leading-relaxed italic px-2 md:px-4 relative z-10 mt-4 bg-white/50 rounded-lg p-3">
                                {{ chart.description }}
                            </p>
                        </div>

                        <!-- Treatment Details INSIDE grid for ODD counts (1,3,5,7...) -->
                        <div v-if="chartCount % 2 === 1 && currentReport.analysis?.treatment_comparison"
                            class="chart-card bg-gradient-to-br from-white via-blue-50/50 to-white rounded-2xl shadow-large p-6 relative overflow-hidden border border-blue-500"
                            style="box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.12), 0 4px 6px -2px rgba(59, 130, 246, 0.08);">
                            <!-- Decorative top accent -->
                            <!-- <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-blue-300">
                            </div> -->
                            <!-- Decorative corner accent -->
                            <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-full bg-blue-400 opacity-10"></div>

                            <h5 class="text-2xl font-semibold mb-4 text-blue-800 px-2 relative z-10">
                                Treatment Details
                            </h5>

                            <!-- Treatment Details Table -->
                            <div class="overflow-x-auto -mx-2 px-2 md:mx-0 md:px-0 relative z-10">
                                <div class="inline-block min-w-full align-middle">
                                    <div
                                        class="overflow-hidden shadow-xl md:rounded-xl bg-white/90 backdrop-blur-sm border border-gray-200/50">
                                        <table class="min-w-full divide-y divide-gray-100">
                                            <thead>
                                                <tr>
                                                    <th colspan="2"
                                                        class="bg-gradient-to-r from-blue-600 via-blue-650 to-blue-700 text-white px-6 py-5 text-left font-bold text-sm uppercase tracking-wider shadow-md"
                                                        style="background: linear-gradient(to right, #2563eb, #1d4ed8, #1e40af);">
                                                        Standard Practice
                                                    </th>
                                                    <th colspan="2"
                                                        class="bg-gradient-to-r from-green-600 via-green-650 to-green-700 text-white px-6 py-5 text-left font-bold text-sm uppercase tracking-wider shadow-md"
                                                        style="background: linear-gradient(to right, #16a34a, #15803d, #166534);">
                                                        Leads Agri Treatment
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-100">
                                                <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                    <td
                                                        class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                        Product:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.control.product
                                                        }}
                                                    </td>
                                                    <td
                                                        class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                        Product:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                        {{
                                                            currentReport.analysis.treatment_comparison.leads_agri.product
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                    <td
                                                        class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                        Rate:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.control.rate }}
                                                    </td>
                                                    <td
                                                        class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                        Rate:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.leads_agri.rate
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                    <td
                                                        class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                        Timing:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.control.timing }}
                                                    </td>
                                                    <td
                                                        class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                        Timing:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.leads_agri.timing
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                    <td
                                                        class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                        Method:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.control.method }}
                                                    </td>
                                                    <td
                                                        class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                        Method:
                                                    </td>
                                                    <td
                                                        class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                        {{ currentReport.analysis.treatment_comparison.leads_agri.method
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-3 text-sm md:text-base leading-relaxed mt-6 px-2 md:px-4 bg-blue-50/30 rounded-lg p-4 border border-blue-200/50 relative z-10"
                                style="box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.08), 0 2px 4px -1px rgba(59, 130, 246, 0.04);">
                                {{ currentReport.analysis.treatment_comparison.protocol_assessment }}
                            </p>
                        </div>
                    </div>

                    <!-- Treatment Details BELOW grid for EVEN counts (2,4,6...) -->
                    <div v-if="chartCount % 2 === 0 && currentReport.analysis?.treatment_comparison"
                        class="bg-gradient-to-br from-white via-blue-50/50 to-white rounded-2xl shadow-large p-6 mt-2 relative overflow-hidden border border-blue-500"
                        style="box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.12), 0 4px 6px -2px rgba(59, 130, 246, 0.08);">
                        <!-- Decorative top accent -->
                        <!-- <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-blue-300">
                        </div> -->
                        <!-- Decorative corner accent -->
                        <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-full bg-blue-400 opacity-10"></div>

                        <h5 class="text-2xl font-semibold mb-4 text-blue-800 px-2 relative z-10">
                            Treatment Details
                        </h5>

                        <!-- Treatment Details Table -->
                        <div class="overflow-x-auto -mx-2 px-2 md:mx-0 md:px-0 relative z-10">
                            <div class="inline-block min-w-full align-middle">
                                <div
                                    class="overflow-hidden shadow-xl md:rounded-xl bg-white/90 backdrop-blur-sm border border-gray-200/50">
                                    <table class="min-w-full divide-y divide-gray-100">
                                        <thead>
                                            <tr>
                                                <th colspan="2"
                                                    class="bg-gradient-to-r from-blue-600 via-blue-650 to-blue-700 text-white px-6 py-5 text-left font-bold text-sm uppercase tracking-wider shadow-md">
                                                    Standard Practice
                                                </th>
                                                <th colspan="2"
                                                    class="bg-gradient-to-r from-green-600 via-green-650 to-green-700 text-white px-6 py-5 text-left font-bold text-sm uppercase tracking-wider shadow-md">
                                                    Leads Agri Treatment
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                <td
                                                    class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                    Product:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.control.product }}
                                                </td>
                                                <td
                                                    class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                    Product:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.leads_agri.product }}
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                <td
                                                    class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                    Rate:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.control.rate }}
                                                </td>
                                                <td
                                                    class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                    Rate:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.leads_agri.rate }}
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                <td
                                                    class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                    Timing:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.control.timing }}
                                                </td>
                                                <td
                                                    class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                    Timing:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.leads_agri.timing }}
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                                <td
                                                    class="bg-gradient-to-r from-blue-50/80 to-blue-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-blue-100 group-hover:from-blue-100/80 group-hover:to-blue-100/60">
                                                    Method:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 border-r border-gray-100 group-hover:bg-blue-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.control.method }}
                                                </td>
                                                <td
                                                    class="bg-gradient-to-r from-green-50/80 to-green-50/60 px-6 py-4 text-gray-800 font-bold text-sm border-r border-green-100 group-hover:from-green-100/80 group-hover:to-green-100/60">
                                                    Method:
                                                </td>
                                                <td
                                                    class="bg-white/90 px-6 py-4 text-gray-700 group-hover:bg-green-50/20">
                                                    {{ currentReport.analysis.treatment_comparison.leads_agri.method }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-3 text-sm md:text-base leading-relaxed mt-6 px-2 md:px-4 bg-blue-50/30 rounded-lg p-4 border border-blue-200/50 relative z-10"
                            style="box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.08), 0 2px 4px -1px rgba(59, 130, 246, 0.04);">
                            {{ currentReport.analysis.treatment_comparison.protocol_assessment }}
                        </p>
                    </div>
                </template>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-3 mt-3">

                <!-- World Map Card (No Data State) -->
                <div
                    class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-2xl shadow-soft border-2 border-dashed border-gray-200 flex flex-col items-center justify-center min-h-[300px] w-full">
                    <div class="text-gray-300 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-16 h-16 md:w-20 md:h-20">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.944 11.944 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm md:text-base font-medium">Map visualization coming soon</p>
                </div>

                <!-- Key Findings & Strategic Insights -->
                <div class="bg-gray-100 p-6 rounded-2xl shadow-lg w-full">
                    <h2 class="text-xl font-semibold mb-6 text-gray-800">
                        Key Findings & Strategic Insights
                    </h2>

                    <!-- Opportunities -->
                    <div class="insight-item bg-gradient-to-r from-gray-100 to-gray-50 rounded-xl px-5 py-4 mb-3 flex items-center justify-between cursor-pointer shadow-soft hover:shadow-medium transition-all duration-300 border-2 border-transparent hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        @click="showOpportunitiesModal = true" tabindex="0"
                        @keyup.enter="showOpportunitiesModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-primary-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                            </svg>
                            Opportunities
                        </span>
                        <button
                            class="see-more-btn bg-gradient-to-r from-accent-yellow to-yellow-500 text-gray-900 text-xs px-4 py-2 rounded-full font-bold shadow-soft hover:shadow-medium transition-all duration-300 transform hover:scale-105">
                            See more
                        </button>
                    </div>

                    <!-- Risks & Limitations -->
                    <div class="insight-item bg-gradient-to-r from-gray-100 to-gray-50 rounded-xl px-5 py-4 mb-3 flex items-center justify-between cursor-pointer shadow-soft hover:shadow-medium transition-all duration-300 border-2 border-transparent hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        @click="showRiskLimitationsModal = true" tabindex="0"
                        @keyup.enter="showRiskLimitationsModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Risks & Limitations
                        </span>
                        <button
                            class="see-more-btn bg-gradient-to-r from-accent-yellow to-yellow-500 text-gray-900 text-xs px-4 py-2 rounded-full font-bold shadow-soft hover:shadow-medium transition-all duration-300 transform hover:scale-105">
                            See more
                        </button>
                    </div>

                    <!-- Executive Summary -->
                    <div class="insight-item bg-gradient-to-r from-gray-100 to-gray-50 rounded-xl px-5 py-4 mb-3 flex items-center justify-between cursor-pointer shadow-soft hover:shadow-medium transition-all duration-300 border-2 border-transparent hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2"
                        @click="showExecutiveSummaryModal = true" tabindex="0"
                        @keyup.enter="showExecutiveSummaryModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-secondary-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Executive Summary
                        </span>
                        <button
                            class="see-more-btn bg-gradient-to-r from-accent-yellow to-yellow-500 text-gray-900 text-xs px-4 py-2 rounded-full font-bold shadow-soft hover:shadow-medium transition-all duration-300 transform hover:scale-105">
                            See more
                        </button>
                    </div>

                    <!-- Recommendations -->
                    <div class="insight-item bg-gradient-to-r from-gray-100 to-gray-50 rounded-xl px-5 py-4 mb-3 flex items-center justify-between cursor-pointer shadow-soft hover:shadow-medium transition-all duration-300 border-2 border-transparent hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        @click="showRecommendationsModal = true" tabindex="0"
                        @keyup.enter="showRecommendationsModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-primary-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Recommendations
                        </span>
                        <button
                            class="see-more-btn bg-gradient-to-r from-accent-yellow to-yellow-500 text-gray-900 text-xs px-4 py-2 rounded-full font-bold shadow-soft hover:shadow-medium transition-all duration-300 transform hover:scale-105">
                            See more
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading/Error/Empty Placeholder -->
        <div v-else-if="!currentReport" class="flex flex-col items-center justify-center min-h-[500px] mt-10 px-4">
            <div class="relative flex flex-col items-center justify-center max-w-2xl w-full">
                <!-- Modern Card Container -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 w-full border-2 border-primary-100 relative overflow-hidden">
                    <!-- Decorative Background Elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary-100 rounded-full blur-3xl opacity-30 -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-emerald-100 rounded-full blur-3xl opacity-20 -ml-24 -mb-24"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <!-- Modern Icon Container -->
                        <div class="relative mb-6">
                            <!-- Icon Illustration - Not Clickable -->
                            <div class="flex items-center justify-center">
                                <div class="relative">
                                    <!-- Main Document Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 md:w-32 md:h-32 text-primary-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <!-- Decorative Lines Inside Document -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 md:w-20 md:h-20 pointer-events-none">
                                        <div class="absolute top-1/3 left-1/4 right-1/4 h-0.5 bg-primary-300 rounded"></div>
                                        <div class="absolute top-1/2 left-1/4 right-1/3 h-0.5 bg-primary-300 rounded"></div>
                                        <div class="absolute top-2/3 left-1/4 right-1/2 h-0.5 bg-primary-300 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Text Section -->
                        <div class="text-center">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                                No Data Found
                            </h2>
                            <p class="text-base md:text-lg text-gray-600 leading-relaxed max-w-lg mx-auto mb-8">
                                Upload a file and click the <span class="font-semibold text-primary-600">Analyze Demo Form</span> button to show the analyzed result of your uploaded file.
                            </p>
                            
                            <!-- Feature Icons -->
                            <div class="flex items-center justify-center gap-6 mb-8 flex-wrap">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <div class="bg-primary-100 rounded-lg p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <span>PDF Support</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <div class="bg-primary-100 rounded-lg p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                        </svg>
                                    </div>
                                    <span>AI Analysis</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <div class="bg-primary-100 rounded-lg p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </div>
                                    <span>Instant Results</span>
                                </div>
                            </div>
                            
                            <!-- CTA Button -->
                            <button @click="scrollToUpload"
                                class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-8 py-4 rounded-xl font-bold text-base md:text-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 active:scale-95 flex items-center gap-3 mx-auto group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                    stroke="currentColor" class="w-6 h-6 group-hover:translate-y-[-2px] transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 16.5V3.75m0 0L6.75 9m5.25-5.25L17.25 9M3.75 19.5h16.5" />
                                </svg>
                                Get Started
                            </button>
                        </div>
                    </div>
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
                <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm p-6 text-center border-4" :class="{
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
        <transition name="modal">
            <div v-if="showOpportunitiesModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-end md:items-center justify-center z-[9999]"
                @click.self="showOpportunitiesModal = false">
                <div class="w-full md:w-auto md:max-w-4xl md:m-4">
                    <OpportunitiesModal :opportunities="currentReport?.analysis?.opportunities || []"
                        @close="showOpportunitiesModal = false" />
                </div>
            </div>
        </transition>

        <!-- Risk & Limitations Modal -->
        <transition name="modal">
            <div v-if="showRiskLimitationsModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-end md:items-center justify-center z-[9999]"
                @click.self="showRiskLimitationsModal = false">
                <div class="w-full md:w-auto md:max-w-4xl md:m-4">
                    <RiskLimitationsModal :riskFactors="currentReport?.analysis?.risk_factors || []"
                        @close="showRiskLimitationsModal = false" />
                </div>
            </div>
        </transition>

        <!-- Recommendations Modal -->
        <transition name="modal">
            <div v-if="showRecommendationsModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-end md:items-center justify-center z-[9999]"
                @click.self="showRecommendationsModal = false">
                <div class="w-full md:w-auto md:max-w-4xl md:m-4">
                    <RecommendationsModal :recommendations="currentReport?.analysis?.recommendations || []"
                        @close="showRecommendationsModal = false" />
                </div>
            </div>
        </transition>

        <!-- Executive Summary Modal -->
        <transition name="modal">
            <div v-if="showExecutiveSummaryModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex items-end md:items-center justify-center z-[9999]"
                @click.self="showExecutiveSummaryModal = false">
                <div class="w-full md:w-auto md:max-w-4xl md:m-4">
                    <ExecutiveSummaryModal :executiveSummary="currentReport?.analysis?.executive_summary || ''"
                        @close="showExecutiveSummaryModal = false" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import LoadingOverlay from "../Components/LoadingOverlay.vue";
import ExportPDFButton from "../Components/ExportPDFButton.vue";
import ApplicantSelector from "../Components/ApplicantSelector.vue";
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

// Import composables
import { usePDFExport } from "./composables/usePDFExport.js";
import { useAlertSystem } from "./composables/useAlertSystem.js";
import { createChartPlugin } from "./composables/useChartPlugin.js";
import { applyBarChartColors } from "./composables/useChartColors.js";

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

// Register chart plugin
const modernChartPlugin = createChartPlugin();
ChartJS.register(modernChartPlugin);

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

// Initialize alert system
const {
    alertVisible,
    alertType,
    alertTitle,
    alertMessage,
    alertIcon,
    showAlert,
    closeAlert,
    confirmAction
} = useAlertSystem();

// Initialize PDF export
const { handleExportClick } = usePDFExport(
    currentReport,
    chartMap,
    isExporting,
    showAlert
);


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

                    // Apply bar chart colors using modular function
                    if (type.includes("bar")) {
                        applyBarChartColors(chartData, type);
                    }

                    // Enhance line charts with gradient fills
                    if (type.includes("line")) {
                        chartData.datasets.forEach((dataset, idx) => {
                            // Match colors to reference: Blue for Control, Green for Leads Agri
                            const colorPalette = [
                                { line: '#3b82f6', fill: 'rgba(59, 130, 246, 0.15)' }, // Blue (Control)
                                { line: '#22c55e', fill: 'rgba(34, 197, 94, 0.15)' }, // Green (Leads Agri)
                                { line: '#f59e0b', fill: 'rgba(245, 158, 11, 0.15)' }, // Amber
                                { line: '#ef4444', fill: 'rgba(239, 68, 68, 0.15)' }, // Red
                                { line: '#14b8a6', fill: 'rgba(20, 184, 166, 0.15)' }, // Teal
                                { line: '#a855f7', fill: 'rgba(168, 85, 247, 0.15)' }, // Purple
                            ];

                            const colors = colorPalette[idx % colorPalette.length];
                            if (!dataset.borderColor) {
                                dataset.borderColor = colors.line;
                            }
                            if (!dataset.backgroundColor) {
                                dataset.backgroundColor = colors.fill;
                            }
                            dataset.fill = true;
                            dataset._gradientFill = true;
                            // Ensure point colors match line color with white border
                            if (!dataset.pointBackgroundColor) {
                                dataset.pointBackgroundColor = colors.line;
                            }
                            if (!dataset.pointBorderColor) {
                                dataset.pointBorderColor = '#ffffff';
                            }
                            if (!dataset.pointBorderWidth) {
                                dataset.pointBorderWidth = 3;
                            }
                        });
                    }

                    if (type.includes("line")) {
                        component = Line;
                        options = {
                            ...options,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                                y: {
                                    ...options.scales?.y,
                                    max: newMax,
                                    beginAtZero: options.scales?.y?.beginAtZero ?? true,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                        callback: function (value) {
                                            return value;
                                        }
                                    }
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                },
                                legend: {
                                    display: options.plugins?.legend?.display !== false,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            size: 13,
                                            weight: '600',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#1e293b',
                                        boxWidth: 12,
                                        boxHeight: 12,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: '600',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '500',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    cornerRadius: 8,
                                    displayColors: true,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: function (context) {
                                            return context.dataset.label + ': ' + context.parsed.y;
                                        }
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.5,
                                    borderWidth: 4,
                                    fill: true,
                                    capBezierPoints: true,
                                },
                                point: {
                                    radius: 7,
                                    hoverRadius: 10,
                                    borderWidth: 3,
                                    hoverBorderWidth: 4,
                                    backgroundColor: '#ffffff',
                                    hoverBackgroundColor: '#ffffff',
                                }
                            }
                        };
                    } else if (type.includes("horizontal_bar")) {
                        component = Bar;
                        options = {
                            ...options,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            indexAxis: "y",
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    max: newMax,
                                    beginAtZero: options.scales?.x?.beginAtZero ?? true,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                                y: {
                                    ...options.scales?.y,
                                    grid: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                },
                                legend: {
                                    display: options.plugins?.legend?.display !== false,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            size: 13,
                                            weight: '600',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#1e293b',
                                        boxWidth: 12,
                                        boxHeight: 12,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: '600',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '500',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    cornerRadius: 8,
                                    displayColors: true,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                }
                            },
                            elements: {
                                bar: {
                                    borderRadius: {
                                        topLeft: 14,
                                        topRight: 14,
                                        bottomLeft: 0,
                                        bottomRight: 0
                                    },
                                    borderSkipped: false,
                                    borderWidth: 0,
                                    shadowOffsetX: 0,
                                    shadowOffsetY: 6,
                                    shadowBlur: 10,
                                    shadowColor: 'rgba(0, 0, 0, 0.12)',
                                }
                            }
                        };
                    } else {
                        component = Bar;
                        options = {
                            ...options,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    grid: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                                y: {
                                    ...options.scales?.y,
                                    max: newMax,
                                    beginAtZero: options.scales?.y?.beginAtZero ?? true,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                        callback: function (value) {
                                            return value;
                                        }
                                    }
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                },
                                legend: {
                                    display: options.plugins?.legend?.display !== false,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            size: 13,
                                            weight: '600',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#1e293b',
                                        boxWidth: 12,
                                        boxHeight: 12,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: '600',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '500',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    cornerRadius: 8,
                                    displayColors: true,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                }
                            },
                            elements: {
                                bar: {
                                    borderRadius: {
                                        topLeft: 14,
                                        topRight: 14,
                                        bottomLeft: 0,
                                        bottomRight: 0
                                    },
                                    borderSkipped: false,
                                    borderWidth: 0,
                                    shadowOffsetX: 0,
                                    shadowOffsetY: 6,
                                    shadowBlur: 10,
                                    shadowColor: 'rgba(0, 0, 0, 0.12)',
                                }
                            }
                        };
                    }
                } else {

                    if (type.includes("line")) {
                        component = Line;
                        options = {
                            ...options,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                                y: {
                                    ...options.scales?.y,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                },
                                legend: {
                                    display: options.plugins?.legend?.display !== false,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            size: 13,
                                            weight: '600',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#1e293b',
                                        boxWidth: 12,
                                        boxHeight: 12,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: '600',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '500',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    cornerRadius: 8,
                                    displayColors: true,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                }
                            },
                            elements: {
                                line: {
                                    tension: 0.5,
                                    borderWidth: 4,
                                    fill: true,
                                    capBezierPoints: true,
                                },
                                point: {
                                    radius: 7,
                                    hoverRadius: 10,
                                    borderWidth: 3,
                                    hoverBorderWidth: 4,
                                    backgroundColor: '#ffffff',
                                    hoverBackgroundColor: '#ffffff',
                                }
                            }
                        };
                    } else if (type.includes("horizontal_bar")) {
                        component = Bar;
                        options = {
                            ...options,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            indexAxis: "y",
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                                y: {
                                    ...options.scales?.y,
                                    grid: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                },
                                legend: {
                                    display: options.plugins?.legend?.display !== false,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            size: 13,
                                            weight: '600',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#1e293b',
                                        boxWidth: 12,
                                        boxHeight: 12,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: '600',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '500',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    cornerRadius: 8,
                                    displayColors: true,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                }
                            },
                            elements: {
                                bar: {
                                    borderRadius: {
                                        topLeft: 14,
                                        topRight: 14,
                                        bottomLeft: 0,
                                        bottomRight: 0
                                    },
                                    borderSkipped: false,
                                    borderWidth: 0,
                                    shadowOffsetX: 0,
                                    shadowOffsetY: 6,
                                    shadowBlur: 10,
                                    shadowColor: 'rgba(0, 0, 0, 0.12)',
                                }
                            }
                        };
                    } else {
                        component = Bar;
                        options = {
                            ...options,
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            },
                            scales: {
                                ...options.scales,
                                x: {
                                    ...options.scales?.x,
                                    grid: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                                y: {
                                    ...options.scales?.y,
                                    grid: {
                                        display: true,
                                        color: 'rgba(0, 0, 0, 0.08)',
                                        lineWidth: 1.5,
                                        drawBorder: false,
                                        drawTicks: false,
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#64748b',
                                        padding: 10,
                                    }
                                },
                            },
                            plugins: {
                                ...options.plugins,
                                title: {
                                    ...options.plugins?.title,
                                    display: false
                                },
                                legend: {
                                    display: options.plugins?.legend?.display !== false,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            size: 13,
                                            weight: '600',
                                            family: "'Inter', 'system-ui', sans-serif"
                                        },
                                        color: '#1e293b',
                                        boxWidth: 12,
                                        boxHeight: 12,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: '600',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '500',
                                        family: "'Inter', 'system-ui', sans-serif"
                                    },
                                    cornerRadius: 8,
                                    displayColors: true,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                }
                            },
                            elements: {
                                bar: {
                                    borderRadius: {
                                        topLeft: 14,
                                        topRight: 14,
                                        bottomLeft: 0,
                                        bottomRight: 0
                                    },
                                    borderSkipped: false,
                                    borderWidth: 0,
                                    shadowOffsetX: 0,
                                    shadowOffsetY: 6,
                                    shadowBlur: 10,
                                    shadowColor: 'rgba(0, 0, 0, 0.12)',
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
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart',
                        animateRotate: true,
                        animateScale: true
                    },
                    plugins: {
                        ...options.plugins,
                        title: {
                            ...options.plugins?.title,
                            display: false
                        },
                        legend: {
                            display: options.plugins?.legend?.display !== false,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 13,
                                    weight: '600',
                                    family: "'Inter', 'system-ui', sans-serif"
                                },
                                color: '#1e293b',
                                boxWidth: 12,
                                boxHeight: 12,
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: '600',
                                family: "'Inter', 'system-ui', sans-serif"
                            },
                            bodyFont: {
                                size: 13,
                                weight: '500',
                                family: "'Inter', 'system-ui', sans-serif"
                            },
                            cornerRadius: 8,
                            displayColors: true,
                            boxPadding: 6,
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderWidth: 2,
                            borderColor: '#ffffff',
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

// PDF export functions are now in composables/usePDFExport.js

// Scroll to upload section
const scrollToUpload = () => {
    const uploadSection = document.getElementById("AI-AgentForm");
    if (uploadSection) {
        uploadSection.scrollIntoView({ behavior: "smooth", block: "start" });
    }
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
    min-height: 350px;
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

/* Modal transitions - bottom sheet on mobile, center on desktop */
.modal-enter-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-leave-active {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-enter-from {
    opacity: 0;
}

.modal-leave-to {
    opacity: 0;
}

@media (max-width: 768px) {
    .modal-enter-from .bg-white {
        transform: translateY(100%);
    }

    .modal-leave-to .bg-white {
        transform: translateY(100%);
    }
}

@media (min-width: 769px) {
    .modal-enter-from .bg-white {
        transform: scale(0.95);
    }

    .modal-leave-to .bg-white {
        transform: scale(0.95);
    }
}

/* Insight Item Styles */
.insight-item {
    transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
}

.insight-item:hover {
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3) !important;
}

.insight-item:hover span {
    color: white !important;
}

.insight-item:hover svg {
    color: white !important;
}

/* See more button - always visible with modern design */
.see-more-btn {
    opacity: 1;
    transition: all 0.3s;
}

.insight-item:hover .see-more-btn {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
    color: white !important;
    transform: scale(1.1);
}
</style>