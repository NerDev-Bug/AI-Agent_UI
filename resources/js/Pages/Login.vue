<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-400 to-indigo-600 px-2 py-2">
        <div class="bg-white w-[420px] rounded-2xl shadow-2xl p-8">
            <h3 class="text-center text-3xl font-bold text-gray-800 mb-8">
                Product Demo Trials Analysis
            </h3>

            <form class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="email">
                        Email
                    </label>
                    <input id="email" name="email" type="email" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                        placeholder="Enter your email" />
                        <span class="text-[14px] text-red-400 m-2">Please type the correct Email</span>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="password">
                        Password
                    </label>
                    <input id="password" name="password" type="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                        placeholder="Enter your password" />
                        <span class="text-[14px] text-red-400 m-2">Please type the correct Password</span>
                </div>

                <div class="pt-4">
                    <button type="submit" name="submit"
                        class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 rounded-lg shadow-md transition duration-200">
                        Login
                    </button>
                </div>

                <div class="flex justify-between mt-2">
                    <div class="text-center">
                        <a href="#" class="text-sky-600 hover:text-sky-700 text-sm font-medium">
                            Forgot your password?
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="#" class="text-gray-500 hover:text-green-700 text-sm font-medium">
                            Don't have an account?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>

</script>
