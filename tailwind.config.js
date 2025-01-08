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
                "blue-dark": "#050C9C", // Biru Tua
                "blue-light": "#3ABEF9", // Biru Muda
                "blue-bright": "#A7E6FF", // Biru Terang
                "white-custom": "#FBFBFB", // Putih
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', "sans-serif"], // Tambahkan font di sini
            },
        },
    },

    plugins: [forms],
};
