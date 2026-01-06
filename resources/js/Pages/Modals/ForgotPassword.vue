<template>
    <div
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        @click.self="$emit('close')"
    >
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
            <h3 class="text-xl font-bold mb-4">Forgot Password</h3>
            <p class="text-gray-600 mb-4">
                Enter your email to receive a password reset link.
            </p>

            <input
                type="email"
                placeholder="Email"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4"
            />

            <div class="flex justify-end space-x-2">
                <button
                    @click="$emit('close')"
                    class="px-4 py-2 bg-gray-200 rounded-lg"
                >
                    Cancel
                </button>
                <button
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg"
                >
                    Send Reset Link
                </button>
            </div>
        </div>
    </div>
</template>
