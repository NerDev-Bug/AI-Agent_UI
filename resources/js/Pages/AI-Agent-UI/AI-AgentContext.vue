<template>
    <div class="bg-gradient-to-br from-background-lighter via-background-light to-background-lighter min-h-screen w-full mt-24">
        <!-- Select and Export -->
        <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6 mb-8 px-2">
            <div class="flex-2 w-full md:w-auto">
                <br />
                <!-- ✅ Export PDF button - only show after save (for Quadrant memory storage) -->
                <button v-if="currentReport && isSaved" @click="handleExportClick" :disabled="isExporting"
                    class="bg-gradient-to-r from-secondary-600 to-secondary-700 w-full md:w-[220px] h-12 rounded-xl text-white hover:from-secondary-700 hover:to-secondary-800 transition-all duration-300 shadow-medium hover:shadow-glow-blue flex items-center justify-center gap-2 font-semibold transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2">
                    <span v-if="!isExporting" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export to PDF
                    </span>
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

            <div class="w-full md:w-auto md:ml-auto" v-if="uniqueApplicants.length > 1">
                <label class="block text-sm text-black mb-1">Select Applicant:</label>
                <select v-model="applicant" class="p-2 rounded-md w-full md:w-72" :disabled="!currentReport">
                    <option value="">-- Choose Applicant --</option>
                    <option v-for="app in uniqueApplicants" :key="app" :value="app">
                        {{ app }}
                    </option>
                </select>
            </div>
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
                    <h4 class="text-2xl font-bold text-gray-800 mb-6 md:mb-8 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Basic Information
                    </h4>
                    <ul
                        class="text-sm md:text-base grid grid-cols-1 sm:grid-cols-2 gap-x-6 md:gap-x-8 gap-y-3 md:gap-y-2 text-gray-800 leading-relaxed">
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Applicant:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.applicant }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Application Date:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.application_date }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Cooperator:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.cooperator }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Product:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.product }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Location:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.location }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Crop:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.crop }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Plot Size:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.plot_size }}</span>
                        </li>
                        <li class="flex flex-col sm:flex-row sm:items-start">
                            <span class="font-semibold text-gray-900 min-w-[140px]">Planting Date:</span>
                            <span class="text-gray-700">{{ currentReport.analysis.basic_info.planting_date }}</span>
                        </li>
                    </ul>
                </div>
                <!-- Control + Leads Agri Metrics (Right Side of Basic Info) -->
                <div class="bg-white p-6 rounded-2xl flex flex-col flex-1 w-full xl:mt-0 mt-4 shadow-large hover:shadow-glow transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <h4 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-secondary-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 pt-2">
                    <!-- Season -->
                    <div
                        class="bg-white border-2 border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center relative min-h-[180px] shadow-soft hover:shadow-medium transition-all duration-300 hover:border-primary-300">
                        <!-- Season Badge (top right) -->
                        <div :class="[
                            'absolute top-4 right-4 text-white text-sm font-semibold px-4 py-1.5 rounded-full capitalize',
                            currentReport.analysis.basic_info.season === 'dry'
                                ? 'bg-yellow-400'
                                : 'bg-sky-400'
                        ]">
                            {{
                                currentReport.analysis.basic_info.season
                            }}
                        </div>
                        <!-- Display Based on Season -->
                        <div class="flex items-center justify-center mt-4">
                            <!-- DRY = Sun icon -->
                            <img v-if="currentReport.analysis.basic_info.season === 'dry'"
                                src="/images/sun.png" alt="Dry Season Icon" class="w-24 h-auto" />

                            <!-- WET = Cloud/rain icon -->
                            <img v-else src="/images/cloud_with_rain.png" alt="Wet Season Icon" class="w-24 h-auto" />
                        </div>

                        <!-- Season Label (bottom left) -->
                        <p class="text-sm text-gray-600 absolute bottom-4 left-4">Season</p>
                    </div>

                        <!-- Relative Improvement -->
                        <div
                            class="bg-white border-2 border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center relative shadow-soft hover:shadow-medium transition-all duration-300 hover:border-primary-300">

                            <!-- Status badge -->
                            <span v-if="improvementValue > 0"
                                class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-soft animate-pulse">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                </svg>
                                <span>Improved</span>
                            </span>

                            <span v-else-if="improvementValue < 0"
                                class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-soft">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                                <span>Decreased</span>
                            </span>

                            <span v-else
                                class="absolute top-4 right-4 bg-gray-400 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 shadow-soft">
                                <span>→</span>
                                <span>No Change</span>
                            </span>
                            <!-- Main Value -->
                            <p class="text-3xl md:text-4xl font-bold text-gray-900">
                                {{ improvementValue.toFixed(2) }}%
                            </p>
                            <!-- Label -->
                            <p class="absolute bottom-3 left-4 md:left-6 text-xs md:text-sm text-gray-600 font-medium">Relative Improvement</p>
                        </div>

                    <!-- Significance -->
                    <div
                        class="relative bg-white border-2 border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-soft hover:shadow-medium transition-all duration-300 hover:border-primary-300">
                        <p class="text-3xl md:text-4xl font-bold text-gray-900 capitalize">
                            {{
                                currentReport.analysis.performance_analysis
                                    .statistical_assessment
                                    .improvement_significance
                            }}
                        </p>
                        <p class="absolute bottom-3 left-4 md:left-6 text-xs md:text-sm text-gray-600 font-medium">Significance</p>
                    </div>

                    <!-- Absolute Difference -->
                    <div
                        class="relative bg-white border-2 border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-soft hover:shadow-medium transition-all duration-300 hover:border-primary-300">
                        <p class="text-3xl md:text-4xl font-bold text-gray-900">
                            {{
                                currentReport.analysis.performance_analysis.calculated_metrics.absolute_difference.toFixed(2)
                            }}
                            <span class="text-sm md:text-base text-gray-600 font-normal">
                                {{
                                    currentReport.analysis.performance_analysis
                                        .calculated_metrics
                                        .absolute_difference_unit
                                }}
                            </span>
                        </p>
                        <p class="absolute bottom-3 left-4 md:left-6 text-xs md:text-sm text-gray-600 font-medium">Absolute Difference</p>
                    </div>
                </div>
            </div>

            <!-- Responsive Charts + Treatment Details -->
            <div v-if="currentReport.analysis?.performance_analysis || chartMap[currentReport.form_id]?.length"
                class="flex flex-col gap-2 pt-2 w-full">

                <template v-if="chartMap[currentReport.form_id]">

                    <!-- Count charts -->
                    <div class="hidden">
                        {{ chartCount = chartMap[currentReport.form_id]?.length || 0 }}
                    </div>

                    <!-- 2-column grid ALWAYS -->
                    <div class="grid gap-2 w-full md:grid-cols-2">

                        <!-- Render CHARTS -->
                        <div v-for="(chart, idx) in chartMap[currentReport.form_id]" :key="idx"
                            class="chart-card bg-white rounded-2xl shadow-large p-6 hover:shadow-glow transition-all duration-300 transform hover:-translate-y-1">
                            <h5 class="text-2xl font-semibold mb-6 text-gray-800 px-2">
                                {{ chart.title }}
                            </h5>

                            <component :is="chart.component" :data="chart.chart_data" :options="chart.chart_options" />

                            <p v-if="chart.description" class="text-gray-700 mb-3 text-sm md:text-base leading-relaxed italic px-2 md:px-4">
                                {{ chart.description }}
                            </p>
                        </div>

                        <!-- Treatment Details INSIDE grid for ODD counts (1,3,5,7...) -->
                        <div v-if="chartCount % 2 === 1 && currentReport.analysis?.treatment_comparison"
                            class="chart-card bg-white rounded-lg shadow p-4">

                            <h5 class="text-2xl font-semibold mb-2 text-gray-800 px-2">
                                Treatment Details
                            </h5>

                        <!-- Treatment Details Table -->
                        <div class="overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300 border-separate border-spacing-0">
                                    <thead>
                                        <tr>
                                            <th colspan="2"
                                                class="bg-blue-600 text-white px-4 py-3 text-left font-semibold border-[0.2px] border-gray-600">
                                                Standard Practice
                                            </th>
                                            <th colspan="2"
                                                class="bg-green-600 text-white px-4 py-3 text-left font-semibold border-[0.2px] border-gray-600">
                                                Leads Agri Treatment
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Product:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.control.product }}
                                            </td>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Product:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.leads_agri.product }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Rate:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.control.rate }}
                                            </td>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Rate:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.leads_agri.rate }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Timing:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.control.timing }}
                                            </td>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Timing:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.leads_agri.timing }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Method:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.control.method }}
                                            </td>
                                            <td
                                                class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                                <b>Method:</b>
                                            </td>
                                            <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                                {{ currentReport.analysis.treatment_comparison.leads_agri.method }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-3 text-sm md:text-base leading-relaxed italic mt-4 px-2 md:px-4">
                            {{ currentReport.analysis.treatment_comparison.protocol_assessment }}
                        </p>
                    </div>
                    </div>

                    <!-- Treatment Details BELOW grid for EVEN counts (2,4,6...) -->
                    <div v-if="chartCount % 2 === 0 && currentReport.analysis?.treatment_comparison"
                        class="bg-white rounded-2xl shadow p-4 mt-2">

                        <h5 class="text-2xl font-semibold mb-2 text-gray-800">
                            Treatment Details
                        </h5>

                        <!-- Treatment Details Table -->
                        <div class="overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300 border-separate border-spacing-0">
                                <thead>
                                    <tr>
                                        <th colspan="2"
                                            class="bg-blue-600 text-white px-4 py-3 text-left font-semibold border-[0.2px] border-gray-600">
                                            Standard Practice
                                        </th>
                                        <th colspan="2"
                                            class="bg-green-600 text-white px-4 py-3 text-left font-semibold border-[0.2px] border-gray-600">
                                            Leads Agri Treatment
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Product:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.control.product }}
                                        </td>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Product:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.leads_agri.product }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Rate:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.control.rate }}
                                        </td>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Rate:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.leads_agri.rate }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Timing:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.control.timing }}
                                        </td>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Timing:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.leads_agri.timing }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Method:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.control.method }}
                                        </td>
                                        <td
                                            class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black font-semibold">
                                            <b>Method:</b>
                                        </td>
                                        <td class="bg-white border-[0.2px] border-gray-600 px-4 py-3 text-black">
                                            {{ currentReport.analysis.treatment_comparison.leads_agri.method }}
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-3 text-sm md:text-base leading-relaxed italic mt-4 px-2 md:px-4">
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 md:w-20 md:h-20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.944 11.944 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm md:text-base font-medium">Map visualization coming soon</p>
                </div>

                <!-- Key Findings & Strategic Insights -->
                <div class="bg-gray-100 p-8 rounded-2xl shadow-lg w-full">
                    <h2 class="text-xl font-semibold mb-6 text-gray-800">
                        Key Findings & Strategic Insights
                    </h2>

                    <!-- Opportunities -->
                    <div class="insight-item bg-gradient-to-r from-gray-100 to-gray-50 rounded-xl px-5 py-4 mb-3 flex items-center justify-between cursor-pointer shadow-soft hover:shadow-medium transition-all duration-300 border-2 border-transparent hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        @click="showOpportunitiesModal = true" tabindex="0" @keyup.enter="showOpportunitiesModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
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
                        @click="showRiskLimitationsModal = true" tabindex="0" @keyup.enter="showRiskLimitationsModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
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
                        @click="showExecutiveSummaryModal = true" tabindex="0" @keyup.enter="showExecutiveSummaryModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-secondary-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
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
                        @click="showRecommendationsModal = true" tabindex="0" @keyup.enter="showRecommendationsModal = true">
                        <span class="text-gray-800 text-lg font-bold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-primary-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
        <div v-else-if="!currentReport" class="flex flex-col items-center justify-center min-h-[440px] mt-10 px-4">
            <div class="relative flex flex-col items-center justify-center max-w-lg">
                <div class="bg-gradient-to-br from-gray-50 to-white w-28 h-28 md:w-32 md:h-32 rounded-full flex items-center justify-center shadow-large border-4 border-gray-200">
                    <span class="text-gray-400 text-5xl md:text-7xl font-semibold">?</span>
                </div>

                <!-- Text Section -->
                <div class="text-center mt-6 md:mt-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">
                        No Data Found
                    </h2>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed max-w-md mx-auto mb-6">
                        Upload a file and click the <span class="font-semibold text-primary-600">Analyze Demo Form</span> button to
                        show the analyzed result of your uploaded file.
                    </p>
                    <!-- CTA Button -->
                    <button 
                        @click="scrollToUpload"
                        class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-medium hover:shadow-glow transform hover:scale-105 active:scale-95 flex items-center gap-2 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V3.75m0 0L6.75 9m5.25-5.25L17.25 9M3.75 19.5h16.5" />
                        </svg>
                        Get Started
                    </button>
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
    max-height: 290px;
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