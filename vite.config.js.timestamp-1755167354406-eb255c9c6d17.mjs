// vite.config.js
import { defineConfig, loadEnv } from "file:///L:/laragon/www/sekolahku/node_modules/vite/dist/node/index.js";
import laravel from "file:///L:/laragon/www/sekolahku/node_modules/laravel-vite-plugin/dist/index.js";
import tailwindcss from "file:///L:/laragon/www/sekolahku/node_modules/tailwindcss/lib/index.js";
import path from "path";
var __vite_injected_original_dirname = "L:\\laragon\\www\\sekolahku";
var vite_config_default = defineConfig(({ command, mode }) => {
  const env = loadEnv(mode, process.cwd(), "");
  const activeTheme = env.VITE_ACTIVE_THEME || "default";
  console.log("\u{1F9E9} Active Theme:", activeTheme);
  const themeInputPath = `resources/themes/${activeTheme}/src`;
  const input = [
    `${themeInputPath}/app.css`,
    `${themeInputPath}/app.js`,
    "resources/js/backend/pd_non_active.js",
    "resources/js/backend/daftar-pd.js",
    "resources/js/backend/gtk.js"
  ];
  return {
    plugins: [
      laravel({
        input,
        refresh: true,
        buildDirectory: `build-themes/${activeTheme}`
      })
    ],
    css: {
      postcss: {
        plugins: [tailwindcss()]
      }
    },
    resolve: {
      alias: {
        "@": path.resolve(__vite_injected_original_dirname, "resources/js"),
        "~theme": path.resolve(__vite_injected_original_dirname, themeInputPath)
      }
    },
    build: {
      outDir: `public/build-themes/${activeTheme}`,
      rollupOptions: {
        output: {
          entryFileNames: `assets/[name].js`,
          chunkFileNames: `assets/[name]-[hash].js`,
          assetFileNames: `assets/[name].[ext]`
        }
      }
    }
  };
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJMOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxzZWtvbGFoa3VcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkw6XFxcXGxhcmFnb25cXFxcd3d3XFxcXHNla29sYWhrdVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vTDovbGFyYWdvbi93d3cvc2Vrb2xhaGt1L3ZpdGUuY29uZmlnLmpzXCI7Ly8gaW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG4vLyBpbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbi8vIGltcG9ydCB0YWlsd2luZGNzcyBmcm9tICd0YWlsd2luZGNzcyc7XG5cbi8vIGV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4vLyAgIHBsdWdpbnM6IFtcbi8vICAgICBsYXJhdmVsKHtcbi8vICAgICAgICAgaW5wdXQ6IFtcbi8vICAgICAgICAgICAgICdyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLFxuLy8gICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHAuanMnLFxuLy8gICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9iYWNrZW5kL3BkX25vbl9hY3RpdmUuanMnLFxuLy8gICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9iYWNrZW5kL2RhZnRhci1wZC5qcycsXG4vLyAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2JhY2tlbmQvZ3RrLmpzJyxcbi8vICAgICAgICAgICBdLFxuLy8gICAgICAgcmVmcmVzaDogdHJ1ZSxcbi8vICAgICB9KSxcbi8vICAgXSxcbi8vICAgY3NzOiB7XG4vLyAgICAgcG9zdGNzczoge1xuLy8gICAgICAgcGx1Z2luczogW3RhaWx3aW5kY3NzKCldLFxuLy8gICAgIH0sXG4vLyAgIH0sXG4vLyB9KTtcblxuaW1wb3J0IHsgZGVmaW5lQ29uZmlnLCBsb2FkRW52IH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB0YWlsd2luZGNzcyBmcm9tICd0YWlsd2luZGNzcyc7XG5pbXBvcnQgcGF0aCBmcm9tICdwYXRoJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKCh7IGNvbW1hbmQsIG1vZGUgfSkgPT4ge1xuICBjb25zdCBlbnYgPSBsb2FkRW52KG1vZGUsIHByb2Nlc3MuY3dkKCksICcnKTtcbiAgY29uc3QgYWN0aXZlVGhlbWUgPSBlbnYuVklURV9BQ1RJVkVfVEhFTUUgfHwgJ2RlZmF1bHQnO1xuXG4gIGNvbnNvbGUubG9nKCdcdUQ4M0VcdURERTkgQWN0aXZlIFRoZW1lOicsIGFjdGl2ZVRoZW1lKTtcblxuICBjb25zdCB0aGVtZUlucHV0UGF0aCA9IGByZXNvdXJjZXMvdGhlbWVzLyR7YWN0aXZlVGhlbWV9L3NyY2A7XG5cbiAgY29uc3QgaW5wdXQgPSBbXG4gICAgYCR7dGhlbWVJbnB1dFBhdGh9L2FwcC5jc3NgLFxuICAgIGAke3RoZW1lSW5wdXRQYXRofS9hcHAuanNgLFxuICAgICdyZXNvdXJjZXMvanMvYmFja2VuZC9wZF9ub25fYWN0aXZlLmpzJyxcbiAgICAncmVzb3VyY2VzL2pzL2JhY2tlbmQvZGFmdGFyLXBkLmpzJyxcbiAgICAncmVzb3VyY2VzL2pzL2JhY2tlbmQvZ3RrLmpzJyxcbiAgXTtcblxuICByZXR1cm4ge1xuICAgIHBsdWdpbnM6IFtcbiAgICAgIGxhcmF2ZWwoe1xuICAgICAgICBpbnB1dCxcbiAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgYnVpbGREaXJlY3Rvcnk6IGBidWlsZC10aGVtZXMvJHthY3RpdmVUaGVtZX1gLFxuICAgICAgfSksXG4gICAgXSxcbiAgICBjc3M6IHtcbiAgICAgIHBvc3Rjc3M6IHtcbiAgICAgICAgcGx1Z2luczogW3RhaWx3aW5kY3NzKCldLFxuICAgICAgfSxcbiAgICB9LFxuICAgIHJlc29sdmU6IHtcbiAgICAgIGFsaWFzOiB7XG4gICAgICAgICdAJzogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJ3Jlc291cmNlcy9qcycpLFxuICAgICAgICAnfnRoZW1lJzogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgdGhlbWVJbnB1dFBhdGgpLFxuICAgICAgfSxcbiAgICB9LFxuICAgIGJ1aWxkOiB7XG4gIG91dERpcjogYHB1YmxpYy9idWlsZC10aGVtZXMvJHthY3RpdmVUaGVtZX1gLFxuICByb2xsdXBPcHRpb25zOiB7XG4gICAgb3V0cHV0OiB7XG4gICAgICBlbnRyeUZpbGVOYW1lczogYGFzc2V0cy9bbmFtZV0uanNgLFxuICAgICAgY2h1bmtGaWxlTmFtZXM6IGBhc3NldHMvW25hbWVdLVtoYXNoXS5qc2AsXG4gICAgICBhc3NldEZpbGVOYW1lczogYGFzc2V0cy9bbmFtZV0uW2V4dF1gLFxuICAgIH0sXG4gIH0sXG59LFxuXG4gIH07XG59KTtcblxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQXdCQSxTQUFTLGNBQWMsZUFBZTtBQUN0QyxPQUFPLGFBQWE7QUFDcEIsT0FBTyxpQkFBaUI7QUFDeEIsT0FBTyxVQUFVO0FBM0JqQixJQUFNLG1DQUFtQztBQTZCekMsSUFBTyxzQkFBUSxhQUFhLENBQUMsRUFBRSxTQUFTLEtBQUssTUFBTTtBQUNqRCxRQUFNLE1BQU0sUUFBUSxNQUFNLFFBQVEsSUFBSSxHQUFHLEVBQUU7QUFDM0MsUUFBTSxjQUFjLElBQUkscUJBQXFCO0FBRTdDLFVBQVEsSUFBSSwyQkFBb0IsV0FBVztBQUUzQyxRQUFNLGlCQUFpQixvQkFBb0IsV0FBVztBQUV0RCxRQUFNLFFBQVE7QUFBQSxJQUNaLEdBQUcsY0FBYztBQUFBLElBQ2pCLEdBQUcsY0FBYztBQUFBLElBQ2pCO0FBQUEsSUFDQTtBQUFBLElBQ0E7QUFBQSxFQUNGO0FBRUEsU0FBTztBQUFBLElBQ0wsU0FBUztBQUFBLE1BQ1AsUUFBUTtBQUFBLFFBQ047QUFBQSxRQUNBLFNBQVM7QUFBQSxRQUNULGdCQUFnQixnQkFBZ0IsV0FBVztBQUFBLE1BQzdDLENBQUM7QUFBQSxJQUNIO0FBQUEsSUFDQSxLQUFLO0FBQUEsTUFDSCxTQUFTO0FBQUEsUUFDUCxTQUFTLENBQUMsWUFBWSxDQUFDO0FBQUEsTUFDekI7QUFBQSxJQUNGO0FBQUEsSUFDQSxTQUFTO0FBQUEsTUFDUCxPQUFPO0FBQUEsUUFDTCxLQUFLLEtBQUssUUFBUSxrQ0FBVyxjQUFjO0FBQUEsUUFDM0MsVUFBVSxLQUFLLFFBQVEsa0NBQVcsY0FBYztBQUFBLE1BQ2xEO0FBQUEsSUFDRjtBQUFBLElBQ0EsT0FBTztBQUFBLE1BQ1QsUUFBUSx1QkFBdUIsV0FBVztBQUFBLE1BQzFDLGVBQWU7QUFBQSxRQUNiLFFBQVE7QUFBQSxVQUNOLGdCQUFnQjtBQUFBLFVBQ2hCLGdCQUFnQjtBQUFBLFVBQ2hCLGdCQUFnQjtBQUFBLFFBQ2xCO0FBQUEsTUFDRjtBQUFBLElBQ0Y7QUFBQSxFQUVFO0FBQ0YsQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
