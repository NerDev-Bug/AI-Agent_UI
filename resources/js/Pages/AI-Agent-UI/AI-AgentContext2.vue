<template>
    <section
        class="relative min-h-screen w-full overflow-hidden bg-gradient-to-br from-emerald-50/50 via-green-50/30 to-teal-50/50 flex items-center justify-center px-4 py-16 sm:py-20">
        <!-- Decorative Image -->
        <img src="/images/Pandoy.png" alt="Pandoy"
            class="hidden lg:block pointer-events-none absolute bottom-10 left-1/2 -translate-x-[200%] w-[220px] xl:w-[230px] bottom-[450px] z-10" />

        <!-- Cards Wrapper -->
        <div class="relative z-20 w-full max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Card 1 -->
                <div
                    class="group bg-white rounded-2xl border border-transparent p-6 sm:p-8 shadow-lg transform transition-all duration-500 hover:scale-110 hover:-translate-y-3 hover:shadow-2xl hover:shadow-primary-500/30 animate-slideInLeft group border-2 border-transparent hover:border-primary-200">
                    <div
                        class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 group-hover:scale-125 group-hover:rotate-6 transition-all duration-500 group-hover:shadow-lg">
                        <img src="/images/magic.png" alt="AI Magic Icon" class="h-10 w-10 object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>

                    <h3
                        class="mb-3 text-lg sm:text-xl font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                        AI-Powered Analysis
                    </h3>

                    <p class="text-sm sm:text-base leading-relaxed text-gray-700">
                        Automatically extract and analyze form fields, patterns, and user
                        behavior with advanced AI technology.
                    </p>
                </div>

                <!-- Card 2 -->
                <div
                    class="group bg-white rounded-2xl border border-transparent p-6 sm:p-8 shadow-lg transform transition-all duration-500 hover:scale-110 hover:-translate-y-3 hover:shadow-2xl hover:shadow-secondary-500/30 animate-slideInUp group border-2 border-transparent hover:border-secondary-200">
                    <div
                        class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-secondary-100 to-secondary-200 group-hover:scale-125 group-hover:rotate-6 transition-all duration-500 group-hover:shadow-lg">
                        <img src="/images/graph.png" alt="Dashboard Icon" class="h-10 w-10 object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>

                    <h3
                        class="mb-3 text-lg sm:text-xl font-semibold text-gray-900 group-hover:text-secondary-600 transition-colors">
                        Interactive Dashboard
                    </h3>

                    <p class="text-sm sm:text-base leading-relaxed text-gray-700">
                        Visualize form metrics, completion rates, and conversion insights
                        with clean, interactive charts.
                    </p>
                </div>

                <!-- Card 3 -->
                <div
                    class="group bg-white rounded-2xl border border-transparent p-6 sm:p-8 shadow-lg transform transition-all duration-500 hover:scale-110 hover:-translate-y-3 hover:shadow-2xl hover:shadow-primary-500/30 animate-slideInRight group border-2 border-transparent hover:border-primary-200">
                    <div
                        class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 group-hover:scale-125 group-hover:rotate-6 transition-all duration-500 group-hover:shadow-lg">
                        <img src="/images/flash.png" alt="Lightning Icon" class="h-10 w-10 object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>

                    <h3
                        class="mb-3 text-lg sm:text-xl font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                        Instant Insights
                    </h3>

                    <p class="text-sm sm:text-base leading-relaxed text-gray-700">
                        Get actionable recommendations to improve form performance and
                        drive better results.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
