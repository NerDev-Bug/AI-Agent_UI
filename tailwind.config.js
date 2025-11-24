import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand Colors - Modern Green Palette
                brand: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a', // Primary brand green
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                },
                // Primary Colors
                primary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    DEFAULT: '#16a34a',
                    dark: '#15803d',
                    light: '#4ade80',
                },
                // Secondary Colors (Blue for metrics)
                secondary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    DEFAULT: '#2563eb',
                },
                // Background Colors - Elegant refined palette
                background: {
                    light: '#F5F7FA',
                    lighter: '#F8FAFC',
                    subtle: '#F1F5F9',
                    DEFAULT: '#ffffff',
                    glass: 'rgba(255, 255, 255, 0.7)',
                },
                // Accent Colors
                accent: {
                    yellow: '#fbbf24',
                    orange: '#f97316',
                    purple: '#a855f7',
                    pink: '#ec4899',
                },
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            boxShadow: {
                // Elegant refined shadows
                'soft': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03)',
                'medium': '0 4px 6px -1px rgba(0, 0, 0, 0.06), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                'large': '0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04)',
                'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.02)',
                'elegant': '0 4px 20px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04)',
                'elegant-lg': '0 10px 40px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04)',
                'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.1)',
                'glow': '0 0 20px rgba(34, 197, 94, 0.2)',
                'glow-blue': '0 0 20px rgba(37, 99, 235, 0.2)',
                'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.03)',
            },
            animation: {
                typewriter: "typewriter .7s steps(12) forwards",
                slideInLeft: 'slideInFromLeft 0.5s ease-out forwards',
                slideInRight: 'slideInFromRight 0.5s ease-out forwards',
                slideInUp: 'slideInFromUp 0.5s ease-out forwards',
                slideInDown: 'slideInFromDown 0.5s ease-out forwards',
                fadeIn: 'fadeIn 0.5s ease-out forwards',
                scaleIn: 'scaleIn 0.3s ease-out forwards',
                bounceIn: 'bounceIn 0.6s ease-out forwards',
                pulse: 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                float: 'float 3s ease-in-out infinite',
                shimmer: 'shimmer 2s linear infinite',
            },
            keyframes: {
                typewriter: {
                    to: {
                        left: "100%",
                    },
                },
                slideInFromLeft: {
                    '0%': { transform: 'translateX(-100%)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                slideInFromRight: {
                    '0%': { transform: 'translateX(100%)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                slideInFromUp: {
                    '0%': { transform: 'translateY(-100%)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                slideInFromDown: {
                    '0%': { transform: 'translateY(100%)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.9)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
                bounceIn: {
                    '0%': { transform: 'scale(0.3)', opacity: '0' },
                    '50%': { transform: 'scale(1.05)' },
                    '70%': { transform: 'scale(0.9)' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-1000px 0' },
                    '100%': { backgroundPosition: '1000px 0' },
                },
            },
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
                '800': '800ms',
            },
            transitionTimingFunction: {
                'bounce-in': 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
                'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',
            },
        },
    },

    plugins: [forms],
};
