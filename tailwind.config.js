import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    safelist: [
        {
            pattern: /./,
        },
    ],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#0A2E5C",
                accent: "#D4AF37",
                "background-light": "#f6f7f8",
                "background-dark": "#111121",
            },
            fontFamily: {
                display: ["Inter", "sans-serif"],
            },
            borderRadius: {
                DEFAULT: "0.25rem",
                lg: "0.5rem",
                xl: "0.75rem",
                full: "9999px",
            },
        },
    },

    plugins: [forms],
};
