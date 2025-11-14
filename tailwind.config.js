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
            animations: {
                typewriter: "typewriter .7s steps(12) forwards",
                slideInLeft: 'slideInFromLeft 0.5s ease-out forwards',
            },
            keyframes: {
                typewriter: {
                    to: {
                        left: "100%",
                    },
                },
                slideInFromLeft: {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(0)' },
                  },
            },
        },
    },

    plugins: [forms],
};
