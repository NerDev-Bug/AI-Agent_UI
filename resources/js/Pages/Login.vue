<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F0F9FF] to-[#E0F7FA] px-4 py-4">
        <div class="bg-white/80 backdrop-blur-xl w-[470px] rounded-3xl shadow-2xl p-10 border border-[#E2E8F0]">

            <h3 class="text-center text-3xl font-extrabold text-[#0F172A] mb-8 tracking-wide drop-shadow">
                Product Demo Trials Analysis
            </h3>

            <form @submit.prevent="submit" class="space-y-6">

                <!-- Email -->
                <div>
                    <label class="block text-[#111827] font-semibold mb-2" for="email">
                        Email
                    </label>
                    <input id="email" name="email" type="email" v-model="form.user_email" class="w-full border border-gray-300 rounded-xl px-4 py-3 
                               focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                               transition-all shadow-sm" placeholder="Enter your email" />
                    <span v-if="form.errors.user_email" class="text-[14px] text-red-500 m-1">
                        {{ form.errors.user_email }}
                    </span>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-[#111827] font-semibold mb-2" for="password">
                        Password
                    </label>
                    <input id="password" name="password" type="password" v-model="form.password" class="w-full border border-gray-300 rounded-xl px-4 py-3 
                               focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9] 
                               transition-all shadow-sm" placeholder="Enter your password" />
                    <span v-if="form.errors.password" class="text-[14px] text-red-500 m-1">
                        {{ form.errors.password }}
                    </span>
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <!-- Login Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-[#0EA5E9] to-[#22D3EE]
                               hover:from-[#0284C7] hover:to-[#06B6D4]
                               text-white font-semibold py-3 rounded-2xl shadow-lg
                               transform hover:scale-[1.02] transition-all">
                        Login
                    </button>
                </div>

                <!-- Links -->
                <div class="flex justify-between mt-3">
                    <a href="#" class="text-[#0EA5E9] hover:text-[#0284C7] text-sm font-medium">
                        Forgot your password?
                    </a>

                    <a href="/register" class="text-gray-600 hover:text-[#0EA5E9] text-sm font-medium">
                        Don't have an account?
                    </a>
                </div>

            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Checkbox from './Components/Checkbox.vue'

const form = useForm({
    user_email: '',
    password: '',
})

const submit = () => {
    form.post('/login')   // route to backend
}
</script>
