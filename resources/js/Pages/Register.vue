<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F0F9FF] to-[#E0F7FA] p-4">
        <div class="bg-white/80 backdrop-blur-xl w-full max-w-xl rounded-3xl shadow-2xl p-10 border border-[#E2E8F0]">

            <h3 class="text-center text-4xl font-extrabold text-[#0F172A] mb-10 tracking-wide drop-shadow">
                Sign Up
            </h3>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- Username -->
                <div class="space-y-1">
                    <label class="block text-[#111827] font-semibold">Username</label>
                    <input
                        type="text"
                        v-model="form.username"
                        placeholder="Enter your username"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 
                               focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                               transition-all shadow-sm"
                    />
                    <span v-if="form.errors.username" class="text-red-500 text-sm">
                        {{ form.errors.username }}
                    </span>
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label class="block text-[#111827] font-semibold">Email</label>
                    <input
                        type="email"
                        v-model="form.user_email"
                        placeholder="you@example.com"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 
                               focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                               transition-all shadow-sm"
                    />
                    <span v-if="form.errors.user_email" class="text-red-500 text-sm">
                        {{ form.errors.user_email }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Company -->
                    <div class="space-y-1">
                        <label class="block text-[#111827] font-semibold">Cooperative Company</label>
                        <input
                            type="text"
                            v-model="form.cooperative_company"
                            placeholder="Company or organization name"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 
                                   focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                                   transition-all shadow-sm"
                        />
                    </div>

                    <!-- Contact -->
                    <div class="space-y-1">
                        <label class="block text-[#111827] font-semibold">Contact Number</label>
                        <input
                            type="tel"
                            v-model="form.contact_number"
                            placeholder="+1 234 567 8900"
                            pattern="[0-9+\-\s()]*"
                            autocomplete="tel"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 
                                   focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                                   transition-all shadow-sm"
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label class="block text-[#111827] font-semibold">Password</label>
                    <input
                        type="password"
                        v-model="form.password"
                        placeholder="Create a strong password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 
                               focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                               transition-all shadow-sm"
                    />
                    <span v-if="form.errors.password" class="text-red-500 text-sm">
                        {{ form.errors.password }}
                    </span>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label class="block text-[#111827] font-semibold">Confirm Password</label>
                    <input
                        type="password"
                        v-model="form.password_confirmation"
                        placeholder="Re-enter your password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 
                               focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                               transition-all shadow-sm"
                    />
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#0EA5E9] to-[#22D3EE]
                           hover:from-[#0284C7] hover:to-[#06B6D4]
                           text-white font-bold py-3 rounded-2xl shadow-lg
                           transform hover:scale-[1.02] transition-all"
                >
                    Register
                </button>

                <!-- Links -->
                <div class="flex justify-end mt-3">
                    <a href="/" class="text-gray-600 hover:text-[#0EA5E9] text-sm font-medium">
                        Do have an account?
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    username: '',
    user_email: '',
    cooperative_company: '',
    contact_number: '',
    password: '',
    password_confirmation: '',
    role: 'user'
})

const submit = () => {
    form.post('/user_register')
}
</script>
