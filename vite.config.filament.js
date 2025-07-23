import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/filament/admin/theme.css"],
            refresh: [
                ...refreshPaths,
                "app/Filament/**",
                "app/Providers/Filament/**",
            ],
        }),
    ],
    css: {
        postcss: {
            plugins: [tailwindcss(), autoprefixer()],
        },
    },
    build: {
        outDir: "public/build/filament",
    },
});
