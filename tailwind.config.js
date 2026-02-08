import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
                serif: ["Playfair Display", "serif"],
            },
            colors: {
                luxury: {
                    900: "#0f172a",
                    800: "#1e293b",
                    gold: "#d4af37",
                },
            },
        },
    },
    plugins: [forms],
};
