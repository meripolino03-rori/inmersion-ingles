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
            colors: {
                amalfi: {
                    DEFAULT: "#2E5AA7",
                    dark: "#1e3d73",
                },
                citrus: "#FFA62B",
                breeze: "#86C5FF",
                cream: "#F8E6A0",
            },
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
                heading: ["Poppins", "sans-serif"],
            },
            fontSize: {
                "display-lg": ["4rem", { lineHeight: "1", fontWeight: "800" }],
                "h1-size": ["2.5rem", { lineHeight: "1.2", fontWeight: "700" }],
                "card-title": [
                    "0.9rem",
                    { letterSpacing: "0.05em", fontWeight: "700" },
                ],
                metric: ["3rem", { lineHeight: "1", fontWeight: "800" }],
            },
        },
    },
    plugins: [forms],
};
