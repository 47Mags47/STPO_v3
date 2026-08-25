import './bootstrap'
import './helpers';
import './libs/fortawesome.js';
import { initTheme } from './theme';
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import * as derectives from "./derectives";
import { ZiggyVue } from "ziggy-js";
import AuthLayout from "../views/layouts/AuthLayout.vue";

initTheme();

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("../views/pages/**/*.vue");

        const importPage = pages[`../views/pages/${name}.vue`];

        const page = await importPage();

        const exceptions = ['httpErrors/', 'NoEmail', 'SelectDivision', 'auth/']
        const isException = exceptions.some(n => name.startsWith(n))

        if (!isException) {
            page.default.layout ??= AuthLayout;
        }

        return page;
    },

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(ZiggyVue, Ziggy);
        app.directive("outsideClick", derectives.outsideClick);
        app.mount(el);
    },
});
