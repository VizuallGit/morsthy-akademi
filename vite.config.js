import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

/**
 * Tailwind @source watches Antlers/Blade/content. On Vite 7 that triggers a
 * full page reload on every template save (Cursor autosave → constant stutter).
 * Keep CSS HMR for those files; never full-reload the browser for them.
 */
function suppressTemplateFullReload() {
    return {
        name: 'suppress-template-full-reload',
        handleHotUpdate({ file, modules }) {
            if (!/\.(antlers\.html|blade\.php|html|md|yaml|yml)$/.test(file)) {
                return;
            }

            // Prefer CSS-only HMR (new utility classes still appear). Returning
            // [] would silence updates entirely until CSS/JS is touched.
            const cssRelated = new Set();

            for (const mod of modules) {
                if (/\.css/.test(mod.url ?? '') || /\.css/.test(mod.id ?? '')) {
                    cssRelated.add(mod);
                }

                for (const importer of mod.importers ?? []) {
                    if (/\.css/.test(importer.url ?? '') || /\.css/.test(importer.id ?? '')) {
                        cssRelated.add(importer);
                    }
                }
            }

            return [...cssRelated];
        },
    };
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/site.css', 'resources/js/site.js'],
            // Blade/Antlers full-reload is handled (suppressed) above.
            refresh: false,
        }),
        suppressTemplateFullReload(),
        tailwindcss(),
    ],
    server: {
        // Always reclaim 5173 so a stale Vite can't leave public/hot on another port.
        strictPort: true,
        watch: {
            ignored: [
                // Statamic rewrites cache/sessions/stache on EVERY request.
                // Watching any of it creates a self-sustaining reload loop
                // (request → cache write → full-reload → request …). Ignore
                // all of storage/ — nothing there should ever trigger HMR.
                '**/storage/**',
                '**/content/**',
                '**/users/**',
                '**/public/build/**',
                '**/public/vendor/**',
                '**/vendor/**',
            ],
        },
    },
});
