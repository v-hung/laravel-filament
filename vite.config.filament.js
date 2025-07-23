import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/filament/admin/theme.css"],
            refresh: [
                // ...refreshPaths,
                "./app/Filament/**/*.php",
                "./resources/views/filament/**/*.blade.php",
                "./vendor/filament/**/*.blade.php",
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
