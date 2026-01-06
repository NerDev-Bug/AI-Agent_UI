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

                    <div class="relative">
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'"
                            v-model="form.password" class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12
                   focus:ring-4 focus:ring-[#22D3EE]/40 focus:border-[#0EA5E9]
                   transition-all shadow-sm" placeholder="Enter your password" />

                        <!-- Eye Icon -->
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-gray-600">
                            <!-- Eye -->
                            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Off -->
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19
                         c-4.478 0-8.268-2.943-9.542-7
                         a9.956 9.956 0 012.042-3.368" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.223 6.223A9.956 9.956 0 0112 5
                         c4.478 0 8.268 2.943 9.542 7
                         a9.978 9.978 0 01-4.132 5.411" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <span v-if="form.errors.password" class="text-[14px] text-red-500 m-1">
                        {{ form.errors.password }}
                    </span>
                </div>

                <!-- Remember Me -->
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
                    <a type="button" @click="showForgotPassword = true"
                        class="text-[#0EA5E9] hover:text-[#0284C7] text-sm font-medium">
                        Forgot your password?
                    </a>

                    <a href="/register" class="text-gray-600 hover:text-[#0EA5E9] text-sm font-medium">
                        Don't have an account?
                    </a>
                </div>
            </form>
        </div>
    </div>
    <transition name="modal-fade" appear>
        <ForgotPassword v-if="showForgotPassword" @close="showForgotPassword = false" />
    </transition>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import Checkbox from './Components/Checkbox.vue'
import ForgotPassword from './Modals/ForgotPassword.vue'

const showForgotPassword = ref(false)
const showPassword = ref(false)

const form = useForm({
    user_email: '',
    password: '',
})

const submit = () => {
    form.post('/login')   // route to backend
}
</script>
<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
}

.modal-fade-enter-to,
.modal-fade-leave-from {
    opacity: 1;
    transform: scale(1);
}
</style>
