import './bootstrap'
import './helpers';
import './reset';
import * as derectives from "./derectives";
import { initTheme } from './theme';
import { initSeason } from './season.js';
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js";
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import MainLayout from '../views/layouts/MainLayout.vue';
import LoadingOverlay from '../views/components/LoadingOverlay.vue';

initTheme();
initSeason();

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("../views/pages/**/*.vue");

        const importPage = pages[`../views/pages/${name}.vue`];

        const page = await importPage();

        const exceptions = ['httpErrors/', 'NoEmail']
        const isException = exceptions.some(n => name.startsWith(n))

        if (!isException) {
            page.default.layout ??= MainLayout;
        }

        return page;
    },

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => [
            h(App, props),
            h(LoadingOverlay),
        ]});

        const pinia = createPinia();
        pinia.use(piniaPluginPersistedstate);

        app.use(plugin);
        app.use(pinia);
        app.use(ZiggyVue, Ziggy);
        app.directive("outsideClick", derectives.outsideClick);
        app.mount(el);
    },
});
